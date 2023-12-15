<?php
session_start();
require "db.php";

$currentMonthName = date('F');
$sql="SELECT budget from budget WHERE month='$currentMonthName' AND person_id='$_SESSION[id]'";

$result=mysqli_query($conn,$sql);
$budget=mysqli_fetch_array($result);


// Define query to select expenses from database
$query = "SELECT * FROM expense WHERE MONTHNAME(tyme) = '$currentMonthName' AND person_id='$_SESSION[id]'  ORDER BY tyme DESC ";

// Execute the query
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
    <!-- You may want to link to your CSS and JavaScript files here -->
</head>
<body>
    <div class="dashboard">
        <h1>Budget Dashboard</h1>

        <div class="month-selection">
            <a href="?month=previous" id="prevMonth">&lt; Previous Month</a>
            <span id="currentMonth"><?php echo $currentMonthName; ?></span>
            <a href="?month=next" id="nextMonth">Next Month &gt;</a>
        </div>

        <div class="budget-summary">
            <h2>Budget Summary for <span id="summaryMonth">Month Name</span></h2>
            <p>Total Budget: <span id="totalBudget">$ <?php echo $budget['budget'] ?></span></p>
            <p>Total Spent: <span id="totalSpent">$0.00</span></p>
            <p>Remaining: <span id="remaining">$0.00</span></p>
        </div>

        <div class="actions">
            <!-- Buttons for adding expense and category -->
            <button onclick="window.location.href='expense.php';">Add Expense</button>
            <button onclick="window.location.href='category.php';">Add Category</button>
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
        </div>
    </div>

    <script>
        // Implement JavaScript if needed for dynamic behavior
    </script>
</body>
</html>
