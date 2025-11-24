<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../db_connect.php');

if (isset($_GET['idgrup']) && isset($_GET['nrp'])) {
    $idgrup = $_GET['idgrup'];
    $nrp = $_GET['nrp'];

    $check_sql = "SELECT username_pembuat FROM grup WHERE idgrup = ?";
    $stmt_check = $mysqli->prepare($check_sql);
    $stmt_check->bind_param("i", $idgrup);
    $stmt_check->execute();
    $res = $stmt_check->get_result()->fetch_assoc();

    if ($res['username_pembuat'] == $_SESSION['username']) {
        $sql = "DELETE FROM member_grup WHERE idgrup = ? AND username = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("is", $idgrup, $nrp);
        $stmt->execute();
    }
}

header("Location: manage_members.php?id=" . $_GET['idgrup']);
exit();
?>