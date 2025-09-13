<?php
// admin/add_dosen.php
require_once('../db_connect.php');
require_once('../partials/header.php');
?>

<div class="container">
  <h1>Add New Lecturer</h1>
  
  <form action="add_dosen_process.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="npk">NPK</label>
      <input type="text" id="npk" name="npk" class="form-control" required maxlength="6">
    </div>
    
    <div class="form-group">
      <label for="nama">Name</label>
      <input type="text" id="nama" name="nama" class="form-control" required>
    </div>
    
    <div class="form-group">
      <label for="foto">Photo</label>
      <input type="file" id="foto" name="foto" class="form-control">
    </div>
    
    <button type="submit" class="btn-submit">Add Lecturer</button>
    <a href="manage_dosen.php" class="btn-cancel">Cancel</a>
  </form>
  
</div>

<?php
require_once('../partials/footer.php');
?>