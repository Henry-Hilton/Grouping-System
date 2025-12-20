<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../classes/Database.php');

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idgrup = $_POST['idgrup'];
    $nama = htmlentities($_POST['nama']);
    $deskripsi = htmlentities($_POST['deskripsi']);
    $jenis = htmlentities($_POST['jenis']);
    $username = $_SESSION['username'];

    $sql_check = "SELECT idgrup FROM grup WHERE idgrup = ? AND username_pembuat = ?";
    $stmt_check = $db->prepare($sql_check);
    $stmt_check->bind_param("is", $idgrup, $username);
    $stmt_check->execute();

    if ($stmt_check->get_result()->num_rows === 0) {
        header("Location: index.php?error=unauthorized");
        exit();
    }

    $sql = "UPDATE grup SET nama = ?, deskripsi = ?, jenis = ? WHERE idgrup = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssi", $nama, $deskripsi, $jenis, $idgrup);

    if ($stmt->execute()) {
        header("Location: group_details.php?id=$idgrup&status=updated");
    } else {
        echo "Error updating group.";
    }
}
?>