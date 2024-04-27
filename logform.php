<?php
session_start();

$conn = new mysqli("sql307.infinityfree.com", "if0_36040027", "WOeS5G5X9Esua", "if0_36040027_logindata");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate input fields
    // You can add more validation here

    // Check user credentials in the database
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, set session variables and redirect to dashboard
        $_SESSION["username"] = $username;
        echo "login successful";
        
    } else {
        // Invalid credentials, show error message
        echo "Invalid username or password";
    }
}

// Close connection
$conn->close();
?>