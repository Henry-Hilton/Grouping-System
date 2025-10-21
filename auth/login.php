<?php
session_start();

if (isset($_SESSION['username'])) {
    if (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1) {
        header("Location: ../admin/index.php");
        exit();
    }
}

require_once('../partials/header.php'); 
?>

<div class="login-wrapper">
    <div class="login-card card">
        <h2>Grouping System</h2>
        <p class="tagline">Please log in to continue</p>
        
        <?php
        
        if (isset($_GET['error']) && $_GET['error'] == '1') {
            echo '<p class="error-message">Invalid username or password.</p>';
        } else if (isset($_GET['error']) && $_GET['error'] == 'unauthorized') {
            echo '<p class="error-message">You are not authorized to access that page.</p>';
        } else if (isset($_GET['error']) && $_GET['error'] == 'session_expired') {
            echo '<p class="error-message">Your session has expired. Please log in again.</p>';
        } else if (isset($_GET['status']) && $_GET['status'] == 'logged_out') {
            echo '<p class="success-message">You have been successfully logged out.</p>';
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

require_once('../partials/footer.php');
?>