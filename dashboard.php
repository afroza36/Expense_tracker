<?php 
session_start();
if (!isset($_SESSION['id'])) {
    // Redirect to login page
    header('Location: login.html');
    exit();
}

require "db.php";
if(isset($_GET["month"])) {
    $currentMonthName= $_GET["month"];
}
else{
    $currentMonthName = date('F');
}

$currentMonthTimestamp = strtotime($currentMonthName . " 1 " . date('Y'));

// To get the previous month timestamp and name:
$previousMonthTimestamp = strtotime('-1 month', $currentMonthTimestamp);
$previousMonthName = date('F', $previousMonthTimestamp);

// To get the next month timestamp and name:
$nextMonthTimestamp = strtotime('+1 month', $currentMonthTimestamp);
$nextMonthName = date('F', $nextMonthTimestamp);

$sql="SELECT budget from budget WHERE month='$currentMonthName' AND person_id='$_SESSION[id]'";

$result=mysqli_query($conn,$sql);
$budget=mysqli_fetch_array($result);
if(!$budget) {
    $budget['budget']=0;
}

// Define query to select expenses from database
$query = "SELECT * FROM expense WHERE MONTHNAME(tyme) = '$currentMonthName' AND person_id='$_SESSION[id]'  ORDER BY tyme DESC ";
$query_total_ex="SELECT SUM(amount) as sum FROM expense WHERE MONTHNAME(tyme) = '$currentMonthName' AND person_id='$_SESSION[id]'  ORDER BY tyme DESC ";

$result_total_ex=mysqli_query($conn,$query_total_ex);
$total_ex=mysqli_fetch_array($result_total_ex);
$total_ex=$total_ex['sum'];
$remain_total_ex=$budget['budget']-$total_ex;

$result = $conn->query($query);

// Check for errors
if(!$result){
    die("Query failed: " . $conn->error);
}

// Fetch the expenses and store them in an associative array
$expenses = [];
while($row = $result->fetch_assoc()) {
    $expenses[] = $row;
}


// Close the connection
$conn->close();
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .dashboard {
            background-color: white;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
        }
        .month-selection {
            text-align: center;
            margin: 20px 0;
        }
        .month-selection a {
            text-decoration: none;
            color: #00f;
            margin: 0 10px;
        }
        .budget-summary {
            background-color: #e9e9e9;
            padding: 10px;
            border-radius: 5px;
        }
        .budget-summary p {
            margin: 10px 0;
        }
        #summaryMonth {
            font-weight: bold;
        }
        button {
            padding: 8px 16px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .actions {
            margin-top: 20px;
            text-align: center;
        }
        .expense-list table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .expense-list th, .expense-list td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .expense-list th {
            background-color: #f8f8f8;
        }
        .expense-list td {
            background-color: #fff;
        }
        .expense-list a {
            text-decoration: none;
            color: #00f;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Budget Dashboard</h1>

        <div class="month-selection">
            <a href="?month=<?php echo $previousMonthName ;?>" id="prevMonth">&lt; Previous Month</a>
            <span id="currentMonth"><?php echo $currentMonthName; ?></span>
            <a href="?month=<?php echo $nextMonthName ;?>" id="nextMonth">Next Month &gt;</a>
        </div>

        <div class="budget-summary">
            <h2>Budget Summary for <span id="summaryMonth">Month Name</span></h2>
            <p>Total Budget: <span id="totalBudget">$ <?php echo $budget['budget'] ?></span>
            <button onclick="window.location.href='budget.php';">Update Budget</button></p>

            <p>Total Spent: <span id="totalSpent"><?php echo $total_ex ?></span></p>
            <p>Remaining: <span id="remaining"><?php echo $remain_total_ex ?></span></p>
        </div>

        <div class="actions">
            <!-- Buttons for adding expense and category -->
            <button onclick="window.location.href='expense.php?month=<?php echo $currentMonthName; ?>';">Add Expense</button>
            <button onclick="window.location.href='category.php';">Add Category</button>
            <button onclick="window.location.href='logout.php';" style="background-color: red; color: white; border: none; padding: 8px 16px; cursor: pointer;">Log out</button>

        </div>

        <div class="expense-list">
            <h2>Expenses</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Amount</th>
                    </tr>
                </thead>

                <tbody>
                      
                <!-- PHP code to dynamically list expenses -->
                <?php foreach($expenses as $expense): ?>
                <tr>
                    <td><?php echo htmlspecialchars($expense['tyme']); ?></td>
                    <td><?php echo htmlspecialchars($expense['description']); ?></td>
                    <td><?php echo htmlspecialchars($expense['category']); ?></td>
                    <td><?php echo htmlspecialchars($expense['amount']); ?></td>
                </tr>
                <?php endforeach; ?>
          
                </tbody>
            </table>
            <a href="download_expenses.php">Download as CSV</a>

        </div>
    </div>

    <script>
        // Implement JavaScript if needed for dynamic behavior
    </script>
</body>
</html>
