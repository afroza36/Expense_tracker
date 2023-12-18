<?php
// Start the session
session_start();
if (!isset($_SESSION['id'])) {
    // Redirect to login page
    header('Location:../pages/login.html');
    exit();
}
if (isset($_SESSION["error"])) {
    $error = $_SESSION["error"];
    unset($_SESSION["error"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Category</title>
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
        h2 {
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
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
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
        <p>Error: <?php echo $error; ?></p>
    </div>
<?php } ?>

<h2>Category Insertion Form</h2>

<form action="../backend/save_category.php" method="post">
    <label for="categoryName">Category Name:</label>
    <input type="text" id="categoryName" name="categoryName" required>

    <label for="month">Month:</label>
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
    </select>

    <label for="budget">Budget:</label>
    <input type="number" id="budget" name="budget" required >

    <input type="number" id="person_id" name="person_id" value="<?php echo $_SESSION['id']; ?>" hidden>

    <input type="submit" value="Submit">
</form>

</body>
</html>
