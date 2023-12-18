<?php
// Establish database connection
require "../backend/db.php";

session_start();

// Initialize response array
$response = array('success' => false, 'message' => '');

// Check if the request is coming through AJAX and the required POST parameters are set
if (isset($_POST['email']) && isset($_POST['password'])) {
    
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize and validate inputs (optional, but highly recommended)
    // ...

    // Query the database for the user with the given email
    $sql = "SELECT * FROM sign_info WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = $result->fetch_assoc();
        // Verify the entered password against the stored password
        if ($user['password'] == $password) {
            // Successful login
            $response['success'] = true;
            $response['message'] = "Login successful!";
            
            // Set session variables
            $_SESSION["id"] = $user['id'];

            // Here you can set additional session variables as needed.
        
        } else {
            // Incorrect password
            $response['message'] = "Incorrect password";
        }
    } else {
        // User not found
        $response['message'] = "User not found";
    }
} else {
    $response['message'] = "Required parameters not provided!";
}

$conn->close();

// Encode response as JSON and send back to the client
echo json_encode($response);
?>
