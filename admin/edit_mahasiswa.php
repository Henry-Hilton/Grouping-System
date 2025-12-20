<?php
$required_role = 'admin';
require_once('../partials/check_session.php');
require_once('../classes/Database.php');
require_once('../partials/header.php');
require_once('../partials/admin_menu.php');

$db = new Database();

if (!isset($_GET['nrp'])) {
  header("Location: manage_mahasiswa.php");
  exit();
}

$nrp = $_GET['nrp'];

$sql = "SELECT * FROM mahasiswa WHERE nrp = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("s", $nrp);
$stmt->execute();
$result = $stmt->get_result();
$mahasiswa = $result->fetch_assoc();

if (!$mahasiswa) {
  header("Location: manage_mahasiswa.php");
  exit();
}
?>

<div class="container">
  <h1>Edit Student</h1>

  <form action="edit_mahasiswa_process.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="nrp" value="<?php echo htmlentities($mahasiswa['nrp']); ?>">

    <div class="form-group">
      <label for="nrp_display">NRP</label>
      <input type="text" id="nrp_display" class="form-control" value="<?php echo htmlentities($mahasiswa['nrp']); ?>"
        disabled>
    </div>

    <div class="form-group">
      <label for="nama">Name</label>
      <input type="text" id="nama" name="nama" class="form-control"
        value="<?php echo htmlentities($mahasiswa['nama']); ?>" required>
    </div>

    <div class="form-group">
      <label for="gender">Gender</label>
      <select id="gender" name="gender" class="form-control" required>
        <option value="Pria" <?php echo ($mahasiswa['gender'] == 'Pria') ? 'selected' : ''; ?>>Pria</option>
        <option value="Wanita" <?php echo ($mahasiswa['gender'] == 'Wanita') ? 'selected' : ''; ?>>Wanita</option>
      </select>
    </div>

    <div class="form-group">
      <label for="tanggal_lahir">Date of Birth</label>
      <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control"
        value="<?php echo htmlentities($mahasiswa['tanggal_lahir']); ?>" required>
    </div>

    <div class="form-group">
      <label for="angkatan">Class Of (Year)</label>
      <input type="number" id="angkatan" name="angkatan" class="form-control"
        value="<?php echo htmlentities($mahasiswa['angkatan']); ?>" required min="2000" max="2099">
    </div>

    <div class="form-group">
      <label for="foto">New Photo (Optional)</label>
      <?php if (!empty($mahasiswa['foto_extention'])): ?>
        <p>Current Photo:</p>
        <img
          src="../assets/images/mahasiswa/<?php echo htmlentities($mahasiswa['nrp']) . '.' . htmlentities($mahasiswa['foto_extention']); ?>"
          alt="Current Photo" width="100">
      <?php endif; ?>
      <input type="file" id="foto" name="foto" class="form-control">
    </div>

    <button type="submit" class="btn-submit">Update Student</button>
    <a href="manage_mahasiswa.php" class="btn-cancel">Cancel</a>
  </form>

</div>

<?php
require_once('../partials/footer.php');
?>