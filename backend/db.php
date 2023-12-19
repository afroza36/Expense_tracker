<?php
// Establish database connection
$servername = "localhost"; # add port  if needed
$username = "root";
$password = ""; # add password if needed
$dbname = "expense";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>