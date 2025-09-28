<?php
// admin/manage_dosen.php
$required_role = 'admin';
require_once('../partials/check_session.php');
require_once('../classes/Dosen.php'); // Use the Dosen class

// --- Pagination Logic ---
$dosenHandler = new Dosen();
$data_per_page = 10; // How many items to show per page
$total_data = $dosenHandler->getTotalCount();
$total_pages = ceil($total_data / $data_per_page);
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $data_per_page;

// Fetch the data for the current page
$dosens = $dosenHandler->getAll($data_per_page, $offset);

require_once('../partials/header.php');
require_once('../partials/admin_menu.php');
?>

<div class="container">
  <h1>Manage Lecturers</h1>
  <p>Here you can view, add, edit, and delete lecturer records.</p>
  
  <a href="add_dosen.php" class="btn-add">Add New Lecturer</a>
  
  <table class="data-table">
    <thead>
        <tr>
            <th>Photo</th>
            <th>NPK</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($dosens && $dosens->num_rows > 0) {
            while ($row = $dosens->fetch_assoc()) {
                echo "<tr>";
                echo "<td>";
                if (!empty($row['foto_extension'])) {
                    $photo_path = '../assets/images/dosen/' . htmlspecialchars($row['npk']) . '.' . htmlspecialchars($row['foto_extension']);
                    echo "<img src='" . $photo_path . "' alt='Photo of " . htmlspecialchars($row['nama']) . "'>";
                } else {
                    echo "No Photo";
                }
                echo "</td>";
                echo "<td>" . htmlspecialchars($row['npk']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                echo "<td>";
                echo "<a href='edit_dosen.php?npk=" . $row['npk'] . "' class='btn-edit'>Edit</a> ";
                echo "<a href='delete_dosen.php?npk=" . $row['npk'] . "' class='btn-delete'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No lecturers found.</td></tr>";
        }
        ?>
    </tbody>
  </table>

  <div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <a href="?page=<?php echo $i; ?>" class="<?php if($i == $current_page) echo 'active'; ?>">
        <?php echo $i; ?>
      </a>
    <?php endfor; ?>
  </div>
  
</div>

<?php
require_once('../partials/footer.php');
?>