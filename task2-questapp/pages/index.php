<?php
include('../utils/db.php');
include('../utils/functions.php');
$isLoggedIn = isset($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM user WHERE isim = :username AND passw = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        startSession(); 

        $_SESSION['user_id'] = $user['id ']; //"id "boşluk veritabanı hatası + üşenme

        $_SESSION['rolid'] = $user['rolid'];

        
        if ($user['rolid'] === '3') { //admin id3 ayarladım
            header("Location: admin.php");
        } else {
            header("Location: ogrenci.php");
        }
        exit();
    } else {
        echo "Hatalı kullanıcı adı veya şifre";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/web-server/stil.css">
    <title>Giriş Yap</title>
</head>
<body>

<div class="x1">
    <h1>Giriş Yap</h1>
    <form method="POST" action="index.php">
        <input type="text" name="username" placeholder="Kullanıcı Adı" required>
        <input type="password" name="password" placeholder="Şifre" required>
        <button type="submit">Giriş Yap</button>
    </form>
    <a href="logout.php">Çıkış yap/ Session Temizle</a>
</div>

</body>
</html>
