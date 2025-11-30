<?php
$required_role = 'admin';
require_once('../partials/check_session.php');
require_once('../db_connect.php');

if (!isset($_GET['nrp'])) {
    header("Location: manage_mahasiswa.php?status=error_no_nrp");
    exit();
}

$nrp = $_GET['nrp'];

$sql_select = "SELECT foto_extension FROM mahasiswa WHERE nrp = ? AND deleted_at IS NULL";
$stmt_select = $mysqli->prepare($sql_select);
$stmt_select->bind_param("s", $nrp);
$stmt_select->execute();
$result = $stmt_select->get_result();
$mahasiswa = $result->fetch_assoc();

if (!$mahasiswa) {
    header("Location: manage_mahasiswa.php?status=error_not_found");
    exit();
}

$photo_extension = $mahasiswa['foto_extension'];

$sql_delete = "UPDATE mahasiswa SET deleted_at = NOW() WHERE nrp = ?";
$stmt_delete = $mysqli->prepare($sql_delete);
$stmt_delete->bind_param("s", $nrp);

if ($stmt_delete->execute()) {
    header("Location: manage_mahasiswa.php?status=success_delete");
    exit();
} else {
    header("Location: manage_mahasiswa.php?status=error_delete");
    exit();
}
?>