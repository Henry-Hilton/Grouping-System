<?php
require_once('../partials/check_session.php'); // Checks for login
require_once('../partials/header.php');
// We will add a real dosen_menu.php here later
?>
<div class="container">
    <h1>Welcome, Lecturer!</h1>
    <p>This is your dashboard.</p>
    <a href="../account/change_password.php">Change Password</a>
</div>
<?php
require_once('../partials/footer.php');
?>