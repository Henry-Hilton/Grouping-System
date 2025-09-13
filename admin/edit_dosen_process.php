<?php
// admin/edit_dosen_process.php
require_once('../db_connect.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize text inputs
    $npk = htmlspecialchars($_POST['npk']);
    $nama = htmlspecialchars($_POST['nama']);
    
    // --- Update the text data first ---
    $sql_update_text = "UPDATE dosen SET nama = ? WHERE npk = ?";
    $stmt_update_text = $mysqli->prepare($sql_update_text);
    $stmt_update_text->bind_param("ss", $nama, $npk);
    $stmt_update_text->execute();
    
    // --- Handle optional new file upload ---
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "../assets/images/dosen/";
        $photo_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . $npk . '.' . $photo_extension;
        
        // Move the new uploaded file, overwriting the old one if it exists
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

        // Update the database with the new photo extension
        $sql_update_photo = "UPDATE dosen SET foto_extension = ? WHERE npk = ?";
        $stmt_update_photo = $mysqli->prepare($sql_update_photo);
        $stmt_update_photo->bind_param("ss", $photo_extension, $npk);
        $stmt_update_photo->execute();
    }
    
    // Redirect back to the management page
    header("Location: manage_dosen.php?status=success_update");
    exit();
    
} else {
    // Redirect if accessed directly without POST method
    header("Location: manage_dosen.php");
    exit();
}
?>