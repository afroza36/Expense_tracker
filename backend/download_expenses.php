<?php
session_start();

require_once "../backend/db.php";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=expenses.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('Date', 'Description', 'Category', 'Amount')); // CSV Header

if (isset($_SESSION['id'])) {
    $person_id = $_SESSION['id'];

    $whereClauses = [];

    if (isset($_GET['category']) && $_GET['category'] !== '' && $_GET['category'] !== 'All') {
        $category = $conn->real_escape_string($_GET['category']);
        $whereClauses[] = "category = '$category'";
    }

    if (isset($_GET['startdate']) && isset($_GET['enddate'])) {
        $startDate = $conn->real_escape_string($_GET['startdate']);
        $endDate = $conn->real_escape_string($_GET['enddate']);
        $whereClauses[] = "DATE(tyme) BETWEEN '$startDate' AND '$endDate'";
    }

    $whereSQL = !empty($whereClauses) ? 'AND ' . implode(' AND ', $whereClauses) : '';

    $query = "SELECT * FROM expense WHERE person_id='$person_id' $whereSQL ORDER BY tyme DESC";
    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, array($row['tyme'], $row['description'], $row['category'], $row['amount']));
        }
    }

    $conn->close();
} else {
    header('Location: ../pages/login.html');
}
?>