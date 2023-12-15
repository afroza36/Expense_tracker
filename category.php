<?php
// Start the session
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Insert Category</title>
</head>
<body>

<h2>Category Insertion Form</h2>

<form action="save_category.php" method="post">
  <label for="categoryName">Category Name:</label><br>
  <input type="text" id="categoryName" name="categoryName" required><br>
  
  <label for="month">Month:</label><br>
  <select id="month" name="month" required>
    <option value="">--Select a Month--</option>
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
  </select><br>
  
  <label for="budget">Budget:</label><br>
  <input type="number" id="budget" name="budget" required step="0.01"><br><br>
  <input type="number" id="person_id" name="person_id" value="<?php echo $_SESSION['id'];?>" hidden>

  
  <input type="submit" value="Submit">
</form>

</body>
</html>
