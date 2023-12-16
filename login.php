<?php
// Establish database connection
require "db.php";

// Retrieve form data
$email = $_POST['email'];
$password = $_POST['password'];

// Sanitize and validate inputs (optional, but highly recommended)

// Query the database for the user with the given email
$sql = "SELECT * FROM sign_info WHERE email='$email'";

$result=mysqli_query($conn,$sql);//query excecute

if (mysqli_num_rows($result)> 0) {//checks if the result of the SQL query contains any rows. returns the number of rows returned by the query execution. If there are no rows, it will return 0.
    $user = $result->fetch_assoc();//fetches the current row of the result set as an associative array and assigns it to the variable $user.
    // Verify the entered password against the stored password
    if ($user['password']==$password) {// used to verify if the entered password matches the stored password for the user in the database.
        echo "Login successful!";

        session_start();

        $_SESSION["id"] = $user['id'];
        //i save database user id in session
        // Perform further actions after successful login (e.g., redirect to a restricted area)

        header("location:dashboard.php");
    } else {
        echo "Incorrect password";
    }
} else {
    echo "User not found";
}

$conn->close();
?>
