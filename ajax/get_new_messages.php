<?php
// get_new_messages.php
session_start();
// Make sure this path to Database.php is correct based on where this file is located!
require_once 'classes/Database.php';

// Check if user is logged in
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
        // We add a flag 'is_me' to help the Frontend style the bubbles (Left vs Right)
        $row['is_me'] = ($row['username_pembuat'] == $currentUser);
        // Format the date nicely
        $row['formatted_time'] = date('d M, H:i', strtotime($row['tanggal_pembuatan']));
        $chats[] = $row;
    }

    // Return data as JSON for the Javascript to process
    echo json_encode($chats);
}
?>