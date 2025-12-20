<?php
$required_role = 'admin';
require_once('../partials/check_session.php');
require_once('../classes/Database.php');

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nrp = htmlentities($_POST['nrp']);
    $nama = htmlentities($_POST['nama']);
    $gender = htmlentities($_POST['gender']);
    $tanggal_lahir = htmlentities($_POST['tanggal_lahir']);
    $angkatan = htmlentities($_POST['angkatan']);

    $sql_update_text = "UPDATE mahasiswa SET nama = ?, gender = ?, tanggal_lahir = ?, angkatan = ? WHERE nrp = ?";
    $stmt_update_text = $db->prepare($sql_update_text);
    $stmt_update_text->bind_param("sssis", $nama, $gender, $tanggal_lahir, $angkatan, $nrp);
    $stmt_update_text->execute();

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "../assets/images/mahasiswa/";
        $photo_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . $nrp . '.' . $photo_extension;

        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

        $sql_update_photo = "UPDATE mahasiswa SET foto_extention = ? WHERE nrp = ?";
        $stmt_update_photo = $db->prepare($sql_update_photo);
        $stmt_update_photo->bind_param("ss", $photo_extension, $nrp);
        $stmt_update_photo->execute();
    }

    header("Location: manage_mahasiswa.php?status=success_update");
    exit();

} else {
    header("Location: manage_mahasiswa.php");
    exit();
}
?>