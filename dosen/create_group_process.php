<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../classes/Database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = htmlentities($_POST['nama']);
    $deskripsi = htmlentities($_POST['deskripsi']);
    $jenis = htmlentities($_POST['jenis']);

    $username_pembuat = $_SESSION['username'];

    $sql_check_name = "SELECT idgrup FROM grup WHERE nama = ?";
    $stmt_name = $mysqli->prepare($sql_check_name);
    $stmt_name->bind_param("s", $nama);
    $stmt_name->execute();
    if ($stmt_name->get_result()->num_rows > 0) {
        header("Location: create_group.php?error=duplicate_name");
        exit();
    }

    $unique = false;
    $kode_pendaftaran = '';

    while (!$unique) {
        $kode_pendaftaran = strtoupper(substr(md5(time() . rand()), 0, 6));

        $sql_check_code = "SELECT idgrup FROM grup WHERE kode_pendaftaran = ?";
        $stmt_code = $mysqli->prepare($sql_check_code);
        $stmt_code->bind_param("s", $kode_pendaftaran);
        $stmt_code->execute();

        if ($stmt_code->get_result()->num_rows == 0) {
            $unique = true;
        }
    }

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