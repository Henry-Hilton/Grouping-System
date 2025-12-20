<?php
$required_role = 'mahasiswa';
require_once('../partials/check_session.php');
require_once('../partials/header.php');
require_once('../classes/Database.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}
$idgrup = $_GET['id'];
$nrp = $_SESSION['username'];

$sql_check = "SELECT * FROM member_grup WHERE idgrup = ? AND username = ?";
$stmt_check = $mysqli->prepare($sql_check);
$stmt_check->bind_param("is", $idgrup, $nrp);
$stmt_check->execute();
if ($stmt_check->get_result()->num_rows === 0) {
    echo "<div class='container'><h3>Access Denied. You are not a member of this group.</h3><a href='index.php'>Back</a></div>";
    require_once('../partials/footer.php');
    exit();
}

$sql_group = "SELECT * FROM grup WHERE idgrup = ?";
$stmt_group = $mysqli->prepare($sql_group);
$stmt_group->bind_param("i", $idgrup);
$stmt_group->execute();
$group = $stmt_group->get_result()->fetch_assoc();

$sql_events = "SELECT * FROM event WHERE idgrup = ? ORDER BY tanggal DESC";
$stmt_events = $mysqli->prepare($sql_events);
$stmt_events->bind_param("i", $idgrup);
$stmt_events->execute();
$events = $stmt_events->get_result();

$sql_members = "SELECT mg.username, m.nrp, m.nama 
                FROM member_grup mg 
                LEFT JOIN akun a ON mg.username = a.username 
                LEFT JOIN mahasiswa m ON a.nrp_mahasiswa = m.nrp 
                WHERE mg.idgrup = ? 
                ORDER BY mg.username ASC";
$stmt_members = $mysqli->prepare($sql_members);
$stmt_members->bind_param("i", $idgrup);
$stmt_members->execute();
$members = $stmt_members->get_result();
?>

<div class="container">
    <a href="index.php" class="btn-cancel">← Back to Dashboard</a>

    <div class="group-header-details" style="display:flex; justify-content:space-between; align-items:flex-start;">
        <div>
            <h1><?php echo htmlentities($group['nama']); ?></h1>
            <span class="badge"><?php echo htmlentities($group['jenis']); ?></span>
            <p class="group-desc"><?php echo htmlentities($group['deskripsi']); ?></p>
            <p><small>Created by: <?php echo htmlentities($group['username_pembuat']); ?></small></p>
        </div>
        <div>
            <a href="leave_group.php?id=<?php echo $idgrup; ?>" class="btn-delete"
                onclick="return confirm('Are you sure you want to leave this group?');">
                Leave Group
            </a>
        </div>
    </div>

    <hr>

    <h2>Upcoming Events</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Type</th>
                <th>Description</th>
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
                        <td><?php echo htmlentities($event['keterangan']); ?></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="4">No events scheduled.</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <br>
    <hr><br>

    <h2>Group Members</h2>
    <div class="member-list-container">
        <ul style="list-style: none; padding: 0;">
            <?php
            if ($members->num_rows > 0) {
                while ($member = $members->fetch_assoc()) {
                    $displayName = !empty($member['nama']) ? htmlentities($member['nama']) : htmlentities($member['username']);
                    $displayId = !empty($member['nrp']) ? htmlentities($member['nrp']) : 'Lecturer/Admin';
                    ?>
                    <li style="padding: 10px; border-bottom: 1px solid #eee; background: #fff;">
                        <strong><?php echo $displayName; ?></strong>
                        <span style="color:#666; margin-left: 10px;">(<?php echo $displayId; ?>)</span>
                    </li>
                    <?php
                }
            } else {
                echo "<li style='padding:10px;'>No members found.</li>";
            }
            ?>
        </ul>
    </div>

</div>

<?php
require_once('../partials/footer.php');
?>