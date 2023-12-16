<?php
session_start();
require "db.php";
$currentMonthName = date('F');
$query = "SELECT * FROM expense WHERE MONTHNAME(tyme) = '$currentMonthName' AND person_id='$_SESSION[id]'  ORDER BY tyme DESC ";
$result = $conn->query($query);
$expenses = [];
while($row = $result->fetch_assoc()) {
    $expenses[] = $row;
}
// Filename for the CSV download
$filename = "expenses_" . date('Ymd') . ".csv";

// Set the Content-Type and Content-Disposition headers to force the download.
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Open the PHP output stream
$output = fopen('php://output', 'w');

// Optional: If you want the keys to be saved as the first row as headers in the CSV
fputcsv($output, array('Date', 'Description', 'Category', 'Amount'));

// Loop over the array of expenses and output each row
foreach($expenses as $expense) {
    fputcsv($output, array(
        $expense['tyme'],
        $expense['description'],
        $expense['category'],
        $expense['amount']  // Make sure this is a string or number, not a float or string representation of money
    ));
}

// Close the output stream
fclose($output);

// Terminate the script
exit();
