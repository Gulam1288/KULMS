<?php
// Start the session
session_start();

// Check if the role is set in the session
if(isset($_SESSION['role'])) {
    // Check if the role is 'yes'
    if($_SESSION['role'] == 'yes') {
        // Send a success response
        $response = array('success' => true, 'role' => 'yes');
        echo json_encode($response);
    } else {
        // Send a failure response if role is not 'yes'
        $response = array('success' => true, 'role' => 'no');
        echo json_encode($response);
    }
} else {
    // Send a failure response if role is not set
    $response = array('success' => false, 'message' => 'Role is not set');
    echo json_encode($response);
}
?>
