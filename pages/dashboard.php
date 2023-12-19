<?php 
session_start();
if (!isset($_SESSION['id'])) {
    // Redirect to login page
    header('Location: ../pages/login.html');
    exit();
}

require "../backend/db.php";
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


$category_expense_query = "
    SELECT 
        category AS category_name, 
        SUM(amount) AS total_amount 
    FROM 
        expense 
    WHERE 
        MONTHNAME(tyme) = '$currentMonthName' AND 
        person_id = '".$_SESSION['id']."' 
    GROUP BY 
        category 
    ORDER BY 
        total_amount DESC";

$category_expense_result = mysqli_query($conn, $category_expense_query);

$category_expenses = [];
while($category_row = $category_expense_result->fetch_assoc()) {
    $category_expenses[] = $category_row;
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
            display: flex;
            flex-direction: column;
            align-items: center;
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

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Ensures cards are responsive */
            gap: 20px;
            width: 100%;
            margin-top: 20px;
        }

        .grid:first-of-type {
            margin-bottom: 40px; /* This creates space between your first grid and the second grid */
        }

        .card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);
        }
    </style>
    <link rel="stylesheet" href="../css/main.css">
    <script src="../css/main.js" defer></script> 
</head>
<body>
    <?php include "../pages/menu.php" ?>
    <div class="dashboard">
        <h1>Budget Dashboard</h1>

        <div class="month-selection">
            <a href="?month=<?php echo $previousMonthName ;?>" id="prevMonth">&lt; Previous Month</a>
            <span id="currentMonth"><?php echo $currentMonthName; ?></span>
            <a href="?month=<?php echo $nextMonthName ;?>" id="nextMonth">Next Month &gt;</a>
        </div>

        <div class="grid" style="margin-bottom: 40px;">
            <div class="card">
                <h2>Total Budget</h2>
                <p><strong>$<?= $budget['budget'] ?></strong></p>
                <button onclick="window.location.href='../pages/budget.php';">Update Budget</button>
            </div>
            <div class="card">
                <h2>Total Spent</h2>
                <p><strong>$<?= $total_ex ?></strong></p>
            </div>
            <div class="card">
                <h2>Remaining</h2>
                <p><strong>$<?= $remain_total_ex ?></strong></p>
            </div>
        </div>
        
        <!-- Category wise cards -->
        <div class="grid">
            <?php foreach($category_expenses as $cat_exp): ?>
            <div class="card">
                <h3><?= htmlspecialchars($cat_exp['category_name']) ?></h3>
                <p>Total Spent: <strong>$<?= number_format($cat_exp['total_amount'], 2) ?></strong></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        // Implement JavaScript if needed for dynamic behavior
    </script>
</body>
</html>
