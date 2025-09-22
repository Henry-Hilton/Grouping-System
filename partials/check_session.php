<?php
// partials/check_session.php

session_start();

// --- 1. GENERAL LOGIN & EXPIRATION CHECK (Applies to everyone) ---
$timeout_duration = 1800; // 30 minutes

// First, check if a user is logged in at all
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php?error=unauthorized");
    exit();
}

// Next, check for session timeout
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php?error=session_expired");
    exit();
}
$_SESSION['last_activity'] = time(); // Update last activity time stamp


// --- 2. ROLE-SPECIFIC AUTHORIZATION CHECK (Optional) ---
// This part only runs if the page has defined a $required_role
if (isset($required_role)) {
    
    if ($required_role == 'admin' && (!isset($_SESSION['isadmin']) || $_SESSION['isadmin'] != 1)) {
        // If an admin is required, but the user is not an admin
        header("Location: ../auth/login.php?error=unauthorized");
        exit();
    }
    
    // You could add other roles here in the future
    // if ($required_role == 'dosen' && ... ) {}

}
?>