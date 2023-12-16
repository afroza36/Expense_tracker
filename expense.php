<?php
session_start();
if (isset($_SESSION["error"])){
    $error=$_SESSION["error"];
    unset($_SESSION["error"]);
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Expense</title>
   <!-- Stylesheet links and other head elements go here -->
</head>
<body>
<?php
// Display the error message if an error is set
if (isset($error)) {
    echo "<p>Error: " . htmlspecialchars($error) . "</p>"; // Always escape output
}
?>

   <h1>Add Expense</h1>
   
   <form action="save_expense.php" method="POST">
       <label for="expenseDate">Date:</label>
       <input type="date" id="expenseDate" name="expenseDate" required><br><br>

       <label for="expenseDescription">Description:</label>
       <input type="text" id="expenseDescription" name="expenseDescription" required><br><br>

       <label for="expenseAmount">Amount:</label>
       <input type="number" step="0.01" id="expenseAmount" name="expenseAmount" required><br><br>

       <label for="expenseCategory">Category:</label>
       <select id="expenseCategory" name="expenseCategory" required>

           <option value="">--Select a Category--</option>
           
           <?php
           
           
           $currentMonthName = date('F');
         
            require "db.php";
           // Query the database for categories
           $sql = "SELECT  name FROM category WHERE person_id='$_SESSION[id]' AND month= '$currentMonthName'"; // Replace with your actual SQL query
           echo $sql;
           $result = $conn->query($sql); 

           // Check if there are results and loop through them to create options
           if ($result->num_rows > 0) {
               while($row = $result->fetch_assoc()) {
                   echo '<option value="' . $row["name"] . '">' . $row["name"] . '</option>';
               }
           } else {
               echo '<option value="">No categories available</option>';
           }

           // Close the database connection
           $conn->close();
           ?>
        </select><br><br>

       <input type="submit" value="Add Expense">
       <button onclick="window.location.href='category.php';">Add Category</button>
   </form>
   <!-- Link to go back to the dashboard -->
   <a href="dashboard.php">Back to Dashboard</a>

   <!-- JavaScript files and scripts -->
</body>
</html>
