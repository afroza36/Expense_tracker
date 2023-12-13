<?php
// Establish database connection
$servername = "localhost:3366";
$username = "root";
$password = "";
$dbname = "expense";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$budget=$_POST["budget"] ;
$person_id=$_POST["person_id"];

// Sanitize and validate inputs (optional, but highly recommended)

// Insert user data into the database
$sql = "INSERT INTO budget (budget, person_id) VALUES ('$budget', '$person_id')";

if ($conn->query($sql) === TRUE) {
    echo "budget save successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
