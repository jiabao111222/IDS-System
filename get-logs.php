<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow access from all origins

// Database configuration
$servername = "localhost";
$username = "root"; // Use your own database username
$password = "JiaBao1220!"; // Use your own database password
$dbname = "logs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query data from the database
$sql = "SELECT No, Time, Event, Catch, IP, Status FROM log_entries";
$result = $conn->query($sql);

$logs = array();

// Store the query results in an array
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
}

// Close the connection
$conn->close();

// Return data in JSON format
echo json_encode($logs);
?>
