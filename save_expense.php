<?php
// Make sure you start the session on every page where you need to access session variables
session_start();

// If the user is not logged in, redirect them to the login page, or handle the case as needed
if (!isset($_SESSION['id'])) {
    // Redirect to login page
    header('Location: login.php');
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters (example settings; replace with your own)
    $host = 'localhost:3366';
    $username = 'root';
    $password = '';
    $dbname = 'expense';

    // Create a new connection to the database
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $personId = $_SESSION['id']; 
    $expenseDate = $_POST['expenseDate'];
    $expenseDescription = $_POST['expenseDescription'];
    $expenseAmount = $_POST['expenseAmount'];
    $expenseCategory = $_POST['expenseCategory'];
    
    

    // Create the SQL query to insert the expense
    $sql = "INSERT INTO expense (person_id, tyme, description, amount, category) VALUES ('$personId', '$expenseDate', '$expenseDescription', '$expenseAmount', '$expenseCategory')";

    // Execute the query and check if it was successful
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        // Redirect to the dashboard or other appropriate page
        header('Location: dashboard.html');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    // Handle the case where the form wasn't submitted properly
    echo "Invalid request method.";
}
?>
