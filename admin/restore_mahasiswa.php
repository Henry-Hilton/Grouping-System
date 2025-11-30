<?php
$required_role = 'admin';
require_once('../partials/check_session.php');
require_once('../db_connect.php');

$data_per_page = 10;

// Hitung total data soft deleted
$sql_count = "SELECT COUNT(*) AS total FROM mahasiswa WHERE deleted_at IS NOT NULL";
$result_count = $mysqli->query($sql_count);
$total_data = $result_count->fetch_assoc()['total'];

$total_pages = ceil($total_data / $data_per_page);
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $data_per_page;

// Ambil data soft-deleted
$sql = "SELECT nrp, nama, angkatan, foto_extension, deleted_at
        FROM mahasiswa 
        WHERE deleted_at IS NOT NULL
        LIMIT ? OFFSET ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ii", $data_per_page, $offset);
$stmt->execute();
$mahasiswas = $stmt->get_result();

require_once('../partials/header.php');
require_once('../partials/admin_menu.php');
?>

<div class="container">
  <h1>Deleted Students</h1>
  <p>These students were soft deleted. You may restore them.</p>

  <table class="data-table">
    <thead>
        <tr>
            <th>Photo</th>
            <th>NRP</th>
            <th>Name</th>
            <th>Class Of</th>
            <th>Deleted At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

        <?php if ($mahasiswas && $mahasiswas->num_rows > 0): ?>
            <?php while ($row = $mahasiswas->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?php 
                        if (!empty($row['foto_extension'])) {
                            $photo_path = '../assets/images/mahasiswa/' . htmlentities($row['nrp']) . '.' . htmlentities($row['foto_extension']);
                            echo "<img src='" . $photo_path . "' alt='Photo of " . htmlentities($row['nama']) . "'>";
                        } else {
                            echo "No Photo";
                        }
                        ?>
                    </td>
                    <td><?= htmlentities($row['nrp']) ?></td>
                    <td><?= htmlentities($row['nama']) ?></td>
                    <td><?= htmlentities($row['angkatan']) ?></td>
                    <td><?= htmlentities($row['deleted_at']) ?></td>

                    <td>
                        <a 
                            href="restore_mahasiswa_process.php?nrp=<?= $row['nrp'] ?>"
                            class="btn-edit"
                            onclick="return confirm('Restore this student?');"
                        >
                            Restore
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr>
                <td colspan='6'>No deleted students found.</td>
            </tr>
        <?php endif; ?>

    </tbody>
  </table>

  <div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <a href="?page=<?= $i ?>" class="<?= $i == $current_page ? 'active' : '' ?>">
        <?= $i ?>
      </a>
    <?php endfor; ?>
  </div>

</div>

<?php require_once('../partials/footer.php'); ?>