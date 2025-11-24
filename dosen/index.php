<?php
require_once('../partials/check_session.php');
require_once('../partials/header.php');
?>

<div class="container">
    <div class="dashboard-header">
        <h1>Lecturer Dashboard</h1>
        <a href="create_group.php" class="btn-add">+ Create New Group</a>
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
                        <p class="code">Code: <strong><?php echo htmlentities($row['kode_pendaftaran']); ?></strong></p>
                    </div>
                    <div class="card-footer">
                        <a href="group_details.php?id=<?php echo $row['idgrup']; ?>" class="btn-details">View Details</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You haven't created any groups yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php
require_once('../partials/footer.php');
?>