<div id="sidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <h2>Expense Tracker</h2>
    <a href="../pages/expense.php?month=<?php echo $currentMonthName; ?>">Add Expense</a>
    <a href="../pages/category.php">Add Category</a>
    <a href="../pages/history.php">view history</a>
    <a href="../backend/logout.php">Log out</a>
</div>

<div id="main">
    <button class="openbtn" onclick="openNav()"  id="openbtn">☰ Open Sidebar</button>  
    <!-- Rest of the page content -->
</div>