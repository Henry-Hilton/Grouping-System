<?php
// admin/edit_mahasiswa_process.php
$required_role = 'admin';
require_once('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize all inputs
    $nrp = htmlspecialchars($_POST['nrp']);
    $nama = htmlspecialchars($_POST['nama']);
    $gender = htmlspecialchars($_POST['gender']);
    $tanggal_lahir = htmlspecialchars($_POST['tanggal_lahir']);
    $angkatan = htmlspecialchars($_POST['angkatan']);
    
    // Update the text data
    $sql_update_text = "UPDATE mahasiswa SET nama = ?, gender = ?, tanggal_lahir = ?, angkatan = ? WHERE nrp = ?";
    $stmt_update_text = $mysqli->prepare($sql_update_text);
    $stmt_update_text->bind_param("sssis", $nama, $gender, $tanggal_lahir, $angkatan, $nrp);
    $stmt_update_text->execute();
    
    // Handle optional new file upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "../assets/images/mahasiswa/";
        $photo_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . $nrp . '.' . $photo_extension;
        
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

        // Update the database with the new photo extension
        $sql_update_photo = "UPDATE mahasiswa SET foto_extention = ? WHERE nrp = ?";
        $stmt_update_photo = $mysqli->prepare($sql_update_photo);
        $stmt_update_photo->bind_param("ss", $photo_extension, $nrp);
        $stmt_update_photo->execute();
    }
    
    header("Location: manage_mahasiswa.php?status=success_update");
    exit();
    
} else {
    header("Location: manage_mahasiswa.php");
    exit();
}
?>