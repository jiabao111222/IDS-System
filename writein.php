<?php

require 'mail_test.php';

$servername = "localhost";
$username = "root";
$password = "JiaBao1220!";
$dbname = "logs";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
date_default_timezone_set('Asia/Kuala_Lumpur'); // Set the timezone to Malaysia time

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // X-Forwarded-For may return multiple IPs, take the first one
        $forwarded_ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($forwarded_ips[0]);
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

$event = isset($_POST['event']) ? $_POST['event'] : 'Unknown Event';
$catch = isset($_POST['catch']) ? $_POST['catch'] : 'Unknown Error';
$ip = getUserIP();
if ($ip === '::1') {
    $ip = '127.0.0.1';
}
$status = isset($_POST['status']) ? $_POST['status'] : 'Failed'; // Default to 'Failed'
$time = date('Y-m-d H:i:s'); // Current time

// Output the captured parameters
echo "Event: " . $event . "<br>";
echo "Catch: " . $catch . "<br>";
echo "IP: " . $ip . "<br>";
echo "Status: " . $status . "<br>";
echo "Time: " . $time . "<br>";

// Check how many failures have occurred from the same IP
$ip_check_query = "SELECT COUNT(*) as fail_count FROM log_entries WHERE IP = ? AND Status = 'Failed' AND Time > (NOW() - INTERVAL 1 HOUR)";
$stmt_check = $conn->prepare($ip_check_query);
$stmt_check->bind_param("s", $ip);
$stmt_check->execute();
$result = $stmt_check->get_result();
$row = $result->fetch_assoc();
$fail_count = $row['fail_count'];

// Insert a new log entry
$stmt = $conn->prepare("INSERT INTO log_entries (Time, Event, Catch, IP, Status) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $time, $event, $catch, $ip, $status);

if ($stmt->execute()) {
    echo "New record created successfully";

    // If the same IP fails 3 times, send an alert email
    if ($fail_count >= 2) { // Since the current insertion is the third, we use >= 2 to match the third time
        sendEmailToAdmin($ip, $fail_count, $time);
    }

} else {
    error_log("Database Error: " . $stmt->error); // Log the database error
}

// Close the database connection
$stmt->close();
$stmt_check->close();
$conn->close();
?>
