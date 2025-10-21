<?php
require_once('Database.php');

class Grup extends Database {
    public function getTotalCount() {
        $sql = "SELECT COUNT(*) as total FROM grup";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>