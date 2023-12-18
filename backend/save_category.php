
<?php
session_start();
if (!isset($_SESSION['id'])) {
    // Redirect to login page
    header('Location: ../pages/login.html');
    exit();
}

require "../backend/db.php";

$month = $_POST['month'];

$sql="SELECT budget from budget WHERE month='$month' AND person_id='$_SESSION[id]'";

$result=mysqli_query($conn,$sql);
$budget=mysqli_fetch_array($result);

$bud_int=(int)$budget["budget"];

$sum_category = "SELECT SUM(budget) as sum FROM category WHERE person_id='$_SESSION[id]' and month='$month'";
$result=mysqli_query($conn,$sum_category);
$sum_category = mysqli_fetch_array($result);
$prev_total=(int)$sum_category['sum'];

$name = $_POST['categoryName'];
$budget = $_POST['budget'];
$person_id=$_POST["person_id"];


$category_total=$prev_total+$budget;

if ($category_total>$bud_int) {
   
     $_SESSION['error']='category budget exceeded total budget';
     header('location:../pages/category.php');
 }
else{

$check_category = "SELECT * FROM category WHERE person_id='$person_id' and month='$month'and name='$name'";
$result=mysqli_query($conn,$check_category);//database query

#echo $result->num_rows;
if (mysqli_num_rows($result)> 0) {
    $update_que="UPDATE category SET budget = '$budget' WHERE person_id = '$person_id' AND month = '$month' AND name='$name'";
    if ($conn->query($update_que) === TRUE) {
        echo "category updated successfully!";
        header("location:../pages/dashboard.php");
    } else {
        echo "Error: " . $update_que . "<br>" . $conn->error;
    }
}

else{

        $cat_month_insert = "INSERT INTO category (name,budget, person_id, month) VALUES ('$name','$budget', '$person_id','$month')";
        
        if ($conn->query($cat_month_insert) === TRUE) {
            echo "category save successfully!";
            header("location:../pages/dashboard.php");
        } else {
            echo "Error: " . $bud_month_insert . "<br>" . $conn->error;
        }
        }
           
        $conn->close();
    }
        ?>



