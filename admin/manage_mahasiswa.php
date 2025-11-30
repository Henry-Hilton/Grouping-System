<?php
$required_role = 'admin';
require_once('../partials/check_session.php');
require_once('../classes/Mahasiswa.php');


$mahasiswaHandler = new Mahasiswa();
$data_per_page = 10;
$total_data = $mahasiswaHandler->getTotalCount();
$total_pages = ceil($total_data / $data_per_page);
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $data_per_page;


$mahasiswas = $mahasiswaHandler->getAll($data_per_page, $offset);

require_once('../partials/header.php');
require_once('../partials/admin_menu.php');
?>

<div class="container">
  <h1>Manage Students</h1>
  <p>Here you can view, add, edit, and delete student records.</p>
  
  <a href="add_mahasiswa.php" class="btn-add">Add New Student</a>
  <a href="restore_mahasiswa.php" class="btn-add" style="margin-left: 10px;">Deleted Students</a>

  <table class="data-table">
    <thead>
        <tr>
            <th>Photo</th>
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
                echo "<td>";
                if (!empty($row['foto_extention'])) {
                    $photo_path = '../assets/images/mahasiswa/' . htmlentities($row['nrp']) . '.' . htmlentities($row['foto_extention']);
                    echo "<img src='" . $photo_path . "' alt='Photo of " . htmlentities($row['nama']) . "'>";
                } else {
                    echo "No Photo";
                }
                echo "</td>";
                echo "<td>" . htmlentities($row['nrp']) . "</td>";
                echo "<td>" . htmlentities($row['nama']) . "</td>";
                echo "<td>" . htmlentities($row['angkatan']) . "</td>";
                echo "<td>";
                echo "<a href='edit_mahasiswa.php?nrp=" . $row['nrp'] . "' class='btn-edit'>Edit</a> ";
                echo "<a href='delete_mahasiswa.php?nrp=" . $row['nrp'] . "' class='btn-delete'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No students found.</td></tr>";
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