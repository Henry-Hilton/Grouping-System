<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
header('Content-Type: application/json');

require_once '../classes/Database.php';

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
    if ($stmt) {
        $stmt->bind_param("i", $idthread);
        $stmt->execute();
        $result = $stmt->get_result();
        $chats = [];

        while ($row = $result->fetch_assoc()) {
            $chats[] = [
                'is_me' => ($row['username_pembuat'] === $currentUser),
                'sender_name' => htmlentities($row['sender_name']),
                'isi' => nl2br(htmlentities($row['isi'])),
                'formatted_time' => date('H:i', strtotime($row['tanggal_pembuatan']))
            ];
        }
        echo json_encode($chats);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>