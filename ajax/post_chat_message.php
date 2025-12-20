<?php
session_start();
require_once 'classes/Database.php';

if (!isset($_SESSION['username'])) {
    echo "error_login";
    exit;
}

$db = new Database();

if (isset($_POST['message']) && isset($_POST['idthread'])) {
    $msg = $_POST['message'];
    $thread = $_POST['idthread'];
    $user = $_SESSION['username'];

    $now = date("Y-m-d H:i:s");

    $sql = "INSERT INTO chat (idthread, username_pembuat, isi, tanggal_pembuatan) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("isss", $thread, $user, $msg, $now);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>