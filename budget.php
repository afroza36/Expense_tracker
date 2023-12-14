<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Monthly Budget Tracker</title>
</head>
<body>
  <h2>Insert Monthly Budget</h2>
  <form action="save_budget.php" method="POST">
    <label for="budget">Monthly Budget:</label>
    <input type="number" id="budget" name="budget" required><br><br>

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
    </select><br><br>

    <input type="number" id="person_id" name="person_id" value="<?php echo $_SESSION['id'];?>" hidden>

    <input type="submit" value="Insert Budget">
  </form>
</body>
</html>


