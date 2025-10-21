<?php


session_start();


$timeout_duration = 1800; 


if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php?error=unauthorized");
    exit();
}


if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php?error=session_expired");
    exit();
}
$_SESSION['last_activity'] = time(); 



if (isset($required_role)) {
    
    if ($required_role == 'admin' && (!isset($_SESSION['isadmin']) || $_SESSION['isadmin'] != 1)) {
        
        header("Location: ../auth/login.php?error=unauthorized");
        exit();
    }
    
    

}
?>