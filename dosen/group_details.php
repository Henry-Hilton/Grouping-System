<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../partials/header.php');
require_once('../classes/Database.php');

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
    <div class="dashboard-header">
        <div style="display: flex; align-items: center; gap: 15px;">
            <a href="index.php" class="btn-cancel">← Back</a>
            <h1 style="margin: 0;">Group Details</h1>
        </div>

        <div class="header-actions">
            <a href="edit_group.php?id=<?php echo $idgrup; ?>" class="btn-edit">Edit Group</a>

            <a href="delete_group.php?id=<?php echo $idgrup; ?>" class="btn-delete"
                onclick="return confirm('WARNING: Are you sure? This will delete the group and ALL its events and members.');">
                Delete Group
            </a>
        </div>
    </div>

    <div class="group-header-details">
        <h2><?php echo htmlentities($group['nama']); ?></h2>
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
            <?php
            if ($events->num_rows > 0) {
                while ($event = $events->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo htmlentities($event['judul']); ?></td>
                        <td><?php echo date('d M Y, H:i', strtotime($event['tanggal'])); ?></td>
                        <td><?php echo htmlentities($event['jenis']); ?></td>
                        <td><?php echo htmlentities(substr($event['keterangan'], 0, 50)) . '...'; ?></td>
                        <td>
                            <a href="edit_event.php?id=<?php echo $event['idevent']; ?>" class="btn-edit-small">Edit</a>
                            <a href="delete_event.php?id=<?php echo $event['idevent']; ?>&idgrup=<?php echo $idgrup; ?>"
                                class="btn-delete" style="padding: 4px 8px; font-size: 0.8rem; margin-left: 5px; height: auto;"
                                onclick="return confirm('Delete this event?');">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="5" style="text-align:center;">No events scheduled yet.</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <br>
    <hr><br>

    <div class="section-header">
        <h2>Group Members</h2>
        <a href="manage_members.php?id=<?php echo $idgrup; ?>" class="btn-add">Manage Members</a>
    </div>
    <p>Click "Manage Members" to add or remove students.</p>

</div>

<?php
require_once('../partials/footer.php');
?>