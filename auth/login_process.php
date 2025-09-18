<?php
// login_process.php
require_once('db_connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use a prepared statement to prevent SQL injection
    $sql = "SELECT username, password, isadmin, npk_dosen, nrp_mahasiswa FROM akun WHERE username = ?";
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
        
        // Add other user details to session if needed
        $_SESSION['npk_dosen'] = $user['npk_dosen'];
        $_SESSION['nrp_mahasiswa'] = $user['nrp_mahasiswa'];
        
        // Redirect based on user role
        if ($user['isadmin'] == 1) {
            // User is an Admin
            header("Location: ../admin/index.php");
        } else if ($user['npk_dosen'] !== null) {
            // User is a Lecturer
            header("Location: ../dosen/index.php");
        } else if ($user['nrp_mahasiswa'] !== null) {
            // User is a Student
            header("Location: ../mahasiswa/index.php");
        } else {
            // Fallback for any other unknown user type
            header("Location: login.php?error=unknown_role");
        }
        exit();

    } else {
        // Invalid credentials, redirect back to login with an error
        header("Location: login.php?error=1");
        exit();
    }
}
?>