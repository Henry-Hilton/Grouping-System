<?php
$required_role = 'mahasiswa';
require_once('../partials/check_session.php');
require_once('../partials/header.php');
?>

<div class="container">
    <h1>Join a Group</h1>
    <p>Enter the registration code provided by your lecturer to join their group.</p>

    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'invalid_code')
            echo "<p class='error-message'>Error: Invalid registration code.</p>";
        if ($_GET['error'] == 'already_joined')
            echo "<p class='error-message'>Error: You are already a member of this group.</p>";
    }
    ?>

    <form action="join_group_process.php" method="post">
        <div class="form-group">
            <label for="kode">Registration Code</label>
            <input type="text" id="kode" name="kode" class="form-control" required placeholder="e.g. MATH101">
        </div>

        <button type="submit" class="btn-submit">Join Group</button>
        <a href="index.php" class="btn-cancel">Cancel</a>
    </form>
</div>

<?php
require_once('../partials/footer.php');
?>