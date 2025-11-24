<?php
require_once('../db_connect.php');

if (isset($_POST['nrp']) && isset($_POST['idgrup'])) {
    $nrp = $_POST['nrp'];
    $idgrup = $_POST['idgrup'];

    $sql = "INSERT INTO member_grup (idgrup, username) VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("is", $idgrup, $nrp);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>