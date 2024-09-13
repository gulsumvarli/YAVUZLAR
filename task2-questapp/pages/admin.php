<?php
include('../utils/db.php');
include('../utils/functions.php');


checkLogin();
checkRole(3);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question']) && isset($_POST['dogru_cevap_sikki']) && isset($_POST['a_sikki']) && isset($_POST['b_sikki']) && isset($_POST['c_sikki']) && isset($_POST['d_sikki']) && isset($_POST['zorluk_seviyesi'])) {
    $soru_metni = $_POST['question'];
    $dogru_cevap_sikki = $_POST['dogru_cevap_sikki'];
    $a_sikki = $_POST['a_sikki'];
    $b_sikki = $_POST['b_sikki'];
    $c_sikki = $_POST['c_sikki'];
    $d_sikki = $_POST['d_sikki'];
    $zorluk_seviyesi = $_POST['zorluk_seviyesi'];

    addQuestion($db, $dogru_cevap_sikki, $a_sikki, $b_sikki, $c_sikki, $d_sikki, $soru_metni, $zorluk_seviyesi);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_question_id'])) {
    $update_question_id = $_POST['update_question_id'];
    $update_question = $_POST['update_question'];
    $update_dogru_cevap_sikki = $_POST['update_dogru_cevap_sikki'];
    $update_a_sikki = $_POST['update_a_sikki'];
    $update_b_sikki = $_POST['update_b_sikki'];
    $update_c_sikki = $_POST['update_c_sikki'];
    $update_d_sikki = $_POST['update_d_sikki'];
    $update_zorluk_seviyesi = $_POST['update_zorluk_seviyesi'];

    updateQuestion($db, $update_question_id, $update_dogru_cevap_sikki, $update_a_sikki, $update_b_sikki, $update_c_sikki, $update_d_sikki, $update_question, $update_zorluk_seviyesi);
}

$questions = $db->query("SELECT * FROM soru")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
        <link rel="stylesheet" href="/web-server/stil.css">
    <title>Admin Panel</title>
</head>
<body style="height:auto">
    <div class="container">
        <h1>Admin Paneli</h1>
        <h2><a href="skortablosu.php">SKOR TABLOSU</a></h2>

        <form method="POST" action="admin.php">
            <label for="question">Soru Metni</label>
            <textarea name="question" id="question" required>Soruyu buraya yazınız.</textarea>
            
            <label for="dogru_cevap_sikki">Doğru Cevap</label>
            <select name="dogru_cevap_sikki" id="dogru_cevap_sikki"> 
                <option value="a">a</option>
                <option value="b">b</option>
                <option value="c">c</option>
                <option value="d">d</option>
            </select>

            <label for="a_sikki">A Şıkkı</label>
            <input type="text" name="a_sikki" id="a_sikki" placeholder="A Şıkkı" required>

            <label for="b_sikki">B Şıkkı</label>
            <input type="text" name="b_sikki" id="b_sikki" placeholder="B Şıkkı" required>

            <label for="c_sikki">C Şıkkı</label>
            <input type="text" name="c_sikki" id="c_sikki" placeholder="C Şıkkı" required>

            <label for="d_sikki">D Şıkkı</label>
            <input type="text" name="d_sikki" id="d_sikki" placeholder="D Şıkkı" required>

            <label for="zorluk_seviyesi">Zorluk Seviyesi</label>
            <select name="zorluk_seviyesi" id="zorluk_seviyesi" required>
                <option value="1">Kolay</option>
                <option value="2">Orta</option>
                <option value="3">Zor</option>
            </select>

            <button type="submit">Soru Ekle</button>
        </form>

        <h2>Mevcut Sorular</h2>
        <ul>
            <?php foreach ($questions as $question): ?>
                <li>
                    <form method="POST" action="admin.php" style="display: inline;">
                        <input type="hidden" name="update_question_id" value="<?php echo htmlspecialchars($question['id']); ?>">
                        <textarea name="update_question" required><?php echo htmlspecialchars($question['soru_metni']); ?></textarea>
                        <input type="text" name="update_a_sikki" value="<?php echo htmlspecialchars($question['a_sikki']); ?>" required>
                        <input type="text" name="update_b_sikki" value="<?php echo htmlspecialchars($question['b_sikki']); ?>" required>
                        <input type="text" name="update_c_sikki" value="<?php echo htmlspecialchars($question['c_sikki']); ?>" required>
                        <input type="text" name="update_d_sikki" value="<?php echo htmlspecialchars($question['d_sikki']); ?>" required>
                        <select name="update_dogru_cevap_sikki" required>
                            <option value="a" <?php echo $question['dogru_cevap_sikki'] === 'a' ? 'selected' : ''; ?>>a</option>
                            <option value="b" <?php echo $question['dogru_cevap_sikki'] === 'b' ? 'selected' : ''; ?>>b</option>
                            <option value="c" <?php echo $question['dogru_cevap_sikki'] === 'c' ? 'selected' : ''; ?>>c</option>
                            <option value="d" <?php echo $question['dogru_cevap_sikki'] === 'd' ? 'selected' : ''; ?>>d</option>
                        </select>
                        <select name="update_zorluk_seviyesi" required>
                            <option value="1" <?php echo $question['zorluk_seviyesi'] == 1 ? 'selected' : ''; ?>>Kolay</option>
                            <option value="2" <?php echo $question['zorluk_seviyesi'] == 2 ? 'selected' : ''; ?>>Orta</option>
                            <option value="3" <?php echo $question['zorluk_seviyesi'] == 3 ? 'selected' : ''; ?>>Zor</option>
                        </select>
                        </br>
                        </br>
                        <button type="submit">Güncelle</button>
                    </form>
                    <form method="POST" action="delete_confirm.php" style="display: inline;">
                        <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($question['id']); ?>">
                        <button type="submit">Sil</button>
                    </form>
                    </br>
                        </br>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
