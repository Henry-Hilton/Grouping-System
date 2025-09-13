<?php
// partials/check_session.php

// This must be the very first line on any page that uses sessions
session_start();

// Check if the user is logged in AND is an admin.
// If not, redirect them to the login page.
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
    // The ../ is important because this will be included from files inside the /admin/ folder
    header("Location: ../login.php?error=unauthorized");
    exit(); // Stop script execution
}
?>