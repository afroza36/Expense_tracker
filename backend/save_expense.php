<?php
// Make sure you start the session on every page where you need to access session variables
session_start();

// If the user is not logged in, redirect them to the login page, or handle the case as needed
if (!isset($_SESSION['id'])) {
    // Redirect to login page
    header('Location:../pages/login.html');
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters (example settings; replace with your own)
    require "../backend/db.php";
    $personId = $_SESSION['id']; 
    $expenseDate = $_POST['expenseDate'];
    $expenseDescription = $_POST['expenseDescription'];
    $expenseAmount = $_POST['expenseAmount'];
    $expenseCategory = $_POST['expenseCategory'];
    
    $cat_budget=" SELECT budget FROM category WHERE name='$expenseCategory' AND person_id='$_SESSION[id]' AND month=MONTHNAME('$expenseDate') ";
    $result=mysqli_query($conn,$cat_budget);
    if (mysqli_num_rows($result) > 0) {
        $budget = mysqli_fetch_array($result);
        }

    $exp_sum=" SELECT SUM(amount) as sum FROM expense WHERE category='$expenseCategory' AND person_id='$_SESSION[id]' AND MONTHNAME(tyme)=MONTHNAME('$expenseDate') ";
    
    $expense_sum=mysqli_query($conn,$exp_sum);

    if (mysqli_num_rows($expense_sum) > 0) {

        $expense_sum=mysqli_fetch_array($expense_sum);
        
    }
    $new_total=$expenseAmount+$expense_sum["sum"];
    if ($new_total> $budget["budget"]) {

        $_SESSION['error']='expense amount exceeded category  total ';
        header('location:../pages/expense.php');
    }

    else{
        
    $sql = "INSERT INTO expense (person_id, tyme, description, amount, category) VALUES ('$personId', '$expenseDate', '$expenseDescription', '$expenseAmount', '$expenseCategory')";

    // Execute the query and check if it was successful
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        // Redirect to the dashboard or other appropriate page
        header('Location: ../pages/dashboard.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
    }
}

else {
    // Handle the case where the form wasn't submitted properly
    echo "Invalid request method.";
}
?>
