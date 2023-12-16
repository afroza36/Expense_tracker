<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Monthly Budget Tracker</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    h2 {
      text-align: center;
      color: #333;
    }
    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      width: 300px;
    }
    label {
      display: block;
      margin-bottom: 10px;
      color: #555;
    }
    input[type="number"],
    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
    }
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 4px;
      background-color: #28a745;
      color: white;
      cursor: pointer;
      font-size: 16px;
    }
    input[type="submit"]:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>
  <div class="budget-container">
    <h2>Insert Monthly Budget</h2>
    <form action="save_budget.php" method="POST">
      <label for="budget">Monthly Budget:</label>
      <input type="number" id="budget" name="budget" required>

      <label for="month">Month:</label>
      <select id="month" name="month" required>
        <option value="January">January</option>
        <option value="February">February</option>
        <option value="March">March</option>
        <option value="April">April</option>
        <option value="May">May</option>
        <option value="June">June</option>
        <option value="July">July</option>
        <option value="August">August</option>
        <option value="September">September</option>
        <option value="October">October</option>
        <option value="November">November</option>
        <option value="December">December</option>
      </select>

      <input type="number" id="person_id" name="person_id" value="<?php echo $_SESSION['id'];?>" hidden>
      <input type="submit" value="Insert Budget">
    </form>
  </div>
</body>
</html>
