<?php
// Connect to your database
include_once('db_connect.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $type = $_POST['type'];

    // Prepare SQL statement
    $sql = "INSERT INTO events (event_title, event_description, event_date, event_type) 
            VALUES ('$title', '$description', '$date', '$type')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='margin-top: 80px;' class='alert alert-success alert-dismissible fade show'>Event added successfully!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></p>";
        echo "<script>document.getElementById('h2').style.display='none';</script>";
        echo "<script>setTimeout(function(){ window.location.href='add_event.php'; }, 3000);</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
.body {
    background-color: #222; /* Dark background */
    color: #eee; /* Light text */
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

* {
box-sizing: border-box;
}

h2 {
    text-align: center;
    color: skyblue; /* Light text */
}

form {
    max-width: 400px;
    border: 2px solid skyblue;
    outline: 1.2px solid #007BFF;
    background-color: #333; /* Darker background for form */
    padding: 30px 20px;
    border-radius: 10px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 450;
}

input[type="text"],
input[type="date"],
select,
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 25px;
    border: none;
    border-radius: 5px;
    background-color: #444; /* Darker input background */
    color: #eee; /* Light text */
}

textarea {
    resize: none;
    overflow-y: auto;
    height: 100px; /* Set a fixed height for textarea */
}

input[type="submit"] {
    padding: 12px 0;
    background-color: #007bff;
    color: #fff;
    width: 100%;
    margin-top: 20px;
    font-weight: 550;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

.footer {
            background-color: #1A1A1A;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            margin-top: 50px;
            width: 100%;
        }

        .footer .box-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .footer .box {
            flex: 1;
            padding: 10px;
        }

        .footer .box h3 {
            margin-bottom: 10px;
        }

        .footer .box a {
            display: block;
            color: #fff;
            text-decoration: none;
            margin-bottom: 5px;
        }

        @media (max-width: 768px) {
            .footer .box {
                flex: none;
                width: 90%;
            }
        }

.description {
max-height: 100px;
overflow-y: auto;
}
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="body">
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img width="50" height="50" class="rounded-circle" src="https://tse3.mm.bing.net/th?id=OIP.neMoV_sF2wamLIaJFhzF-AAAAA&pid=Api&P=0&h=180" alt="Logo"></a></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item" id="login">
                        <a class="nav-link" href="login.html">Login</a>
                    </li>
                    <li class="nav-item" id="courses">
                        <a class="nav-link" href="#">Courses</a>
                    </li>
                    <li class="nav-item" id="uploadAble">
                        <a class="nav-link" href="upload_files.php">Upload</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact us</a>
                    </li>
                    <li class="nav-item" id="logoutLink">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <h2 id="h2" style="margin-top: 100px;">Add Event</h2>
    <form method="post" action="">
        <label for="title">Event Title:</label>
        <input type="text" id="title" name="title">
        
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
        
        <label for="date">Date:</label>
        <input type="date" id="date" name="date">
        
        <label for="type">Type:</label>
        <select id="type" name="type">
            <option value="exam">Exam</option>
            <option value="holiday">Holiday</option>
            <option value="lecture">Guest Lecture</option>
            <option value="event">Campus Event</option>
        </select>

        <center><input type="submit" value="Add Event"></center>
    </form> 
    <section class="footer">
        <div class="box-container">
            <div class="box">
                <h3>More links</h3>
                <a href="http://kucet.ac.in/college"><i class="fas fa-globe"></i> KU Official site</a>
                <a href="http://kucet.ac.in/syllabus/"><i class="fas fa-poll"></i> KU syllabus</a>
                <a href="https://technology.ku.edu/tech-support-students"><i class="fas fa-question-circle"></i> KU Help desk</a>
            </div>
            <div class="box">
                <h3>Locations</h3>
                <a href="#"><i class="fas fa-map-marker-alt"></i> Hanmakonda</a>
                <a href="#"><i class="fas fa-map-marker-alt"></i> Kottagudam</a>
                <a href="#"><i class="fas fa-map-marker-alt"></i> Telangana</a>
            </div>
            <div class="box w-100">
                <h3>Contact info</h3>
                <a href="#"><i class="fas fa-phone"></i> 9603636883 / 7989865918</a>
                <a href=""><i class="fas fa-envelope"></i> placement.kucet@gmail.com</a>
                <a style="font-size: 16px;" href="#"><i class="fas fa-map-marker-alt"></i> Hanmakonda-Telangana</a>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script> 
<script>
if (localStorage.getItem('u-type') !== 'admin') {
            document.getElementById("uploadAble").style.display = "none";
        }

        if (localStorage.getItem('isLoggedIn') === 'true') {
            document.getElementById("login").style.display = "none";
        } else {
            document.getElementById("logoutLink").style.display = "none";
        }
        function logout() {
            window.location.href = 'logout.php';
        }

        // Attach logout function to logout link
        document.getElementById("logoutLink").addEventListener("click", logout);
</script>
</body>
</html>