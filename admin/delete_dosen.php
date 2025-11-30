<?php
$required_role = 'admin';
require_once('../partials/check_session.php');
require_once('../db_connect.php');

if (!isset($_GET['npk'])) {
    header("Location: manage_dosen.php?status=error_no_npk");
    exit();
}

$npk = $_GET['npk'];

$sql_select = "SELECT foto_extension FROM dosen WHERE npk = ? AND deleted_at IS NULL";
$stmt_select = $mysqli->prepare($sql_select);
$stmt_select->bind_param("s", $npk);
$stmt_select->execute();
$result = $stmt_select->get_result();
$dosen = $result->fetch_assoc();

if (!$dosen) {
    header("Location: manage_dosen.php?status=error_not_found");
    exit();
}

$photo_extension = $dosen['foto_extension'];

$sql_delete = "UPDATE dosen SET deleted_at = NOW() WHERE npk = ?";
$stmt_delete = $mysqli->prepare($sql_delete);
$stmt_delete->bind_param("s", $npk);

if ($stmt_delete->execute()) {
    header("Location: manage_dosen.php?status=success_delete");
    exit();
} else {
    header("Location: manage_dosen.php?status=error_delete");
    exit();
}
?>