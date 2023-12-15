<?php
 
require "db.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Sanitize and validate inputs (optional, but highly recommended)

// Insert user data into the database
$sql = "INSERT INTO sign_info (name, email, password) VALUES ('$name', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "User registered successfully!";
    header("location: login.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
