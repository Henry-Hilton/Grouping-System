<?php
session_start();
if (isset($_POST['theme'])) {
    $_SESSION['theme'] = ($_POST['theme'] === 'dark') ? 'dark' : 'light';
    echo "Theme updated to " . $_SESSION['theme'];
}
?>