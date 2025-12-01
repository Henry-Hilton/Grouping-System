<?php
$required_role = 'mahasiswa';
require_once('../partials/check_session.php');
require_once('../partials/header.php');
require_once('../db_connect.php');

// 1. Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}
$idgrup = $_GET['id'];
$nrp = $_SESSION['username'];

// 2. Security Check: Is the student actually a member of this group?
$sql_check = "SELECT * FROM member_grup WHERE idgrup = ? AND username = ?";
$stmt_check = $mysqli->prepare($sql_check);
$stmt_check->bind_param("is", $idgrup, $nrp);
$stmt_check->execute();
if ($stmt_check->get_result()->num_rows === 0) {
    echo "<div class='container'><h3>Access Denied. You are not a member of this group.</h3><a href='index.php'>Back</a></div>";
    require_once('../partials/footer.php');
    exit();
}

// 3. Fetch Group Details
$sql_group = "SELECT * FROM grup WHERE idgrup = ?";
$stmt_group = $mysqli->prepare($sql_group);
$stmt_group->bind_param("i", $idgrup);
$stmt_group->execute();
$group = $stmt_group->get_result()->fetch_assoc();

// 4. Fetch Events
$sql_events = "SELECT * FROM event WHERE idgrup = ? ORDER BY tanggal DESC";
$stmt_events = $mysqli->prepare($sql_events);
$stmt_events->bind_param("i", $idgrup);
$stmt_events->execute();
$events = $stmt_events->get_result();

// 5. Fetch Members (THE FIX: Join via 'akun' table)
// We link member_grup.username -> akun.username -> akun.nrp_mahasiswa -> mahasiswa.nrp
$sql_members = "SELECT m.nrp, m.nama 
                FROM member_grup mg 
                JOIN akun a ON mg.username = a.username 
                JOIN mahasiswa m ON a.nrp_mahasiswa = m.nrp 
                WHERE mg.idgrup = ? 
                ORDER BY m.nama ASC";
$stmt_members = $mysqli->prepare($sql_members);
$stmt_members->bind_param("i", $idgrup);
$stmt_members->execute();
$members = $stmt_members->get_result();
?>

<div class="container">

    <div class="dashboard-header">
        <div style="display: flex; align-items: center; gap: 15px;">
            <a href="index.php" class="btn-cancel">← Back</a>
            <h1 style="margin: 0;"><?php echo htmlspecialchars($group['nama']); ?></h1>
        </div>

        <div class="header-actions">
            <a href="leave_group.php?id=<?php echo $idgrup; ?>" class="btn-delete"
                onclick="return confirm('Are you sure you want to leave this group?');">
                Leave Group
            </a>
        </div>
    </div>

    <div class="group-header-details">
        <span class="badge"><?php echo htmlspecialchars($group['jenis']); ?></span>
        <p class="group-desc"><?php echo htmlspecialchars($group['deskripsi']); ?></p>
        <p><small>Created by: <?php echo htmlspecialchars($group['username_pembuat']); ?></small></p>
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
                        <td><?php echo htmlspecialchars($event['judul']); ?></td>
                        <td><?php echo date('d M Y, H:i', strtotime($event['tanggal'])); ?></td>
                        <td><?php echo htmlspecialchars($event['jenis']); ?></td>
                        <td><?php echo htmlspecialchars($event['keterangan']); ?></td>
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
                    ?>
                    <li style="padding: 10px; border-bottom: 1px solid #eee; background: #fff;">
                        <strong><?php echo htmlspecialchars($member['nama']); ?></strong>
                        <span style="color:#666; margin-left: 10px;">(<?php echo htmlspecialchars($member['nrp']); ?>)</span>
                    </li>
                <?php
                }
            } else {
                echo "<li>No members found (This is strange, you should be here!).</li>";
            }
            ?>
        </ul>
    </div>

</div>

<?php
require_once('../partials/footer.php');
?>