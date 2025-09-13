<?php
// admin/manage_mahasiswa.php
require_once('../partials/check_session.php');
require_once('../classes/Mahasiswa.php'); // Use the Mahasiswa class

// --- Pagination Logic ---
$mahasiswaHandler = new Mahasiswa();
$data_per_page = 10; // How many items to show per page
$total_data = $mahasiswaHandler->getTotalCount();
$total_pages = ceil($total_data / $data_per_page);
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $data_per_page;

// Fetch the data for the current page
$mahasiswas = $mahasiswaHandler->getAll($data_per_page, $offset);

require_once('../partials/header.php');
require_once('../partials/admin_menu.php');
?>

<div class="container">
  <h1>Manage Students</h1>
  <p>Here you can view, add, edit, and delete student records.</p>
  
  <a href="add_mahasiswa.php" class="btn-add">Add New Student</a>
  
  <table class="data-table">
    <thead>
      <tr>
        <th>NRP</th>
        <th>Name</th>
        <th>Class Of</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($mahasiswas && $mahasiswas->num_rows > 0) {
        while ($row = $mahasiswas->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row['nrp']) . "</td>";
          echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
          echo "<td>" . htmlspecialchars($row['angkatan']) . "</td>";
          echo "<td>";
          echo "<a href='edit_mahasiswa.php?nrp=" . $row['nrp'] . "' class='btn-edit'>Edit</a> ";
          echo "<a href='delete_mahasiswa.php?nrp=" . $row['nrp'] . "' class='btn-delete'>Delete</a>";
          echo "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='4'>No students found.</td></tr>";
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