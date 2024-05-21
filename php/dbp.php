<?php
// Database configuration
$host = "phpmyadmin.alwaysdata.com";
$dbuser = "root";
$dbpass = "Azerty";
$dbname = "vroomcar";

// Create database connection
$link = mysqli_connect($host, $dbuser, $dbpass, $dbname);

// Check connection
if(!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Example query to fetch data
$query = "SELECT * FROM your_table_name";
$result = mysqli_query($link, $query);

// Fetch data and output as JSON
$data = array();
while($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);

// Close connection
mysqli_close($link);
?>
