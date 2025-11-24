<?php
$required_role = 'mahasiswa';
require_once('../partials/check_session.php');
require_once('../db_connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idgrup = $_GET['id'];
    $nrp = $_SESSION['username'];

    $sql = "DELETE FROM member_grup WHERE idgrup = ? AND username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("is", $idgrup, $nrp);

    if ($stmt->execute()) {
        header("Location: index.php?status=left_group");
    } else {
        echo "Error leaving group.";
    }
} else {
    header("Location: index.php");
}
?>