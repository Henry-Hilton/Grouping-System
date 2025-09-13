<?php
// admin/add_dosen_process.php
require_once('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize all inputs
    $npk = htmlspecialchars($_POST['npk']);
    $nama = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password']; // We don't sanitize the password before hashing
    
    // --- Step 1: Create the Lecturer Record ---
    $sql_insert_dosen = "INSERT INTO dosen (npk, nama) VALUES (?, ?)";
    $stmt_insert_dosen = $mysqli->prepare($sql_insert_dosen);
    $stmt_insert_dosen->bind_param("ss", $npk, $nama);
    
    // Execute the first insert
    if ($stmt_insert_dosen->execute()) {
        
        // --- Step 2: Create the Account Record ---
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Note: nrp_mahasiswa is NULL because this is a lecturer account
        $sql_insert_akun = "INSERT INTO akun (username, password, npk_dosen) VALUES (?, ?, ?)";
        $stmt_insert_akun = $mysqli->prepare($sql_insert_akun);
        $stmt_insert_akun->bind_param("sss", $username, $hashed_password, $npk);
        $stmt_insert_akun->execute();
        
        // --- Step 3: Handle the optional photo upload ---
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $photo_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
            
            // Update the dosen record with the photo extension
            $sql_update_photo = "UPDATE dosen SET foto_extension = ? WHERE npk = ?";
            $stmt_update_photo = $mysqli->prepare($sql_update_photo);
            $stmt_update_photo->bind_param("ss", $photo_extension, $npk);
            $stmt_update_photo->execute();
            
            // Move the uploaded file
            $target_dir = "../assets/images/dosen/";
            $target_file = $target_dir . $npk . '.' . $photo_extension;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
        }
        
        // Redirect on success
        header("Location: manage_dosen.php?status=success_add");
        exit();
        
    } else {
        // Handle insertion error
        header("Location: manage_dosen.php?status=error_add");
        exit();
    }
}
?>