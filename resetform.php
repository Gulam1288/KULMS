<?php
$conn = new mysqli("sql307.infinityfree.com", "if0_36040027", "WOeS5G5X9Esua", "if0_36040027_logindata");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process signup form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate input fields
    // You can add more validation here

    // Check if username already exists in the database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $sql = "UPDATE users SET password = '$password' WHERE username = '$username'";
        if ($conn->query($sql) === TRUE) {
            // Send email with new password
            echo "Password reset successfully.";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        // Username does not exist, show error message
        echo "Username not found";
    }
}

// Close connection
$conn->close();
?>