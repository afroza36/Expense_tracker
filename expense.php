<?php
session_start();
if (isset($_SESSION["error"])){
    $error = $_SESSION["error"];
    unset($_SESSION["error"]);
}
if (!isset($_SESSION['id'])) {
    // Redirect to login page
    header('Location: login.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Expense</title>
   <style>
       body {
           font-family: Arial, sans-serif;
           background-color: #f4f4f4;
           margin: 0;
           padding: 0;
           display: flex;
           flex-direction: column;
           align-items: center;
           justify-content: center;
           min-height: 100vh;
       }
       h1 {
           color: #333;
       }
       form {
           background-color: #fff;
           padding: 20px;
           border-radius: 5px;
           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
           margin-bottom: 20px;
       }
       label {
           display: block;
           margin: 10px 0 5px;
       }
       input[type="date"],
       input[type="text"],
       input[type="number"],
       select {
           width: 100%;
           padding: 10px;
           margin-bottom: 10px;
           border: 1px solid #ddd;
           border-radius: 4px;
           box-sizing: border-box;
       }
       input[type="submit"],
       button {
           width: 100%;
           padding: 10px;
           border: none;
           border-radius: 4px;
           background-color: #007bff;
           color: white;
           cursor: pointer;
           font-size: 16px;
       }
       input[type="submit"]:hover,
       button:hover {
           background-color: #0056b3;
       }
       button {
           background-color: #28a745;
           margin-top: 10px;
       }
       button:hover {
           background-color: #218838;
       }
       a {
           color: #007bff;
           text-decoration: none;
       }
       a:hover {
           text-decoration: underline;
       }
       .error-message {
           color: red;
           font-weight: bold;
       }
   </style>
</head>
<body>

<?php if (isset($error)) { ?>
   <div class="error-message">
       <p>Error: <?php echo htmlspecialchars($error); ?></p>
   </div>
<?php } ?>

   <h1>Add Expense</h1>
   
   <form action="save_expense.php" method="POST">
       <label for="expenseDate">Date:</label>
       <input type="date" id="expenseDate" name="expenseDate" required>

       <label for="expenseDescription">Description:</label>
       <input type="text" id="expenseDescription" name="expenseDescription" required>

       <label for="expenseAmount">Amount:</label>
       <input type="number" step="0.01" id="expenseAmount" name="expenseAmount" required>

       <label for="expenseCategory">Category:</label>
       <select id="expenseCategory" name="expenseCategory" required>
           <option value="">--Select a Category--</option>
           <?php
           
           if(isset($_GET["month"])) {
            $currentMonthName= $_GET["month"];
        }
        else{
            $currentMonthName = date('F');
        }
          
           require "db.php";
           $sql = "SELECT name FROM category WHERE person_id='$_SESSION[id]' AND month= '$currentMonthName'";
           // Replace with your actual SQL query
           $result = $conn->query($sql);

           if ($result->num_rows > 0) {
               while($row = $result->fetch_assoc()) {
                   echo '<option value="' . htmlspecialchars($row["name"]) . '">' . htmlspecialchars($row["name"]) . '</option>';
               }
           } else {
               echo '<option value="">No categories available</option>';
           }

           $conn->close();
           ?>
        </select>

        <input type="submit" value="Add Expense">
        <button type="button" onclick="window.location.href='category.php';">Add Category</button>
   </form>
   <a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
