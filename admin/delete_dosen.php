<?php
require_once('../db_connect.php');

if (isset($_GET['npk'])) {
    $npk = $_GET['npk'];

    $sql_find_user = "SELECT username FROM akun WHERE npk_dosen = ?";
    $stmt_find = $mysqli->prepare($sql_find_user);
    $stmt_find->bind_param("s", $npk);
    $stmt_find->execute();
    $result_user = $stmt_find->get_result();

    if ($result_user->num_rows > 0) {
        $row = $result_user->fetch_assoc();
        $username = $row['username'];

        $sql_del_groups = "DELETE FROM grup WHERE username_pembuat = ?";
        $stmt_groups = $mysqli->prepare($sql_del_groups);
        $stmt_groups->bind_param("s", $username);
        $stmt_groups->execute();

        $sql_del_akun = "DELETE FROM akun WHERE username = ?";
        $stmt_akun = $mysqli->prepare($sql_del_akun);
        $stmt_akun->bind_param("s", $username);
        $stmt_akun->execute();
    }

    $sql_del_dosen = "DELETE FROM dosen WHERE npk = ?";
    $stmt_dosen = $mysqli->prepare($sql_del_dosen);
    $stmt_dosen->bind_param("s", $npk);

    if ($stmt_dosen->execute()) {
        header("Location: manage_dosen.php?status=success_delete");
    } else {
        echo "Error deleting lecturer: " . $mysqli->error;
    }
} else {
    header("Location: manage_dosen.php");
}
?>