<?php
require_once('Database.php');

class Mahasiswa extends Database
{
    public function getAll($limit, $offset)
    {
        $sql = "SELECT nrp, nama, angkatan, foto_extention FROM mahasiswa WHERE deleted_at IS NULL ORDER BY nrp ASC LIMIT ? OFFSET ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getTotalCount()
    {
        $sql = "SELECT COUNT(*) as total FROM mahasiswa WHERE deleted_at IS NULL";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>