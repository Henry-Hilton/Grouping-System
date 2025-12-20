<?php
require_once('.../classes/Database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $npk = htmlentities($_POST['npk']);
    $nama = htmlentities($_POST['nama']);
    $username = htmlentities($_POST['username']);
    $password = $_POST['password'];

    $sql_check_npk = "SELECT npk FROM dosen WHERE npk = ?";
    $stmt_check_npk = $mysqli->prepare($sql_check_npk);
    $stmt_check_npk->bind_param("s", $npk);
    $stmt_check_npk->execute();
    $result_npk = $stmt_check_npk->get_result();

    if ($result_npk->num_rows > 0) {
        header("Location: add_dosen.php?error=duplicate_npk");
        exit();
    }

    $sql_check_user = "SELECT username FROM akun WHERE username = ?";
    $stmt_check_user = $mysqli->prepare($sql_check_user);
    $stmt_check_user->bind_param("s", $username);
    $stmt_check_user->execute();
    $result_user = $stmt_check_user->get_result();

    if ($result_user->num_rows > 0) {
        header("Location: add_dosen.php?error=duplicate_username");
        exit();
    }

    $sql_insert_dosen = "INSERT INTO dosen (npk, nama) VALUES (?, ?)";
    $stmt_insert_dosen = $mysqli->prepare($sql_insert_dosen);
    $stmt_insert_dosen->bind_param("ss", $npk, $nama);

    if ($stmt_insert_dosen->execute()) {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql_insert_akun = "INSERT INTO akun (username, password, npk_dosen) VALUES (?, ?, ?)";
        $stmt_insert_akun = $mysqli->prepare($sql_insert_akun);
        $stmt_insert_akun->bind_param("sss", $username, $hashed_password, $npk);
        $stmt_insert_akun->execute();

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $photo_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));

            $sql_update_photo = "UPDATE dosen SET foto_extension = ? WHERE npk = ?";
            $stmt_update_photo = $mysqli->prepare($sql_update_photo);
            $stmt_update_photo->bind_param("ss", $photo_extension, $npk);
            $stmt_update_photo->execute();

            $target_dir = "../assets/images/dosen/";
            $target_file = $target_dir . $npk . '.' . $photo_extension;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
        }

        header("Location: manage_dosen.php?status=success_add");
        exit();

    } else {
        header("Location: manage_dosen.php?status=error_add");
        exit();
    }
}
?>