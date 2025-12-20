<?php
$required_role = 'mahasiswa';
require_once('../partials/check_session.php');
require_once('../partials/header.php');
require_once('../classes/Database.php');

$db = new Database();

$nrp = $_SESSION['username'];

$sql_my = "SELECT g.* FROM grup g 
           JOIN member_grup mg ON g.idgrup = mg.idgrup 
           WHERE mg.username = ? 
           ORDER BY g.tanggal_pembentukan DESC";

$stmt_my = $db->prepare($sql_my);
$stmt_my->bind_param("s", $nrp);
$stmt_my->execute();
$result_my = $stmt_my->get_result();

$sql_avail = "SELECT * FROM grup 
              WHERE idgrup NOT IN (SELECT idgrup FROM member_grup WHERE username = ?) 
              AND jenis = 'Publik' 
              ORDER BY nama ASC";

$stmt_avail = $db->prepare($sql_avail);
$stmt_avail->bind_param("s", $nrp);
$stmt_avail->execute();
$result_avail = $stmt_avail->get_result();
?>

<div class="container">
    <div class="dashboard-header">
        <h1>Student Dashboard</h1>
        <div class="header-actions">
            <a href="join_group.php" class="btn-add">+ Join New Group</a>
            <a href="../auth/logout.php" class="btn-logout">Logout</a>
        </div>
    </div>

    <p>Welcome, <strong><?php echo htmlentities($_SESSION['username']); ?></strong>!</p>

    <h2 class="section-title">My Groups</h2>
    <div class="group-grid">
        <?php
        if ($result_my->num_rows > 0) {
            while ($row = $result_my->fetch_assoc()) {
                ?>
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
                <?php
            }
        } else {
            ?>
            <p>You haven't joined any groups yet.</p>
            <?php
        }
        ?>
    </div>

    <br>
    <hr><br>

    <h2 class="section-title">Explore Public Groups</h2>
    <p>These groups are visible to the public. You will still need the <strong>Registration Code</strong> to join.</p>

    <div class="group-grid">
        <?php
        if ($result_avail->num_rows > 0) {
            while ($row = $result_avail->fetch_assoc()) {
                ?>
                <div class="group-card" style="background-color: #f9f9f9; border-color: #ddd;">
                    <div class="card-header">
                        <h3 style="color: #555;"><?php echo htmlentities($row['nama']); ?></h3>
                        <span class="badge"
                            style="background: #eee; color: #555;"><?php echo htmlentities($row['jenis']); ?></span>
                    </div>
                    <div class="card-body">
                        <p><?php echo htmlentities($row['deskripsi']); ?></p>
                        <p><small>Creator: <?php echo htmlentities($row['username_pembuat']); ?></small></p>
                    </div>
                    <div class="card-footer">
                        <a href="join_group.php" class="btn-details" style="background-color: #6c757d;">Join Group</a>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <p>No public groups available at the moment.</p>
            <?php
        }
        ?>
    </div>

</div>

<?php
require_once('../partials/footer.php');
?>