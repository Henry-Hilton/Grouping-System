<?php
$required_role = 'admin';
require_once('../partials/check_session.php');
require_once('../db_connect.php');

$data_per_page = 10;

// Hitung total data yang soft deleted
$sql_count = "SELECT COUNT(*) AS total FROM dosen WHERE deleted_at IS NOT NULL";
$result_count = $mysqli->query($sql_count);
$total_data = $result_count->fetch_assoc()['total'];

$total_pages = ceil($total_data / $data_per_page);
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $data_per_page;

// Ambil data yang deleted_at nya TIDAK NULL
$sql = "SELECT npk, nama, foto_extension, deleted_at 
        FROM dosen 
        WHERE deleted_at IS NOT NULL
        LIMIT ? OFFSET ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ii", $data_per_page, $offset);
$stmt->execute();
$dosens = $stmt->get_result();

require_once('../partials/header.php');
require_once('../partials/admin_menu.php');
?>

<div class="container">
  <h1>Deleted Lecturers</h1>
  <p>These lecturers were soft deleted. You may restore them.</p>

  <table class="data-table">
    <thead>
        <tr>
            <th>Photo</th>
            <th>NPK</th>
            <th>Name</th>
            <th>Deleted At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

        <?php if ($dosens && $dosens->num_rows > 0): ?>
            <?php while ($row = $dosens->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?php 
                        if (!empty($row['foto_extension'])) {
                            $photo_path = '../assets/images/dosen/' . htmlentities($row['npk']) . '.' . htmlentities($row['foto_extension']);
                            echo "<img src='" . $photo_path . "' alt='Photo of " . htmlentities($row['nama']) . "'>";
                        } else {
                            echo "No Photo";
                        }
                        ?>
                    </td>
                    <td><?= htmlentities($row['npk']) ?></td>
                    <td><?= htmlentities($row['nama']) ?></td>
                    <td><?= htmlentities($row['deleted_at']) ?></td>

                    <td>
                        <a href="restore_dosen_process.php?npk=<?= $row['npk'] ?>" 
                           class="btn-edit"
                           onclick="return confirm('Restore this lecturer?');">
                           Restore
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr>
                <td colspan='5'>No deleted lecturers found.</td>
            </tr>
        <?php endif; ?>

    </tbody>
  </table>

  <div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <a href="?page=<?php echo $i; ?>" class="<?= $i == $current_page ? 'active' : '' ?>">
        <?= $i ?>
      </a>
    <?php endfor; ?>
  </div>

</div>

<?php require_once('../partials/footer.php'); ?>