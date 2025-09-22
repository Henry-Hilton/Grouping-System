<?php
// admin/delete_mahasiswa.php
$required_role = 'admin';
require_once('../partials/check_session.php');
require_once('../db_connect.php');

// Check if NRP is set in the URL
if (!isset($_GET['nrp'])) {
    header("Location: manage_mahasiswa.php?status=error_no_nrp");
    exit();
}

$nrp = $_GET['nrp'];

// --- Step 1: Get the photo extension BEFORE deleting the record ---
$sql_select = "SELECT foto_extention FROM mahasiswa WHERE nrp = ?";
$stmt_select = $mysqli->prepare($sql_select);
$stmt_select->bind_param("s", $nrp);
$stmt_select->execute();
$result = $stmt_select->get_result();
$mahasiswa = $result->fetch_assoc();

if ($mahasiswa) {
    $photo_extension = $mahasiswa['foto_extention'];

    // --- Step 2: Delete the database record ---
    $sql_delete = "DELETE FROM mahasiswa WHERE nrp = ?";
    $stmt_delete = $mysqli->prepare($sql_delete);
    $stmt_delete->bind_param("s", $nrp);

    if ($stmt_delete->execute()) {
        // --- Step 3: If DB deletion is successful, delete the photo file ---
        if (!empty($photo_extension)) {
            $file_path = "../assets/images/mahasiswa/" . $nrp . "." . $photo_extension;
            if (file_exists($file_path)) {
                unlink($file_path); // Deletes the file
            }
        }
        
        header("Location: manage_mahasiswa.php?status=success_delete");
        exit();

    } else {
        header("Location: manage_mahasiswa.php?status=error_delete");
        exit();
    }
} else {
    // If no student found with that NRP
    header("Location: manage_mahasiswa.php?status=error_not_found");
    exit();
}
?>