<?php
// admin/manage_mahasiswa.php
require_once('../partials/check_session.php');
require_once('../db_connect.php');
require_once('../partials/header.php');
require_once('../partials/admin_menu.php');

// --- PHP Logic to Fetch Data ---
$sql = "SELECT nrp, nama, angkatan FROM mahasiswa ORDER BY nama ASC";
$result = $mysqli->query($sql);

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
      if ($result && $result->num_rows > 0) {
        // Loop through the results and display each student in a table row
        while ($row = $result->fetch_assoc()) {
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
        // Display a message if there are no students
        echo "<tr><td colspan='4'>No students found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<?php
// Include the footer
require_once('../partials/footer.php');
?>