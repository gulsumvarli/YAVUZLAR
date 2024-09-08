<?php
try {
    $db = new PDO('sqlite:C:\xampp\htdocs\web-server\deneme.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
    exit();
}
