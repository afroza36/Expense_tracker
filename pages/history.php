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

$query = "SELECT * FROM expense WHERE  person_id='$_SESSION[id]'  ORDER BY tyme DESC ";

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
    <link rel="stylesheet" href="../css/main.css">
    <script src="../css/main.js" defer></script> 
</head>
<body>
    <?php include "../pages/menu.php" ?>
    <div class="dashboard">
    <div class="expense-list">
        <h2>Expenses</h2>
        <form action="#" method="POST">
            <label for="start-date">Start Date: </label>
            <input type="date" name="startdate" id="start-date">
            <label for="end-date">End Date: </label>
            <input type="date" name="enddate" id="end-date">
            <input type="submit" value="Filter">
        </form>

        <br>

        <form action="#" method="POST">
        <label for="category">Category:</label>
       <select id="Category" name="category" required>
           <option value="">--Select a Category--</option>
           <option value="All">--Select all--</option>

           <?php
           
           if(isset($_GET["month"])) {
            $currentMonthName= $_GET["month"];
        }
        else{
            $currentMonthName = date('F');
        }
          
           require "../backend/db.php";
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
            <input type="submit" value="Filter">
        </form>

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
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    

                    if (isset($_POST['category']) && $_POST['category'] !== 'All') {
                        $filteredExpenses = array_filter($expenses, function($expense) {
                            return strtolower($expense['category']) === strtolower($_POST['category']);
                        });
                    }
                    elseif(isset($_POST['startdate']) && isset($_POST['enddate'])) {
                        $filteredExpenses = array_filter($expenses, function($expense) {
                            $startDate = date_create($_POST['startdate']);
                            $endDate = date_create($_POST['enddate']);
                            $expenseDate = date_create($expense['tyme']);
                            return ($expenseDate >= $startDate && $expenseDate <= $endDate);
                        });
                    }else{
                        $filteredExpenses = $expenses;
                    }
                } else {
                    $filteredExpenses = $expenses;
                }

                foreach($filteredExpenses as $expense): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($expense['tyme']); ?></td>
                        <td><?php echo htmlspecialchars($expense['description']); ?></td>
                        <td><?php echo htmlspecialchars($expense['category']); ?></td>
                        <td><?php echo htmlspecialchars($expense['amount']); ?></td>
                    </tr>
                <?php endforeach; ?>       
            </tbody>

        </table>
        <?php
            // Initialize variables for query parameters
            $categoryParam = '';
            $dateParams = '';

            // Check if the category is set and not 'All'
            if (isset($_POST['category']) && $_POST['category'] !== '' && $_POST['category'] !== 'All') {
                $categoryParam = 'category=' . urlencode($_POST['category']);
            }

            // Check if the start date and end date are set
            if (isset($_POST['startdate']) && isset($_POST['enddate']) && $_POST['startdate'] !== '' && $_POST['enddate'] !== '') {
                $dateParams = 'startdate=' . $_POST['startdate'] . '&enddate=' . $_POST['enddate'];
            }

            // Combine parameters for the download link
            $queryParams = array_filter([$categoryParam, $dateParams]);
            $queryString = !empty($queryParams) ? '?' . implode('&', $queryParams) : '';

            // Output the download link
            echo '<a href="../backend/download_expenses.php' . $queryString . '">Download as CSV</a>';
        ?>
    </div>
    </div>

</body>
</html>