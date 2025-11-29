<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../db_connect.php');

if (isset($_POST['nrp']) && isset($_POST['idgrup'])) {
    $nrp = $_POST['nrp'];
    $idgrup = $_POST['idgrup'];
    $my_username = $_SESSION['username'];

    $sql_check = "SELECT idgrup FROM grup WHERE idgrup = ? AND username_pembuat = ?";
    $stmt_check = $mysqli->prepare($sql_check);
    $stmt_check->bind_param("is", $idgrup, $my_username);
    $stmt_check->execute();

    if ($stmt_check->get_result()->num_rows === 0) {
        echo "error_permission";
        exit();
    }

    $sql_get_user = "SELECT username FROM akun WHERE nrp_mahasiswa = ?";
    $stmt_get_user = $mysqli->prepare($sql_get_user);
    $stmt_get_user->bind_param("s", $nrp);
    $stmt_get_user->execute();
    $res_user = $stmt_get_user->get_result();

    if ($res_user->num_rows === 0) {
        echo "error_no_account";
        exit();
    }

    $row_user = $res_user->fetch_assoc();
    $student_username = $row_user['username'];

    $sql = "INSERT INTO member_grup (idgrup, username) VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("is", $idgrup, $student_username);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error_db";
    }
}
?>