<?php
$servername = "localhost:3366"; // Server name
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "expense"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['categoryName'];
$month = $_POST['month'];
$budget = $_POST['budget'];
$person_id=$_POST["person_id"];

$sql = "INSERT INTO category (name,month,budget,) VALUES ('$name','$month','$budget')";
$check_category = "SELECT * FROM category WHERE person_id='$person_id' and month='$month'and name='$name'";
$result=mysqli_query($conn,$check_category);//database query

echo $result->num_rows;
if (mysqli_num_rows($result)> 0) {
    $update_que="UPDATE category SET budget = '$budget' WHERE person_id = '$person_id' AND month = '$month' AND name='$name'";
    if ($conn->query($update_que) === TRUE) {
        echo "category updated successfully!";
        header("location:dashboard.html");
    } else {
        echo "Error: " . $update_que . "<br>" . $conn->error;
    }
}
else{

        $cat_month_insert = "INSERT INTO category (name,budget, person_id, month) VALUES ('$name','$budget', '$person_id','$month')";
        
        if ($conn->query($cat_month_insert) === TRUE) {
            echo "category save successfully!";
        } else {
            echo "Error: " . $bud_month_insert . "<br>" . $conn->error;
        }
        }
        
        $conn->close();
        ?>



