<?php
// admin/add_dosen_process.php
require_once('../db_connect.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize text inputs for security
    $npk = htmlspecialchars($_POST['npk']);
    $nama = htmlspecialchars($_POST['nama']);
    
    $photo_extension = null;

    // --- Handle the file upload ---
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "../assets/images/dosen/";
        $photo_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . $npk . '.' . $photo_extension;
        
        // Move the uploaded file to the target directory
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
    }

    // --- Insert data into the database ---
    
    // First, insert the record without the photo extension
    $sql_insert = "INSERT INTO dosen (npk, nama) VALUES (?, ?)";
    $stmt_insert = $mysqli->prepare($sql_insert);
    $stmt_insert->bind_param("ss", $npk, $nama);
    
    if ($stmt_insert->execute()) {
        // If a photo was uploaded, update the record with the file extension
        if ($photo_extension !== null) {
            $sql_update = "UPDATE dosen SET foto_extension = ? WHERE npk = ?";
            $stmt_update = $mysqli->prepare($sql_update);
            $stmt_update->bind_param("ss", $photo_extension, $npk);
            $stmt_update->execute();
        }
        
        // Redirect back to the management page on success
        header("Location: manage_dosen.php?status=success_add");
        exit();
        
    } else {
        // Handle insertion error
        header("Location: manage_dosen.php?status=error_add");
        exit();
    }
}
?>