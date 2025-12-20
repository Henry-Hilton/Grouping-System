<?php
require_once('../classes/Database.php');

if (isset($_POST['query']) && isset($_POST['idgrup'])) {
    $search = "%" . $_POST['query'] . "%";
    $idgrup = $_POST['idgrup'];

    $sql = "SELECT nrp, nama FROM mahasiswa 
            WHERE (nama LIKE ? OR nrp LIKE ?) 
            AND nrp NOT IN (
                SELECT nrp_mahasiswa FROM akun 
                WHERE username IN (SELECT username FROM member_grup WHERE idgrup = ?)
                AND nrp_mahasiswa IS NOT NULL
            )
            LIMIT 5";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssi", $search, $search, $idgrup);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<table class="data-table" style="background: white;">';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlentities($row['nrp']) . '</td>';
            echo '<td>' . htmlentities($row['nama']) . '</td>';
            echo '<td><button class="btn-add btn-add-ajax" data-nrp="' . $row['nrp'] . '">Add</button></td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No matching students found (or they are already in the group).</p>';
    }
}
?>