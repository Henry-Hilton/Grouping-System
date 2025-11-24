<?php
$required_role = 'mahasiswa';
require_once('../partials/check_session.php');
require_once('../partials/header.php');
require_once('../db_connect.php');

$nrp = $_SESSION['username'];
$sql = "SELECT g.* FROM grup g 
        JOIN member_grup mg ON g.idgrup = mg.idgrup 
        WHERE mg.username = ? 
        ORDER BY g.tanggal_pembentukan DESC";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $nrp);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container">
    <div class="dashboard-header">
        <h1>Student Dashboard</h1>
        <a href="join_group.php" class="btn-add">+ Join New Group</a>
    </div>

    <p>Welcome, <strong><?php echo htmlentities($_SESSION['username']); ?></strong>!</p>

    <h2 class="section-title">My Groups</h2>

    <div class="group-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="group-card">
                    <div class="card-header">
                        <h3><?php echo htmlentities($row['nama']); ?></h3>
                        <span class="badge"><?php echo htmlentities($row['jenis']); ?></span>
                    </div>
                    <div class="card-body">
                        <p><?php echo htmlentities($row['deskripsi']); ?></p>
                        <p>Creator: <strong><?php echo htmlentities($row['username_pembuat']); ?></strong></p>
                    </div>
                    <div class="card-footer">
                        <a href="group_details.php?id=<?php echo $row['idgrup']; ?>" class="btn-details">View Group</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You haven't joined any groups yet. Click "Join New Group" to get started.</p>
        <?php endif; ?>
    </div>
</div>

<?php
require_once('../partials/footer.php');
?>