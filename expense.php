<?php
session_start();
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
           <!-- Category options will be populated here -->
           <?php
           //This PHP block is where you connect to database and query for categories.
           // You will need to adjust the following code to match your own database connection details and table/column names.

           // Database connection parameters (example settings; replace with your own)
           $host = 'localhost:3366';
           $username = 'root';
           $password = '';
           $dbname = 'expense';

           // Create connection
           $conn = new mysqli($host, $username, $password, $dbname);

           // Check connection
           if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
           }
           $currentMonthName = date('F');
         

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
   </form>
   <!-- Link to go back to the dashboard -->
   <a href="dashboard.html">Back to Dashboard</a>

   <!-- JavaScript files and scripts -->
</body>
</html>
