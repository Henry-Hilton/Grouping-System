<?php
class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "fullstack";

    public $mysqli;

    public function __construct()
    {
        $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($this->mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $this->mysqli->connect_error);
        }
    }

    public function prepare($sql)
    {
        return $this->mysqli->prepare($sql);
    }

    public function query($sql)
    {
        return $this->mysqli->query($sql);
    }

    public function escape($string)
    {
        return $this->mysqli->real_escape_string($string);
    }

    public function fetchAll($sql)
    {
        $result = $this->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct()
    {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }
}
?>