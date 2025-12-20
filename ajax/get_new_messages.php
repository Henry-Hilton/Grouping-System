<?php
session_start();
require_once 'classes/Database.php';

if (!isset($_SESSION['username'])) {
    echo json_encode([]);
    exit;
}

$db = new Database();

if (isset($_POST['idthread'])) {
    $idthread = $_POST['idthread'];
    $currentUser = $_SESSION['username'];

    $sql = "SELECT c.*, 
            COALESCE(d.nama, m.nama, c.username_pembuat) as sender_name 
            FROM chat c 
            LEFT JOIN dosen d ON c.username_pembuat = d.npk 
            LEFT JOIN mahasiswa m ON c.username_pembuat = m.nrp 
            WHERE c.idthread = ? 
            ORDER BY c.tanggal_pembuatan ASC";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $idthread);
    $stmt->execute();
    $result = $stmt->get_result();

    $chats = [];
    while ($row = $result->fetch_assoc()) {
        $row['is_me'] = ($row['username_pembuat'] == $currentUser);
        $row['formatted_time'] = date('d M, H:i', strtotime($row['tanggal_pembuatan']));
        $chats[] = $row;
    }
    echo json_encode($chats);
}
?>