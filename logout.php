<?php
// logout.php

// 1. Start the session
session_start();

// 2. Unset all of the session variables
session_unset();

// 3. Destroy the session
session_destroy();

// 4. Redirect to the login page with a success message
header("Location: login.php?status=logged_out");
exit();
?>