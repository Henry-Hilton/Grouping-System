<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../classes/Database.php');

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idgrup = htmlentities($_POST['idgrup']);
    $judul = htmlentities($_POST['judul']);
    $tanggal = htmlentities($_POST['tanggal']);
    $jenis = htmlentities($_POST['jenis']);
    $keterangan = htmlentities($_POST['keterangan']);

    $sql_check_title = "SELECT idevent FROM event WHERE idgrup = ? AND judul = ?";
    $stmt_title = $db->prepare($sql_check_title);
    $stmt_title->bind_param("is", $idgrup, $judul);
    $stmt_title->execute();

    if ($stmt_title->get_result()->num_rows > 0) {
        header("Location: create_event.php?idgrup=$idgrup&error=duplicate_title");
        exit();
    }

    $formatted_date = date('Y-m-d H:i:s', strtotime($tanggal));

    $sql_check_date = "SELECT idevent FROM event WHERE idgrup = ? AND tanggal = ?";
    $stmt_date = $db->prepare($sql_check_date);
    $stmt_date->bind_param("is", $idgrup, $formatted_date);
    $stmt_date->execute();

    if ($stmt_date->get_result()->num_rows > 0) {
        header("Location: create_event.php?idgrup=$idgrup&error=duplicate_time");
        exit();
    }

    $sql = "INSERT INTO event (idgrup, judul, tanggal, jenis, keterangan) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("issss", $idgrup, $judul, $tanggal, $jenis, $keterangan);

    if ($stmt->execute()) {
        header("Location: group_details.php?id=" . $idgrup . "&status=event_added");
        exit();
    } else {
        echo "Error: " . $db->mysqli->error;
    }
}
?>