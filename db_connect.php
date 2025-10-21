<?php


$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "fullstack";


$mysqli = new mysqli($servername, $username, $password, $dbname);


if ($mysqli->connect_errno) {
  
  die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

?>