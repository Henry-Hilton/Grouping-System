<?php
$required_role = 'dosen';
require_once('../partials/check_session.php');
require_once('../partials/header.php');
require_once('../db_connect.php');

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}
$idgrup = $_GET['id'];

// Fetch Group Info for the title
$sql = "SELECT nama FROM grup WHERE idgrup = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $idgrup);
$stmt->execute();
$group = $stmt->get_result()->fetch_assoc();
?>

<div class="container">
    <a href="group_details.php?id=<?php echo $idgrup; ?>" class="btn-cancel">← Back to Details</a>
    <h1>Manage Members: <?php echo htmlentities($group['nama']); ?></h1>

    <div class="card" style="padding: 20px; background: #f0f8ff; margin-bottom: 30px; border: 1px solid #bde0fe;">
        <h3>Add New Member</h3>
        <p>Search for a student by Name or NRP to add them.</p>

        <input type="text" id="search_query" class="form-control" placeholder="Type Name or NRP..." autocomplete="off">

        <div id="search_results" style="margin-top: 15px;">
        </div>
    </div>

    <h3>Current Members</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>NRP</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="current_members_body">
            <?php
            // Initial load of members
            $sql_members = "SELECT m.nrp, m.nama 
                            FROM member_grup mg 
                            JOIN mahasiswa m ON mg.username = m.nrp 
                            WHERE mg.idgrup = ? 
                            ORDER BY m.nama ASC";
            $stmt_members = $mysqli->prepare($sql_members);
            $stmt_members->bind_param("i", $idgrup);
            $stmt_members->execute();
            $result_members = $stmt_members->get_result();

            if ($result_members->num_rows > 0) {
                while ($row = $result_members->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlentities($row['nrp']) . "</td>";
                    echo "<td>" . htmlentities($row['nama']) . "</td>";
                    echo "<td><a href='delete_member.php?idgrup=$idgrup&nrp=" . $row['nrp'] . "' class='btn-delete' onclick='return confirm(\"Remove this student?\")'>Remove</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' id='no-members-row'>No members yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        $('#search_query').on('keyup', function () {
            var query = $(this).val();
            var idgrup = '<?php echo $idgrup; ?>';

            if (query.length > 2) {
                $.ajax({
                    url: 'ajax_search_student.php',
                    method: 'POST',
                    data: { query: query, idgrup: idgrup },
                    success: function (data) {
                        $('#search_results').html(data);
                    }
                });
            } else {
                $('#search_results').html('');
            }
        });

        $(document).on('click', '.btn-add-ajax', function () {
            var nrp = $(this).data('nrp');
            var idgrup = '<?php echo $idgrup; ?>';
            var btn = $(this);

            $.ajax({
                url: 'ajax_add_member.php',
                method: 'POST',
                data: { nrp: nrp, idgrup: idgrup },
                success: function (response) {
                    if (response.trim() === 'success') {
                        location.reload();
                    } else {
                        alert('Failed to add member.');
                    }
                }
            });
        });
    });
</script>

<?php require_once('../partials/footer.php'); ?>