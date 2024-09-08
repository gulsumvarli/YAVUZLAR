<?php
include('../utils/db.php');

function startSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();


    }
}

function checkLogin() {
    startSession();
    if (!isset($_SESSION['rolid'])) {
        header("Location: ../pages/index.php");
        exit();
    }
}

function checkRole($role) {
    startSession();
    if ($_SESSION['rolid'] !== $role) {
        header("Location: ../pages/index.php");
        exit();
    }
}

function addQuestion($db, $dogru_cevap_sikki, $a_sikki, $b_sikki, $c_sikki, $d_sikki, $soru_metni, $zorluk_seviyesi) {
    $stmt = $db->prepare("INSERT INTO soru (dogru_cevap_sikki, a_sikki, b_sikki, c_sikki, d_sikki, soru_metni, zorluk_seviyesi) VALUES (:dogru_cevap_sikki, :a_sikki, :b_sikki, :c_sikki, :d_sikki, :soru_metni, :zorluk_seviyesi)");
    $stmt->bindParam(':dogru_cevap_sikki', $dogru_cevap_sikki);
    $stmt->bindParam(':a_sikki', $a_sikki);
    $stmt->bindParam(':b_sikki', $b_sikki);
    $stmt->bindParam(':c_sikki', $c_sikki);
    $stmt->bindParam(':d_sikki', $d_sikki);
    $stmt->bindParam(':soru_metni', $soru_metni);
    $stmt->bindParam(':zorluk_seviyesi', $zorluk_seviyesi);
    $stmt->execute();
}
function updateQuestion($db, $id, $dogru_cevap_sikki, $a_sikki, $b_sikki, $c_sikki, $d_sikki, $soru_metni, $zorluk_seviyesi) {
    $stmt = $db->prepare("UPDATE soru SET dogru_cevap_sikki = :dogru_cevap_sikki, a_sikki = :a_sikki, b_sikki = :b_sikki, c_sikki = :c_sikki, d_sikki = :d_sikki, soru_metni = :soru_metni, zorluk_seviyesi = :zorluk_seviyesi WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':dogru_cevap_sikki', $dogru_cevap_sikki);
    $stmt->bindParam(':a_sikki', $a_sikki);
    $stmt->bindParam(':b_sikki', $b_sikki);
    $stmt->bindParam(':c_sikki', $c_sikki);
    $stmt->bindParam(':d_sikki', $d_sikki);
    $stmt->bindParam(':soru_metni', $soru_metni);
    $stmt->bindParam(':zorluk_seviyesi', $zorluk_seviyesi);
    
    if ($stmt->execute()) {
        return true; 
    } else {
        return false; //başarısızsa
    }
}


function deleteQuestion($id) {
    global $db;

    $stmt = $db->prepare("DELETE FROM soru WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        return true; 
    } else {
        return false; //başarısızsa
    }
}