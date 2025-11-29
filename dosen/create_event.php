<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../partials/header.php');

if (!isset($_GET['idgrup'])) {
    header("Location: index.php");
    exit();
}
$idgrup = $_GET['idgrup'];
?>

<div class="container">
    <h1>Add New Event</h1>

    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'duplicate_title') {
            echo '<p class="error-message">Error: An event with this Title already exists in this group.</p>';
        } elseif ($_GET['error'] == 'duplicate_time') {
            echo '<p class="error-message">Error: There is already an event scheduled for this exact time.</p>';
        }
    }
    ?>

    <form action="create_event_process.php" method="post">
        <input type="hidden" name="idgrup" value="<?php echo htmlentities($idgrup); ?>">

        <div class="form-group">
            <label for="judul">Event Title</label>
            <input type="text" id="judul" name="judul" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="tanggal">Date & Time</label>
            <input type="datetime-local" id="tanggal" name="tanggal" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="jenis">Event Type</label>
            <select id="jenis" name="jenis" class="form-control" required>
                <option value="Rapat">Rapat</option>
                <option value="Tugas">Tugas</option>
                <option value="Acara">Acara</option>
            </select>
        </div>

        <div class="form-group">
            <label for="keterangan">Description</label>
            <textarea id="keterangan" name="keterangan" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn-submit">Save Event</button>
        <a href="group_details.php?id=<?php echo $idgrup; ?>" class="btn-cancel">Cancel</a>
    </form>
</div>

<?php
require_once('../partials/footer.php');
?>