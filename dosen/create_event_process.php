<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idgrup = htmlentities($_POST['idgrup']);
    $judul = htmlentities($_POST['judul']);
    $tanggal = htmlentities($_POST['tanggal']);
    $jenis = htmlentities($_POST['jenis']);
    $keterangan = htmlentities($_POST['keterangan']);

    $sql = "INSERT INTO event (idgrup, judul, tanggal, jenis, keterangan) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("issss", $idgrup, $judul, $tanggal, $jenis, $keterangan);

    if ($stmt->execute()) {
        header("Location: group_details.php?id=" . $idgrup . "&status=event_added");
        exit();
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>