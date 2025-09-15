<?php
session_start();
// If user is already logged in, redirect them away from the login page
if (isset($_SESSION['username'])) {
    if (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1) {
        header("Location: admin/index.php");
        exit();
    }
}
// We only need the top part of the header for the login page
require_once('partials/header.php'); 
?>

<div class="login-wrapper">
    <div class="login-card card">
        <h2>Grouping System</h2>
        <p class="tagline">Please log in to continue</p>
        
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
            
            <button type="submit" class="btn-submit btn-block">Login</button>
        </form>
    </div>
</div>

<?php
// We only need the bottom part of the footer
require_once('partials/footer.php');
?>