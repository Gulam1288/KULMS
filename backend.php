<?php
session_start();
// Establish database connection (example using MySQLi)
$mysqli = new mysqli("sql307.infinityfree.com", "if0_36040027", "WOeS5G5X9Esua", "if0_36040027_logindata");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
} 

// Function to check if user exists
function userExists($username, $mysqli) {
    $stmt = $mysqli->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows;
    $stmt->close();
    return $count > 0;
}

// Function to signup
function signup($username, $password, $mysqli) {
    if (!userExists($username, $mysqli)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashedPassword);
        $stmt->execute();
        $stmt->close();
        return true;
    } else {
        return false; // User already exists
    }
}

// Function to login
function login($username, $password, $mysqli) {
    $stmt = $mysqli->prepare("SELECT username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($dbUsername, $dbPassword);
    $stmt->fetch();
    if ($dbUsername && password_verify($password, $dbPassword)) {
            $_SESSION['username'] = $username;
            $_SESSION["u-type"] = "users";
            echo "<script>";
            echo "localStorage.setItem('isLoggedIn', 'true');";
            echo "localStorage.setItem('u-type', 'users');";
            echo "window.location.href = 'courses.php'";
            echo "</script>";
            $_SESSION["isloggedIn"] = true;
        return true;
    }
    return false; // Invalid username or password
}

// Function to reset password
function resetPassword($username, $newPassword, $mysqli) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE username = ?");
    $stmt->bind_param("ss", $hashedPassword, $username);
    $stmt->execute();
    $rowsAffected = $stmt->affected_rows;
    $stmt->close();
    return $rowsAffected > 0;
}

// Logout
function logout() {
    session_unset();
    session_destroy();
    // Redirect or display message if needed
}

// Function to display success message
function displaySuccessMessage($message) {
    echo "<script>alert('$message');</script>";
}

// Function to display failed message
function displayFailedMessage($message) {
    echo "<script>alert('$message');</script>";
}

// Function to redirect
function redirect($url) {
    echo "<script>window.location.href = '$url';</script>";
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signup'])) {
        $newUsername = sanitize($_POST['newUsername']);
        $newPassword = sanitize($_POST['newPassword']);
        if (signup($newUsername, $newPassword, $mysqli)) {
            displaySuccessMessage("Signup successful!");
            redirect("login.html");
        } else {
            displayFailedMessage("Signup failed, username already exists");
            redirect("login.html");
        }
    } elseif (isset($_POST['login'])) {
        $username = sanitize($_POST['username']);
        $password = sanitize($_POST['password']);
        if (login($username, $password, $mysqli)) {
            displaySuccessMessage("Login successful!");
            redirect("courses.php");
        } else {
            displayFailedMessage("Login failed, invalid username or password");
            redirect("login.html");
        }
    } elseif (isset($_POST['reset'])) {
        $username = sanitize($_POST['username']);
        $newPassword = sanitize($_POST['newPassword']);
        if (resetPassword($username, $newPassword, $mysqli)) {
            displaySuccessMessage("Password reset successful!");
            redirect("login.html");
        } else {
            displayFailedMessage("Reset failed! Invalid credentials");
            redirect("login.html");
        }
    }
}
?>