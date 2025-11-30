<?php
require_once('../partials/check_session.php');
require_once('../db_connect.php');

if (!isset($_GET['nrp'])) {
    header("Location: restore_mahasiswa.php?status=no_nrp");
    exit();
}

$nrp = $_GET['nrp'];

$sql = "UPDATE mahasiswa SET deleted_at = NULL WHERE nrp = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $nrp);

if ($stmt->execute()) {
    header("Location: restore_mahasiswa.php?status=restored");
} else {
    header("Location: restore_mahasiswa.php?status=error");
}
exit();