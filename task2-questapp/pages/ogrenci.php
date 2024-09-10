<?php
include('../utils/db.php');
include('../utils/functions.php');

checkLogin();
checkRole('2');

$stmt = $db->prepare("
    SELECT * FROM soru 
    WHERE id NOT IN (SELECT soru_id FROM submissions WHERE user_id = :user_id)
    ORDER BY id ASC
    LIMIT 1
");
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$question = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer']) && $question) {
    $answer = $_POST['answer'];

    if ($answer === $question['dogru_cevap_sikki']) {
        $zorluk_seviyesi = $question['zorluk_seviyesi'];
        $puan = ($zorluk_seviyesi == 1) ? 10 : (($zorluk_seviyesi == 2) ? 20 : 30);

        $stmt = $db->prepare("INSERT INTO submissions (user_id, soru_id, puan) VALUES (:user_id, :soru_id, :puan)");
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->bindParam(':soru_id', $question['id']);
        $stmt->bindParam(':puan', $puan);
        $stmt->execute();

        echo "Doğru cevap! Puan kazandınız: $puan";
    } else {
        $stmt = $db->prepare("INSERT INTO submissions (user_id, soru_id, puan) VALUES (:user_id, :soru_id, 0)");
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->bindParam(':soru_id', $question['id']);
        $stmt->execute();

        echo "Yanlış cevap, 0 puan!";
    }

    header("Location: ogrenci.php");
    exit();
}

if (isset($_GET['finish']) && $_GET['finish'] === 'true') {
    $stmt = $db->prepare("
        SELECT COUNT(*) AS total_questions, 
               COUNT(sub.id) AS answered_questions 
        FROM soru s
        LEFT JOIN submissions sub ON s.id = sub.soru_id AND sub.user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $total_questions = $result['total_questions'];
    $answered_questions = $result['answered_questions'];

    if ($answered_questions === $total_questions) {
        $total_score = 0;
        $stmt = $db->prepare("
            SELECT s.zorluk_seviyesi, sub.puan
            FROM submissions sub
            JOIN soru s ON sub.soru_id = s.id
            WHERE sub.user_id = :user_id
        ");
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($questions as $question) {
            $total_score += $question['puan'];
        }

        if (isset($_GET['sifirla']) && $_GET['sifirla'] === 'true') {
            $stmt = $db->prepare("DELETE FROM submissions WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->execute();
            echo "Puanınız sıfırlandı. Teste yeniden başlayabilirsiniz!";
            exit();
        }

        echo "Tüm sorular çözüldü! Toplam puanınız: $total_score. <br>";
        echo "Puanınızı sıfırlamak için <a href='ogrenci.php?finish=true&sifirla=true'>buraya tıklayın</a>.";
    } else {
        echo "Çözülecek sorular var!";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/web-server/stil.css">
    <meta charset="UTF-8">
    <title>Öğrenci Sayfası</title>
</head>
<body>
    <div class="container">
        <h1>Öğrenci Sayfası</h1>
        <?php if ($question): ?>
            <form method="POST" action="ogrenci.php">
                <p><?php echo htmlspecialchars($question['soru_metni']); ?></p>
                <select name="answer" id="answer"> 
                    <option value="a">a</option>
                    <option value="b">b</option>
                    <option value="c">c</option>
                    <option value="d">d</option>
                </select>
                <button type="submit">Gönder</button>
            </form>
        
        <?php else: ?>
        <div class="container">
            <p>Çözülecek başka soru kalmadı!</p>
            <p>Toplam puanınızı görmek ve sıfırlamak için:</p>
            <ul>
                <li><a href="ogrenci.php?finish=true">Toplam puanı göster</a></li>
                <li><a href="ogrenci.php?finish=true&sifirla=true">Puanı sıfırla ve teste geri başla</a></li>
            </ul>
        <?php endif; ?>
        </div>
    </div>
</body>
</html>
