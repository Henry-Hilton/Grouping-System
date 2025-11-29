<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../partials/header.php');
?>

<div class="container">
    <h1>Create New Group</h1>

    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'duplicate_name') {
            echo '<p class="error-message">Error: A group with this Name already exists.</p>';
        } else {
            echo '<p class="error-message">Error: Failed to create group.</p>';
        }
    }
    ?>

    <form action="create_group_process.php" method="post">
        <div class="form-group">
            <label for="nama">Group Name</label>
            <input type="text" id="nama" name="nama" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Description</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="jenis">Group Type & Visibility</label>
            <select id="jenis" name="jenis" class="form-control" required>
                <option value="Akademik">Akademik (Private)</option>
                <option value="Minat Bakat">Minat Bakat (Private)</option>
                <option value="Organisasi">Organisasi (Private)</option>

                <option value="Publik">Publik (Visible to all students)</option>
            </select>
            <small class="form-text text-muted">
                Only "Publik" groups appear in the student's Explore list. Other types require the code to join.
            </small>
        </div>

        <button type="submit" class="btn-submit">Create Group</button>
        <a href="index.php" class="btn-cancel">Cancel</a>
    </form>

</div>

<?php
require_once('../partials/footer.php');
?>