<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../db_connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idevent = $_GET['id'];
    $idgrup = $_GET['idgrup']; // Passed to redirect back correctly

    $sql = "DELETE FROM event WHERE idevent = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $idevent);

    if ($stmt->execute()) {
        header("Location: group_details.php?id=" . $idgrup . "&status=event_deleted");
        exit();
    }
}
// Fallback
header("Location: index.php");
?>