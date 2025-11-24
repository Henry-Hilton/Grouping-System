<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = htmlentities($_POST['nama']);
    $deskripsi = htmlentities($_POST['deskripsi']);
    $jenis = htmlentities($_POST['jenis']);
    $kode_pendaftaran = htmlentities($_POST['kode_pendaftaran']);

    $username_pembuat = $_SESSION['username'];

    $tanggal_pembentukan = date('Y-m-d H:i:s');

    $sql = "INSERT INTO grup (username_pembuat, nama, deskripsi, tanggal_pembentukan, jenis, kode_pendaftaran) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssss", $username_pembuat, $nama, $deskripsi, $tanggal_pembentukan, $jenis, $kode_pendaftaran);

    if ($stmt->execute()) {
        header("Location: index.php?status=group_created");
        exit();
    } else {
        header("Location: create_group.php?error=failed_to_create");
        exit();
    }
}
?>