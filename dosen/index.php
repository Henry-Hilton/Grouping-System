<?php
require_once('../partials/check_session.php');
require_once('../partials/header.php');

?>
<div class="container">
    <h1>Lecturer Dashboard</h1>
    <p>Welcome, <strong><?php echo htmlentities($_SESSION['username']); ?></strong>!</p>

    <div class="quick-actions">
        <h2>Quick Actions</h2>
        <a href="create_group.php" class="btn-add">Create New Group</a>
    </div>
</div>
<?php
require_once('../partials/footer.php');
?>