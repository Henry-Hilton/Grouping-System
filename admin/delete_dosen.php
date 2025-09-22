<?php
// admin/delete_dosen.php
$required_role = 'admin';
require_once('../partials/check_session.php');
require_once('../db_connect.php');

// Check if NPK is set in the URL
if (!isset($_GET['npk'])) {
    header("Location: manage_dosen.php?status=error_no_npk");
    exit();
}

$npk = $_GET['npk'];

// --- Step 1: Get the photo extension BEFORE deleting the record ---
$sql_select = "SELECT foto_extension FROM dosen WHERE npk = ?";
$stmt_select = $mysqli->prepare($sql_select);
$stmt_select->bind_param("s", $npk);
$stmt_select->execute();
$result = $stmt_select->get_result();
$dosen = $result->fetch_assoc();

$photo_extension = $dosen['foto_extension'];

// --- Step 2: Delete the database record ---
$sql_delete = "DELETE FROM dosen WHERE npk = ?";
$stmt_delete = $mysqli->prepare($sql_delete);
$stmt_delete->bind_param("s", $npk);

if ($stmt_delete->execute()) {
    // --- Step 3: If DB deletion is successful, delete the photo file ---
    if (!empty($photo_extension)) {
        $file_path = "../assets/images/dosen/" . $npk . "." . $photo_extension;
        if (file_exists($file_path)) {
            unlink($file_path); // Deletes the file
        }
    }
    
    header("Location: manage_dosen.php?status=success_delete");
    exit();

} else {
    header("Location: manage_dosen.php?status=error_delete");
    exit();
}
?>