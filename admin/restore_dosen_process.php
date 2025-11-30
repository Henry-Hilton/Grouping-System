<?php
require_once('../partials/check_session.php');
require_once('../db_connect.php');

if (!isset($_GET['npk'])) {
    header("Location: restore_dosen.php?status=no_npk");
    exit();
}

$npk = $_GET['npk'];

$sql = "UPDATE dosen SET deleted_at = NULL WHERE npk = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $npk);

if ($stmt->execute()) {
    header("Location: restore_dosen.php?status=restored");
} else {
    header("Location: restore_dosen.php?status=error");
}
exit();