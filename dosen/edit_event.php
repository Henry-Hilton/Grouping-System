<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../partials/header.php');
require_once('../classes/Database.php');

$db = new Database();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}
$idevent = $_GET['id'];

$sql = "SELECT * FROM event WHERE idevent = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $idevent);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Event not found.";
    exit();
}
$event = $result->fetch_assoc();
?>

<div class="container">
    <h1>Edit Event</h1>

    <form action="edit_event_process.php" method="post">
        <input type="hidden" name="idevent" value="<?php echo $event['idevent']; ?>">
        <input type="hidden" name="idgrup" value="<?php echo $event['idgrup']; ?>">

        <div class="form-group">
            <label for="judul">Event Title</label>
            <input type="text" id="judul" name="judul" class="form-control"
                value="<?php echo htmlentities($event['judul']); ?>" required>
        </div>

        <div class="form-group">
            <label for="tanggal">Date & Time</label>
            <?php
            $dateValue = date('Y-m-d\TH:i', strtotime($event['tanggal']));
            ?>
            <input type="datetime-local" id="tanggal" name="tanggal" class="form-control"
                value="<?php echo $dateValue; ?>" required>
        </div>

        <div class="form-group">
            <label for="jenis">Event Type</label>
            <select id="jenis" name="jenis" class="form-control" required>
                <option value="Rapat" <?php if ($event['jenis'] == 'Rapat')
                    echo 'selected'; ?>>Rapat</option>
                <option value="Tugas" <?php if ($event['jenis'] == 'Tugas')
                    echo 'selected'; ?>>Tugas</option>
                <option value="Acara" <?php if ($event['jenis'] == 'Acara')
                    echo 'selected'; ?>>Acara</option>
            </select>
        </div>

        <div class="form-group">
            <label for="keterangan">Description</label>
            <textarea id="keterangan" name="keterangan" class="form-control"
                rows="4"><?php echo htmlentities($event['keterangan']); ?></textarea>
        </div>

        <button type="submit" class="btn-submit">Update Event</button>
        <a href="group_details.php?id=<?php echo $event['idgrup']; ?>" class="btn-cancel">Cancel</a>
    </form>
</div>

<?php
require_once('../partials/footer.php');
?>