<?php
// Include the database connection and header
require_once('../partials/check_session.php');
require_once('../db_connect.php');
require_once('../partials/header.php');
require_once('../partials/admin_menu.php');

// --- PHP Logic to Fetch Data ---
$sql = "SELECT npk, nama FROM dosen ORDER BY nama ASC";
$result = $mysqli->query($sql);

?>

<div class="container">
  <h1>Manage Lecturers</h1>
  <p>Here you can view, add, edit, and delete lecturer records.</p>
  <a href="add_dosen.php" class="btn-add">Add New Lecturer</a>
  <table class="data-table">
    <thead>
      <tr>
        <th>NPK</th>
        <th>Name</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result && $result->num_rows > 0) {
        // Loop through the results and display each lecturer in a table row
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row['npk']) . "</td>";
          echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
          echo "<td>";
          // We will add Edit and Delete buttons here
          echo "<a href='edit_dosen.php?npk=" . $row['npk'] . "' class='btn-edit'>Edit</a> ";
          echo "<a href='delete_dosen.php?npk=" . $row['npk'] . "' class='btn-delete'>Delete</a>";
          echo "</td>";
          echo "</tr>";
        }
      } else {
        // Display a message if there are no lecturers
        echo "<tr><td colspan='3'>No lecturers found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<?php
// Include the footer
require_once('../partials/footer.php');
?>