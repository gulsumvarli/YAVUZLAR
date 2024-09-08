<?php
include('../utils/db.php');
include('../utils/functions.php');

checkLogin();
checkRole('3');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    if (deleteQuestion($id)) {
        header('Location: admin.php');
        exit();
    } else {
        echo "Silme işlemi başarısız oldu.";
    }
} else {
    header('Location: admin.php');
    exit();
}
?>
