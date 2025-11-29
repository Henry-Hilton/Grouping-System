<?php
require_once('../partials/header.php');
require_once('../db_connect.php');

if (!isset($_GET['npk'])) {
  header("Location: manage_dosen.php");
  exit();
}

$npk = $_GET['npk'];

$sql = "SELECT * FROM dosen WHERE npk = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $npk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo "Lecturer not found.";
  exit();
}

$row = $result->fetch_assoc();
?>

<div class="container">
  <h1>Edit Lecturer</h1>

  <form action="edit_dosen_process.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="old_npk" value="<?php echo htmlentities($row['npk']); ?>">

    <div class="form-group">
      <label for="npk">NPK</label>
      <input type="text" id="npk" name="npk" class="form-control" value="<?php echo htmlentities($row['npk']); ?>"
        required>
    </div>

    <div class="form-group">
      <label for="nama">Name</label>
      <input type="text" id="nama" name="nama" class="form-control" value="<?php echo htmlentities($row['nama']); ?>"
        required>
    </div>

    <div class="form-group">
      <label for="foto">Update Photo (Leave blank to keep current)</label>
      <input type="file" id="foto" name="foto" class="form-control" accept=".jpg,.jpeg,.png">

      <div style="margin-top: 10px;">
        <strong>Current Photo:</strong><br>
        <?php
        if (!empty($row['foto_extension'])) {
          $photo_path = '../assets/images/dosen/' . htmlentities($row['npk']) . '.' . htmlentities($row['foto_extension']);

          echo '<img src="' . $photo_path . '?t=' . time() . '" style="max-width: 150px; border-radius: 8px; border: 1px solid #ddd;">';
        } else {
          echo '<span style="color: #888;">No photo uploaded.</span>';
        }
        ?>
      </div>
    </div>

    <button type="submit" class="btn-submit">Update Lecturer</button>
    <a href="manage_dosen.php" class="btn-cancel">Cancel</a>
  </form>
</div>

<?php
require_once('../partials/footer.php');
?>