<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../classes/Database.php');

if (isset($_GET['idgrup']) && isset($_GET['nrp'])) {
    $idgrup = $_GET['idgrup'];
    $nrp = $_GET['nrp'];
    $my_username = $_SESSION['username'];

    $check_sql = "SELECT username_pembuat FROM grup WHERE idgrup = ?";
    $stmt_check = $mysqli->prepare($check_sql);
    $stmt_check->bind_param("i", $idgrup);
    $stmt_check->execute();
    $res = $stmt_check->get_result()->fetch_assoc();

    if ($res && $res['username_pembuat'] == $my_username) {
        $sql_find_user = "SELECT username FROM akun WHERE nrp_mahasiswa = ?";
        $stmt_find = $mysqli->prepare($sql_find_user);
        $stmt_find->bind_param("s", $nrp);
        $stmt_find->execute();
        $res_user = $stmt_find->get_result();

        if ($res_user->num_rows > 0) {
            $row = $res_user->fetch_assoc();
            $target_username = $row['username'];

            $sql = "DELETE FROM member_grup WHERE idgrup = ? AND username = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("is", $idgrup, $target_username);
            $stmt->execute();
        }
    }
}

header("Location: manage_members.php?id=" . $_GET['idgrup']);
exit();
?>