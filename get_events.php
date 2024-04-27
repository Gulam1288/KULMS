<?php
// Database credentials
include_once('db_connect.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch events from database
$sql = "SELECT * FROM events";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output events as JSON
    $events = array();
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    echo json_encode($events);
} else {
    echo json_encode([]);
}

// Close connection
$conn->close();
?>
