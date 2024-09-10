<?php
// Doğru yolu belirlemek için __DIR__ kullanarak bir üst dizine çıkıyoruz

try {
    // Veritabanı dosyasını dinamik olarak ana dizin olan web-server altındaki database klasöründen alıyoruz
    $dbPath = __DIR__ . '/../deneme.db'; 
    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
    exit();
}
