<nav class="main-nav">
    <ul>
        <?php
        if (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1): ?>
            <li><a href="../admin/index.php">Dashboard</a></li>
            <li><a href="../admin/manage_dosen.php">Manage Lecturers</a></li>
            <li><a href="../admin/manage_mahasiswa.php">Manage Students</a></li>

            <?php
        elseif (isset($_SESSION['npk_dosen']) && $_SESSION['npk_dosen']): ?>
            <li><a href="../dosen/index.php">Dashboard</a></li>
            <li><a href="../dosen/manage_groups.php">My Groups</a></li>

            <?php
        elseif (isset($_SESSION['nrp_mahasiswa']) && $_SESSION['nrp_mahasiswa']): ?>
            <li><a href="../mahasiswa/index.php">Dashboard</a></li>
            <li><a href="../mahasiswa/join_group.php">Join Group</a></li>

        <?php endif; ?>

        <li><a href="../auth/logout.php" class="nav-logout-link">Logout</a></li>
    </ul>

    <div class="nav-actions">
        <div class="theme-toggle-wrapper">
            <input type="checkbox" id="darkModeToggle" class="theme-checkbox">
            <label for="darkModeToggle" class="theme-label">
                <span class="icon-moon">🌙</span>
                <span class="icon-sun">☀️</span>
                <span class="toggle-ball"></span>
            </label>
        </div>
    </div>
</nav>

<script>
    if (localStorage.getItem('theme') === 'dark') {
        const toggle = document.getElementById('darkModeToggle');
        if (toggle) toggle.checked = true;
    }
</script>