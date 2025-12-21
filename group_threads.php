<?php
session_start();
require_once 'classes/Database.php';

$path = '';
require_once 'partials/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

$idgrup = $_GET['id'];
$currentUser = $_SESSION['username'];
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_thread_title'])) {
    $now = date("Y-m-d H:i:s");
    $sql_insert = "INSERT INTO thread (username_pembuat, idgrup, tanggal_pembuatan, status) VALUES (?, ?, ?, 'Open')";
    $stmt = $db->prepare($sql_insert);
    $stmt->bind_param("sis", $currentUser, $idgrup, $now);

    if ($stmt->execute()) {
        $newThreadId = $stmt->insert_id;
        echo "<script>window.location.href='group_chat.php?id=" . $newThreadId . "';</script>";
        exit();
    }
}

$sql = "SELECT t.*, 
        COALESCE(d.nama, m.nama, t.username_pembuat) as creator_name 
        FROM thread t
        LEFT JOIN dosen d ON t.username_pembuat = d.npk 
        LEFT JOIN mahasiswa m ON t.username_pembuat = m.nrp 
        WHERE t.idgrup = ? 
        ORDER BY t.tanggal_pembuatan DESC";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $idgrup);
$stmt->execute();
$threads = $stmt->get_result();

if (isset($_SESSION['npk_dosen'])) {
    $backLink = 'dosen/group_details.php?id=' . $idgrup;
} else {
    $backLink = 'mahasiswa/group_details.php?id=' . $idgrup;
}
?>

<div class="container">
    <div class="dashboard-header" style="margin-top: 40px; border-bottom: 2px solid #eee; padding-bottom: 20px;">
        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="<?php echo $backLink; ?>" class="btn-cancel">← Back to Group</a>
            <h1 style="margin: 0;">Discussion Threads</h1>
        </div>
    </div>

    <div class="group-card" style="margin-bottom: 30px; margin-top: 20px;">
        <div class="card-header">
            <h3>Start a New Discussion</h3>
        </div>
        <div class="card-body">
            <p>Click below to start a new thread. You can start chatting immediately.</p>
            <form method="POST" action="">
                <input type="hidden" name="new_thread_title" value="New Thread">
                <button type="submit" class="btn-add">Create New Thread</button>
            </form>
        </div>
    </div>

    <div class="group-grid">
        <?php
        if ($threads->num_rows > 0) {
            while ($row = $threads->fetch_assoc()) {
                ?>
                <div class="group-card">
                    <div class="card-header">
                        <h3>Thread #<?php echo $row['idthread']; ?></h3>
                        <?php $badgeColor = ($row['status'] == 'Open') ? '#28a745' : '#6c757d'; ?>
                        <span class="badge" style="background-color: <?php echo $badgeColor; ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </div>

                    <div class="card-body">
                        <p>Started by: <strong><?php echo htmlspecialchars($row['creator_name']); ?></strong></p>
                        <p><small>Date: <?php echo date('d M Y, H:i', strtotime($row['tanggal_pembuatan'])); ?></small></p>
                    </div>

                    <div class="card-footer">
                        <a href="group_chat.php?id=<?php echo $row['idthread']; ?>" class="btn-details">
                            <?php echo ($row['status'] == 'Open') ? "Join Chat" : "View History"; ?>
                        </a>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                <p>No discussions yet. Be the first to start one!</p>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<?php
if (file_exists('partials/footer.php')) {
    require_once 'partials/footer.php';
}
?>