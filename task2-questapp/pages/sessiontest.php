<?php
session_start();
echo '<h2>BU TEST AMAÇLIDIR. GERÇEK KULLANIMDA OLMAYACAKTIR</h2>';
echo '<h2>Session İçeriği:</h2>';
echo '<pre>';
print_r($_SESSION); 
echo '</pre>';

if (isset($_SESSION['user_id'])) {
    echo '<p>Kullanıcı ID: ' . $_SESSION['user_id'] . '</p>';
} else {
    echo '<p>Kullanıcı ID oturumda mevcut değil.</p>';
}

if (isset($_SESSION['rolid'])) {
    echo '<p>Kullanıcı Rol ID: ' . $_SESSION['rolid'] . '</p>';
} else {
    echo '<p>Rol ID oturumda mevcut değil.</p>';
}

?>
