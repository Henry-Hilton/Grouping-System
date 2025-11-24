<?php
$required_role = 'mahasiswa';
require_once('../partials/check_session.php');
require_once('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode = htmlentities($_POST['kode']);
    $nrp = $_SESSION['username'];

    $sql_find = "SELECT idgrup FROM grup WHERE kode_pendaftaran = ?";
    $stmt_find = $mysqli->prepare($sql_find);
    $stmt_find->bind_param("s", $kode);
    $stmt_find->execute();
    $result_find = $stmt_find->get_result();

    if ($result_find->num_rows == 0) {
        header("Location: join_group.php?error=invalid_code");
        exit();
    }

    $group = $result_find->fetch_assoc();
    $idgrup = $group['idgrup'];

    $sql_check = "SELECT * FROM member_grup WHERE idgrup = ? AND username = ?";
    $stmt_check = $mysqli->prepare($sql_check);
    $stmt_check->bind_param("is", $idgrup, $nrp);
    $stmt_check->execute();

    if ($stmt_check->get_result()->num_rows > 0) {
        header("Location: join_group.php?error=already_joined");
        exit();
    }

    $sql_join = "INSERT INTO member_grup (idgrup, username) VALUES (?, ?)";
    $stmt_join = $mysqli->prepare($sql_join);
    $stmt_join->bind_param("is", $idgrup, $nrp);

    if ($stmt_join->execute()) {
        header("Location: index.php?status=success_join");
    } else {
        echo "Error joining group.";
    }
}
?>