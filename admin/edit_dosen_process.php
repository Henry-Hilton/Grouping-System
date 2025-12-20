<?php
$required_role = 'admin';
require_once('../classes/Database.php');

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $npk = htmlentities($_POST['npk']);
    $nama = htmlentities($_POST['nama']);

    $sql_update_text = "UPDATE dosen SET nama = ? WHERE npk = ?";
    $stmt_update_text = $db->prepare($sql_update_text);
    $stmt_update_text->bind_param("ss", $nama, $npk);
    $stmt_update_text->execute();

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "../assets/images/dosen/";
        $photo_extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . $npk . '.' . $photo_extension;

        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

        $sql_update_photo = "UPDATE dosen SET foto_extension = ? WHERE npk = ?";
        $stmt_update_photo = $db->prepare($sql_update_photo);
        $stmt_update_photo->bind_param("ss", $photo_extension, $npk);
        $stmt_update_photo->execute();
    }

    header("Location: manage_dosen.php?status=success_update");
    exit();

} else {

    header("Location: manage_dosen.php");
    exit();
}
?>