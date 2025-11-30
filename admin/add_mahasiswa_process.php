<?php
require_once('../db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nrp = $_POST['nrp'];
    $nama = $_POST['nama'];
    $gender = $_POST['gender'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $angkatan = $_POST['angkatan'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql_check_nrp = "SELECT nrp FROM mahasiswa WHERE nrp = ? AND deleted_at IS NULL";
    $stmt_check_nrp = $mysqli->prepare($sql_check_nrp);
    $stmt_check_nrp->bind_param("s", $nrp);
    $stmt_check_nrp->execute();
    $result_nrp = $stmt_check_nrp->get_result();

    if ($result_nrp->num_rows > 0) {
        header("Location: add_mahasiswa.php?error=duplicate_nrp");
        exit();
    }

    $sql_check_user = "SELECT username FROM akun WHERE username = ?";
    $stmt_check_user = $mysqli->prepare($sql_check_user);
    $stmt_check_user->bind_param("s", $username);
    $stmt_check_user->execute();
    $result_user = $stmt_check_user->get_result();

    if ($result_user->num_rows > 0) {
        header("Location: add_mahasiswa.php?error=duplicate_username");
        exit();
    }

    $sql_insert_mahasiswa = "INSERT INTO mahasiswa (nrp, nama, gender, tanggal_lahir, angkatan, deleted_at) VALUES (?, ?, ?, ?, ?, NULL)";
    $stmt_insert = $mysqli->prepare($sql_insert_mahasiswa);
    $stmt_insert->bind_param("ssssi", $nrp, $nama, $gender, $tanggal_lahir, $angkatan);

    if ($stmt_insert->execute()) {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql_insert_akun = "INSERT INTO akun (username, password, nrp_mahasiswa) VALUES (?, ?, ?)";
        $stmt_insert_akun = $mysqli->prepare($sql_insert_akun);
        $stmt_insert_akun->bind_param("sss", $username, $hashed_password, $nrp);
        $stmt_insert_akun->execute();

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {

            $photo_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));

            $sql_update_photo = "UPDATE mahasiswa SET foto_extension = ? WHERE nrp = ?";
            $stmt_update_photo = $mysqli->prepare($sql_update_photo);
            $stmt_update_photo->bind_param("ss", $photo_extension, $nrp);
            $stmt_update_photo->execute();

            $target_dir = "../assets/images/mahasiswa/";
            $target_file = $target_dir . $nrp . '.' . $photo_extension;

            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
        }

        header("Location: manage_mahasiswa.php?status=success_add");
        exit();

    } else {
        header("Location: manage_mahasiswa.php?status=error_add");
        exit();
    }
}
?>