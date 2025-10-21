<?php
$required_role = 'admin';
require_once('../partials/check_session.php');
require_once('../classes/Dosen.php');
require_once('../classes/Mahasiswa.php');
require_once('../classes/Grup.php');
require_once('../classes/Event.php');


$dosenHandler = new Dosen();
$mahasiswaHandler = new Mahasiswa();
$grupHandler = new Grup();
$eventHandler = new Event();

$total_dosen = $dosenHandler->getTotalCount();
$total_mahasiswa = $mahasiswaHandler->getTotalCount();
$total_grup = $grupHandler->getTotalCount();
$total_event = $eventHandler->getTotalCount();


require_once('../partials/header.php');
require_once('../partials/admin_menu.php');
?>

<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Welcome, <strong><?php echo htmlentities($_SESSION['username']); ?></strong>!</p>

    <div class="dashboard-stats">
        <div class="stat-card">
            <h2><?php echo $total_dosen; ?></h2>
            <p>Total Lecturers</p>
        </div>
        <div class="stat-card">
            <h2><?php echo $total_mahasiswa; ?></h2>
            <p>Total Students</p>
        </div>
        <div class="stat-card">
            <h2><?php echo $total_grup; ?></h2>
            <p>Total Groups</p>
        </div>
        <div class="stat-card">
            <h2><?php echo $total_event; ?></h2>
            <p>Total Events</p>
        </div>
    </div>

    <div class="quick-actions">
        <h2>Quick Actions</h2>
        <a href="manage_dosen.php" class="btn-add">Manage Lecturers</a>
        <a href="manage_mahasiswa.php" class="btn-add">Manage Students</a>
    </div>
</div>

<?php
require_once('../partials/footer.php');
?>