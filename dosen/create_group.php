<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../partials/header.php');
?>

<div class="container">
    <h1>Create New Group</h1>

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
            <label for="jenis">Group Type</label>
            <select id="jenis" name="jenis" class="form-control" required>
                <option value="Akademik">Akademik</option>
                <option value="Minat Bakat">Minat Bakat</option>
                <option value="Organisasi">Organisasi</option>
            </select>
        </div>

        <div class="form-group">
            <label for="kode_pendaftaran">Registration Code</label>
            <input type="text" id="kode_pendaftaran" name="kode_pendaftaran" class="form-control" required>
            <small>Create a unique code for students to join this group.</small>
        </div>

        <button type="submit" class="btn-submit">Create Group</button>
        <a href="index.php" class="btn-cancel">Cancel</a>
    </form>

</div>

<?php
require_once('../partials/footer.php');
?>