<?php

session_start(); 
session_unset(); // Oturumdaki tüm değişkenleri temizle
session_destroy(); // Oturumu sonlandır
header("Location: index.php"); 
exit();
?>
