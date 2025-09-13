<?php
// admin/add_mahasiswa_process.php
require_once('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize all inputs
    $nrp = htmlspecialchars($_POST['nrp']);
    $nama = htmlspecialchars($_POST['nama']);
    $gender = htmlspecialchars($_POST['gender']);
    $tanggal_lahir = htmlspecialchars($_POST['tanggal_lahir']);
    $angkatan = htmlspecialchars($_POST['angkatan']);
    
    $photo_extension = null;

    // Handle the file upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "../assets/images/mahasiswa/";
        $photo_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . $nrp . '.' . $photo_extension;
        
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
    }

    // Insert data into the mahasiswa table
    $sql_insert = "INSERT INTO mahasiswa (nrp, nama, gender, tanggal_lahir, angkatan) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $mysqli->prepare($sql_insert);
    // Note the type string "ssssi" for four strings and one integer
    $stmt_insert->bind_param("ssssi", $nrp, $nama, $gender, $tanggal_lahir, $angkatan);
    
    if ($stmt_insert->execute()) {
        // If a photo was uploaded, update the record with the file extension
        if ($photo_extension !== null) {
            $sql_update = "UPDATE mahasiswa SET foto_extention = ? WHERE nrp = ?";
            $stmt_update = $mysqli->prepare($sql_update);
            $stmt_update->bind_param("ss", $photo_extension, $nrp);
            $stmt_update->execute();
        }
        
        header("Location: manage_mahasiswa.php?status=success_add");
        exit();
        
    } else {
        header("Location: manage_mahasiswa.php?status=error_add");
        exit();
    }
}
?>