<?php
session_start();
require "db.php";
if (!isset($_SESSION['id'])) {
    // Redirect to login page
    header('Location: login.html');
    exit();
}

$budget=$_POST["budget"] ;
$person_id=$_POST["person_id"];
$month=$_POST["month"];

// Sanitize and validate inputs (optional, but highly recommended)

// Insert user data into the database
$check_date = "SELECT * FROM budget WHERE person_id='$person_id' and month='$month'";
$result=mysqli_query($conn,$check_date);//database query
if (mysqli_num_rows($result)> 0) {
    $update_que="UPDATE budget SET budget = '$budget' WHERE person_id = '$person_id' AND month = '$month'";
    if ($conn->query($update_que) === TRUE) {
        echo "budget updated successfully!";
        header("location:dashboard.php");
    } else {
        echo "Error: " . $update_que . "<br>" . $conn->error;
    }

}
else{



$bud_month_insert = "INSERT INTO budget (budget, person_id, month) VALUES ('$budget', '$person_id','$month')";

if ($conn->query($bud_month_insert) === TRUE) {
    echo "budget save successfully!";
    header("location:dashboard.php");
} else {
    echo "Error: " . $bud_month_insert . "<br>" . $conn->error;
}
}

$conn->close();
?>
