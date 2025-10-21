<?php
require_once('Database.php');

class Event extends Database {
    public function getTotalCount() {
        $sql = "SELECT COUNT(*) as total FROM event";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>