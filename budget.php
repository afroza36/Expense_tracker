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
    <input type="number" id="budget" name="budget"  required><br><br>

    <input type="number" id="person_id" name="person_id" value="<?php echo $_SESSION['id'];?>" hidden><br><br>

    <input type="submit" value="Insert Budget">
  </form>
</body>
</html>
