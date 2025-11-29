<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idevent = $_POST['idevent'];
    $idgrup = $_POST['idgrup'];
    $judul = htmlentities($_POST['judul']);
    $tanggal = $_POST['tanggal'];
    $jenis = $_POST['jenis'];
    $keterangan = htmlentities($_POST['keterangan']);

    $sql = "UPDATE event SET judul=?, tanggal=?, jenis=?, keterangan=? WHERE idevent=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssi", $judul, $tanggal, $jenis, $keterangan, $idevent);

    if ($stmt->execute()) {
        header("Location: group_details.php?id=" . $idgrup . "&status=event_updated");
        exit();
    } else {
        echo "Error updating record: " . $mysqli->error;
    }
}
?>