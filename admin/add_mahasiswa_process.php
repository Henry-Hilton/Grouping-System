<?php
// admin/add_mahasiswa_process.php
$required_role = 'admin';
require_once('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize all inputs
    $nrp = htmlspecialchars($_POST['nrp']);
    $nama = htmlspecialchars($_POST['nama']);
    $gender = htmlspecialchars($_POST['gender']);
    $tanggal_lahir = htmlspecialchars($_POST['tanggal_lahir']);
    $angkatan = htmlspecialchars($_POST['angkatan']);
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password']; // Password will be hashed, not sanitized
    
    // --- Step 1: Create the Student Record ---
    $sql_insert_mahasiswa = "INSERT INTO mahasiswa (nrp, nama, gender, tanggal_lahir, angkatan) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert_mahasiswa = $mysqli->prepare($sql_insert_mahasiswa);
    $stmt_insert_mahasiswa->bind_param("ssssi", $nrp, $nama, $gender, $tanggal_lahir, $angkatan);
    
    if ($stmt_insert_mahasiswa->execute()) {
        
        // --- Step 2: Create the Account Record ---
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Note: npk_dosen is NULL because this is a student account
        $sql_insert_akun = "INSERT INTO akun (username, password, nrp_mahasiswa) VALUES (?, ?, ?)";
        $stmt_insert_akun = $mysqli->prepare($sql_insert_akun);
        $stmt_insert_akun->bind_param("sss", $username, $hashed_password, $nrp);
        $stmt_insert_akun->execute();

        // --- Step 3: Handle optional photo upload ---
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $photo_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
            
            $sql_update_photo = "UPDATE mahasiswa SET foto_extention = ? WHERE nrp = ?";
            $stmt_update_photo = $mysqli->prepare($sql_update_photo);
            $stmt_update_photo->bind_param("ss", $photo_extension, $nrp);
            $stmt_update_photo->execute();
            
            $target_dir = "../assets/images/mahasiswa/";
            $target_file = $target_dir . $nrp . '.' . $photo_extension;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
        }
        
        header("Location: manage_mahasiswa.php?status=success_add");
        exit();
        
    } else {
        header("Location: manage_mahasiswa.php?status=error_add");
        exit();
    }
}
?>