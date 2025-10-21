<?php

class Database {
    protected $mysqli;

    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "fullstack";
        
        $this->mysqli = new mysqli($servername, $username, $password, $dbname);

        if ($this->mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $this->mysqli->connect_error);
        }
    }
}
?>