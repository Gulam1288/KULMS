<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Database connection details
    include_once('db_connect.php');

    // Check if username already exists
    $sql_check = "SELECT username FROM faculty WHERE username = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<p class='error-message'>Username already exists. Please choose a different username.</p>";
        echo "<script>setTimeout(function(){ window.location.href='reg.php'; }, 3000);</script>";
    } else {
        // Prepare SQL statement to insert user data
        $sql_insert = "INSERT INTO faculty (username, password) VALUES (?, ?)";

        // Prepare and bind parameters to prevent SQL injection
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ss", $username, $hashedPassword);

        // Execute the statement
        if ($stmt_insert->execute()) {
            echo "<p class='success'>Registration successful. <a href='index.html'>Login</a></p>";
            echo "<script>setTimeout(function(){ window.location.href='index.html'; }, 3000);</script>";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }

        // Close statement
        $stmt_insert->close();
    }

    // Close connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://tse3.mm.bing.net/th?id=OIP.neMoV_sF2wamLIaJFhzF-AAAAA&pid=Api&P=0&h=180" type="image/jpeg">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 800px;
        }

        h2 {
            margin-top: 0;
            text-align: center;
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-top: 10px;
            text-align: center;
        }

        .success {
            color: green;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Register">
        </form>
</body>
</html>