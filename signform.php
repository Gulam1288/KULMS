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
        // Username already exists, show error message
        echo "Username already exists";
    } else {
        // Insert new user data into the database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "User registered successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>