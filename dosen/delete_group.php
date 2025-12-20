<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../classes/Database.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idgrup = $_GET['id'];
    $my_username = $_SESSION['username'];

    $sql_check = "SELECT idgrup FROM grup WHERE idgrup = ? AND username_pembuat = ?";
    $stmt_check = $mysqli->prepare($sql_check);
    $stmt_check->bind_param("is", $idgrup, $my_username);
    $stmt_check->execute();

    if ($stmt_check->get_result()->num_rows === 0) {
        header("Location: index.php?error=unauthorized");
        exit();
    }

    $sql_del_members = "DELETE FROM member_grup WHERE idgrup = ?";
    $stmt_del_members = $mysqli->prepare($sql_del_members);
    $stmt_del_members->bind_param("i", $idgrup);
    $stmt_del_members->execute();

    $sql_del_events = "DELETE FROM event WHERE idgrup = ?";
    $stmt_del_events = $mysqli->prepare($sql_del_events);
    $stmt_del_events->bind_param("i", $idgrup);
    $stmt_del_events->execute();

    $sql_del_group = "DELETE FROM grup WHERE idgrup = ?";
    $stmt_del_group = $mysqli->prepare($sql_del_group);
    $stmt_del_group->bind_param("i", $idgrup);

    if ($stmt_del_group->execute()) {
        header("Location: index.php?status=group_deleted");
        exit();
    } else {
        echo "Error deleting group: " . $mysqli->error;
    }

} else {
    header("Location: index.php");
}
?>