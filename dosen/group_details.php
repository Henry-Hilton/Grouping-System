<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../partials/header.php');
require_once('../db_connect.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}
$idgrup = $_GET['id'];

$sql_group = "SELECT * FROM grup WHERE idgrup = ? AND username_pembuat = ?";
$stmt_group = $mysqli->prepare($sql_group);
$stmt_group->bind_param("is", $idgrup, $_SESSION['username']);
$stmt_group->execute();
$result_group = $stmt_group->get_result();

if ($result_group->num_rows === 0) {
    echo "<div class='container'><h3>Group not found or access denied.</h3><a href='index.php'>Back</a></div>";
    require_once('../partials/footer.php');
    exit();
}

$group = $result_group->fetch_assoc();

$sql_events = "SELECT * FROM event WHERE idgrup = ? ORDER BY tanggal DESC";
$stmt_events = $mysqli->prepare($sql_events);
$stmt_events->bind_param("i", $idgrup);
$stmt_events->execute();
$events = $stmt_events->get_result();
?>

<div class="container">
    <a href="index.php" class="btn-cancel">← Back to Dashboard</a>

    <div class="group-header-details">
        <h1><?php echo htmlentities($group['nama']); ?></h1>
        <span class="badge"><?php echo htmlentities($group['jenis']); ?></span>
        <p class="group-desc"><?php echo htmlentities($group['deskripsi']); ?></p>

        <div class="registration-code-box">
            Registration Code: <strong><?php echo htmlentities($group['kode_pendaftaran']); ?></strong>
        </div>
    </div>

    <hr>

    <div class="section-header">
        <h2>Events</h2>
        <a href="create_event.php?idgrup=<?php echo $idgrup; ?>" class="btn-add">+ Add Event</a>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Type</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($events->num_rows > 0): ?>
                <?php while ($event = $events->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlentities($event['judul']); ?></td>
                        <td><?php echo date('d M Y, H:i', strtotime($event['tanggal'])); ?></td>
                        <td><?php echo htmlentities($event['jenis']); ?></td>
                        <td><?php echo htmlentities(substr($event['keterangan'], 0, 50)) . '...'; ?></td>
                        <td>
                            <a href="#" class="btn-edit-small">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;">No events scheduled yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <hr><br>

    <div class="section-header">
        <h2>Group Members</h2>
        <button class="btn-add" id="btnAddMember">Manage Members</button>
    </div>
    <p><em>Member list will be implemented in the next phase.</em></p>

</div>

<?php
require_once('../partials/footer.php');
?>