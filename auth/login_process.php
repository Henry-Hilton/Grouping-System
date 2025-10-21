<?php
require_once('../db_connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $sql = "SELECT username, password, isadmin, npk_dosen, nrp_mahasiswa FROM akun WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    
    if ($user && password_verify($password, $user['password'])) {
        
        $_SESSION['username'] = $user['username'];
        $_SESSION['isadmin'] = $user['isadmin'];
        
        
        $_SESSION['npk_dosen'] = $user['npk_dosen'];
        $_SESSION['nrp_mahasiswa'] = $user['nrp_mahasiswa'];
        
        
        if ($user['isadmin'] == 1) {
            
            header("Location: ../admin/index.php");
        } else if ($user['npk_dosen'] !== null) {
            
            header("Location: ../dosen/index.php");
        } else if ($user['nrp_mahasiswa'] !== null) {
            
            header("Location: ../mahasiswa/index.php");
        } else {
            
            header("Location: login.php?error=unknown_role");
        }
        exit();

    } else {
        
        header("Location: login.php?error=1");
        exit();
    }
}
?>