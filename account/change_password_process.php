<?php
session_start();
require_once('../db_connect.php');


if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    
    if ($new_password !== $confirm_password) {
        header("Location: change_password.php?error=New passwords do not match.");
        exit();
    }

    
    $sql_select = "SELECT password FROM akun WHERE username = ?";
    $stmt_select = $mysqli->prepare($sql_select);
    $stmt_select->bind_param("s", $username);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($old_password, $user['password'])) {
        
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        
        $sql_update = "UPDATE akun SET password = ? WHERE username = ?";
        $stmt_update = $mysqli->prepare($sql_update);
        $stmt_update->bind_param("ss", $new_hashed_password, $username);
        $stmt_update->execute();

        header("Location: change_password.php?success=1");
        exit();
    } else {
        
        header("Location: change_password.php?error=Incorrect old password.");
        exit();
    }
}
?>