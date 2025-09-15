<?php
// db_connect.php

// Define connection parameters based on the project guideline
$servername = "localhost";
$username = "root";
$password = ""; // As per the guideline, the password is empty
$dbname = "fullstack";

// Create a new MySQLi connection object
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($mysqli->connect_errno) {
  // If there's an error, stop the script and display the error message
  die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

?>