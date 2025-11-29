<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../partials/header.php');
require_once('../db_connect.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$idgrup = $_GET['id'];
$username = $_SESSION['username'];

$sql = "SELECT * FROM grup WHERE idgrup = ? AND username_pembuat = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("is", $idgrup, $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Group not found or access denied.";
    exit();
}

$group = $result->fetch_assoc();
?>

<div class="container">
    <h1>Edit Group</h1>

    <form action="edit_group_process.php" method="post">
        <input type="hidden" name="idgrup" value="<?php echo $group['idgrup']; ?>">

        <div class="form-group">
            <label for="nama">Group Name</label>
            <input type="text" id="nama" name="nama" class="form-control"
                value="<?php echo htmlentities($group['nama']); ?>" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Description</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control"
                rows="3"><?php echo htmlentities($group['deskripsi']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="jenis">Group Type & Visibility</label>
            <select id="jenis" name="jenis" class="form-control" required>
                <option value="Akademik" <?php if ($group['jenis'] == 'Akademik')
                    echo 'selected'; ?>>Akademik (Private)
                </option>
                <option value="Minat Bakat" <?php if ($group['jenis'] == 'Minat Bakat')
                    echo 'selected'; ?>>Minat Bakat
                    (Private)</option>
                <option value="Organisasi" <?php if ($group['jenis'] == 'Organisasi')
                    echo 'selected'; ?>>Organisasi
                    (Private)</option>
                <option value="Publik" <?php if ($group['jenis'] == 'Publik')
                    echo 'selected'; ?>>Publik (Visible to all
                    students)</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">Update Group</button>
        <a href="group_details.php?id=<?php echo $idgrup; ?>" class="btn-cancel">Cancel</a>
    </form>
</div>

<?php
require_once('../partials/footer.php');
?>