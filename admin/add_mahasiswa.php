<?php
$required_role = 'admin';
require_once('../partials/check_session.php');
require_once('../classes/Database.php');
require_once('../partials/header.php');
require_once('../partials/admin_menu.php');
?>

<div class="container">
  <h1>Add New Student</h1>

  <?php
  if (isset($_GET['error'])) {
    if ($_GET['error'] == 'duplicate_nrp') {
      echo '<p class="error-message">Error: A student with this NRP already exists.</p>';
    } else if ($_GET['error'] == 'duplicate_username') {
      echo '<p class="error-message">Error: This username is already taken. Please choose another.</p>';
    }
  }
  ?>

  <form action="add_mahasiswa_process.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="nrp">NRP</label>
      <input type="text" id="nrp" name="nrp" class="form-control" required maxlength="9">
    </div>

    <div class="form-group">
      <label for="nama">Name</label>
      <input type="text" id="nama" name="nama" class="form-control" required>
    </div>

    <hr>
    <h4>Create Login Account</h4>

    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" class="form-control" required>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <div class="form-group">
      <label for="gender">Gender</label>
      <select id="gender" name="gender" class="form-control" required>
        <option value="Pria">Pria</option>
        <option value="Wanita">Wanita</option>
      </select>
    </div>

    <div class="form-group">
      <label for="tanggal_lahir">Date of Birth</label>
      <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" required>
    </div>

    <div class="form-group">
      <label for="angkatan">Class Of (Year)</label>
      <input type="number" id="angkatan" name="angkatan" class="form-control" required min="2000" max="2099">
    </div>

    <div class="form-group">
      <label for="foto">Photo</label>
      <input type="file" id="foto" name="foto" class="form-control">
    </div>

    <button type="submit" class="btn-submit">Add Student</button>
    <a href="manage_mahasiswa.php" class="btn-cancel">Cancel</a>
  </form>

</div>

<?php
require_once('../partials/footer.php');
?>