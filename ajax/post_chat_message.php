<?php

session_start();
require_once '../classes/Database.php';

if (!isset($_SESSION['username'])) {
    echo "Error: User not logged in";
    exit;
}

$db = new Database();

if (isset($_POST['message']) && isset($_POST['idthread'])) {
    $msg = trim($_POST['message']);
    $thread = $_POST['idthread'];
    $user = $_SESSION['username'];
    $now = date("Y-m-d H:i:s");

    if (!empty($msg)) {
        $sql = "INSERT INTO chat (idthread, username_pembuat, isi, tanggal_pembuatan) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            echo "SQL Error: " . $db->conn->error;
            exit;
        }

        $stmt->bind_param("isss", $thread, $user, $msg, $now);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Database Error: " . $stmt->error;
        }
    } else {
        echo "Error: Empty message";
    }
} else {
    echo "Error: Missing data";
}
?>