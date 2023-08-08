<?php
session_start();
require_once "config.php";

// Fetch data from MySQL table (limited to last 50 records by ID)
$sql = "SELECT id, value FROM demo ORDER BY id DESC LIMIT 50";
$result = mysqli_query($conn, $sql);

// Store data in an array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        "x" => $row["id"],
        "y" => $row["value"]
    );
}

// Close database connection
$conn->close();
?>
