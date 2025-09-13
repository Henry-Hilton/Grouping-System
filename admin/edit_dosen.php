<?php
// admin/edit_dosen.php
require_once('../db_connect.php');
require_once('../partials/header.php');

// Check if NPK is set in the URL
if (!isset($_GET['npk'])) {
    // Redirect if no NPK is provided
    header("Location: manage_dosen.php");
    exit();
}

$npk = $_GET['npk'];

// Fetch the existing lecturer data
$sql = "SELECT npk, nama, foto_extension FROM dosen WHERE npk = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $npk);
$stmt->execute();
$result = $stmt->get_result();
$dosen = $result->fetch_assoc();

// If no lecturer is found with that NPK, redirect
if (!$dosen) {
    header("Location: manage_dosen.php");
    exit();
}
?>

<div class="container">
  <h1>Edit Lecturer</h1>
  
  <form action="edit_dosen_process.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="npk" value="<?php echo htmlspecialchars($dosen['npk']); ?>">
    
    <div class="form-group">
      <label for="npk_display">NPK</label>
      <input type="text" id="npk_display" class="form-control" value="<?php echo htmlspecialchars($dosen['npk']); ?>" disabled>
    </div>
    
    <div class="form-group">
      <label for="nama">Name</label>
      <input type="text" id="nama" name="nama" class="form-control" value="<?php echo htmlspecialchars($dosen['nama']); ?>" required>
    </div>
    
    <div class="form-group">
      <label for="foto">New Photo (Optional)</label>
      <?php if (!empty($dosen['foto_extension'])): ?>
        <p>Current Photo:</p>
        <img src="../assets/images/dosen/<?php echo htmlspecialchars($dosen['npk']) . '.' . htmlspecialchars($dosen['foto_extension']); ?>" alt="Current Photo" width="100">
      <?php endif; ?>
      <input type="file" id="foto" name="foto" class="form-control">
    </div>
    
    <button type="submit" class="btn-submit">Update Lecturer</button>
    <a href="manage_dosen.php" class="btn-cancel">Cancel</a>
  </form>
  
</div>

<?php
require_once('../partials/footer.php');
?>