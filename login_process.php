<?php
// login_process.php
require_once('db_connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use a prepared statement to prevent SQL injection
    $sql = "SELECT username, password, isadmin FROM akun WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify user exists and password is correct
    if ($user && password_verify($password, $user['password'])) {
        // Password is correct, start the session
        $_SESSION['username'] = $user['username'];
        $_SESSION['isadmin'] = $user['isadmin'];
        
        // Redirect based on user role
        if ($user['isadmin'] == 1) {
            header("Location: admin/index.php");
        } else {
            // We will add redirects for dosen and mahasiswa here later
            header("Location: index.php"); // Default redirect
        }
        exit();

    } else {
        // Invalid credentials, redirect back to login with an error
        header("Location: login.php?error=1");
        exit();
    }
}
?>