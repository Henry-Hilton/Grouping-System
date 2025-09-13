<?php
// login.php
session_start(); // Start the session to check for existing login

// If user is already logged in, redirect them to their dashboard
if (isset($_SESSION['username'])) {
    if ($_SESSION['isadmin'] == 1) {
        header("Location: admin/index.php");
    } // Add similar checks for dosen/mahasiswa later
    exit();
}
require_once('partials/header.php'); 
?>

<div class="container login-container">
  <h1>Login</h1>
  
  <?php
  // Display error messages if any
  if (isset($_GET['error'])) {
      echo '<p class="error-message">Invalid username or password.</p>';
  }
  ?>
  
  <form action="login_process.php" method="post">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" class="form-control" required>
    </div>
    
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" class="form-control" required>
    </div>
    
    <button type="submit" class="btn-submit">Login</button>
  </form>
</div>

<?php
require_once('partials/footer.php');
?>