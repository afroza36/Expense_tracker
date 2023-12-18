<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie


// Finally, destroy the session
session_destroy();

// Redirect to the login page:
header("Location: ../pages/login.html");
exit();
?>
