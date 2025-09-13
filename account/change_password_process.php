<?php
// account/change_password_process.php
session_start();
require_once('../db_connect.php');

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. Check if new passwords match
    if ($new_password !== $confirm_password) {
        header("Location: change_password.php?error=New passwords do not match.");
        exit();
    }

    // 2. Verify the old password
    $sql_select = "SELECT password FROM akun WHERE username = ?";
    $stmt_select = $mysqli->prepare($sql_select);
    $stmt_select->bind_param("s", $username);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($old_password, $user['password'])) {
        // 3. Old password is correct, hash the new password
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // 4. Update the database
        $sql_update = "UPDATE akun SET password = ? WHERE username = ?";
        $stmt_update = $mysqli->prepare($sql_update);
        $stmt_update->bind_param("ss", $new_hashed_password, $username);
        $stmt_update->execute();

        header("Location: change_password.php?success=1");
        exit();
    } else {
        // Old password was incorrect
        header("Location: change_password.php?error=Incorrect old password.");
        exit();
    }
}
?>