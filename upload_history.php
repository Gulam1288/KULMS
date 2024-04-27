<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload History</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="https://tse3.mm.bing.net/th?id=OIP.neMoV_sF2wamLIaJFhzF-AAAAA&pid=Api&P=0&h=180" type="image/jpeg">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>

* {
box-sizing: border-box;
}
        .body {
            background-color: #111;
            color: #FFF;
            padding-top: 20px;
        }

        .container {
            max-width: 800px;
            max-height: 1000px;
            overflow: auto;
        }

        .table {
            background-color: #333;
            color: #FFF;
        }

        .table th,
        .table td {
            border-color: #555;
        }
        .navbar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .footer {
            background-color: #1A1A1A;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            margin-top: 100px;
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

        @media (min-width: 800px) {
            form {
                max-width: 600px;
            }
        }

.popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    color: #fff;
    backdrop-filter: blur(90px);
    background-color: rgba(0, 0, 0, 0.8); /* Semi-transparent background */
    z-index: 9999; /* Ensure it appears on top of other elements */
}

.popup-content {
    position: absolute;
    top: 50%;
    left: 50%;
    border: 2px solid skyblue;
    transform: translate(-50%, -50%);
    background-color: #867447;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    text-align: center;
    width: 80%;
}

.popup-content p {
    margin-bottom: 4px;
}

.uh {
margin-top: 80px;
}

i {
margin-right: 5px;
}
    </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="body">
    <div id="popup" class="popup">
        <div class="popup-content">
            <p>Access not allowed without login.</p>
            <p>Redirecting to homepage...</p>
        </div>
    </div>

    <script>
        var userType = localStorage.getItem('u-type');

        // If userType is neither "admin" nor "users", display the popup box and redirect after a delay
        if (userType !== "admin") {
            var popup = document.getElementById('popup');
            popup.style.display = 'block';

            // Redirect after a delay
            setTimeout(function() {
                window.location.href = "index.html";
            }, 3500); // Redirect after 5 seconds (5000 milliseconds)
        }
    </script>
<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="https://tse3.mm.bing.net/th?id=OIP.neMoV_sF2wamLIaJFhzF-AAAAA&pid=Api&P=0&h=180" alt="Logo"></a></a>
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
    <li class="nav-item">
        <a class="nav-link" href="courses.php">Courses</a>
    </li>
    <li class="nav-item" id="uploadAble">
        <a class="nav-link" href="upload_files.php">Upload</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="about.html">About</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="contact_us.html">Contact us</a>
    </li>
    <li class="nav-item" id="logoutLink">
        <a class="nav-link" href="#">Logout</a>
    </li>
</ul>
    </div>
  </div>
</nav>
<center><h1 class="mb-4 uh">Upload History</h1></center>
    <div class="container">
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Uploader</th>
                    <th>Year</th>
                    <th>Department</th>
                    <th>Course</th>
                    <th>Filename</th>
                    <th>Upload Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection settings
                include_once('db_connect.php');

                // Fetch upload history from database
                $sql = "SELECT * FROM uploads ORDER BY upload_timestamp DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $count = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$count}</td>";
                        echo "<td>{$row['uploader_name']}</td>";
                        echo "<td>{$row['year']}</td>";
                        echo "<td>{$row['department']}</td>";
                        echo "<td>{$row['course']}</td>";
                        echo "<td>{$row['filename']}</td>";
                        echo "<td>{$row['upload_timestamp']}</td>";
                        echo "</tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='7'>No uploads found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<section class="footer">
    <div class="box-container">
        <div class="box">
            <h3>More links</h3>
            <a href="#"><i class="fas fa-globe"></i>KU Official site</a>
            <a href="#"><i class="fas fa-poll"></i>KU results</a>
            <a href="#"><i class="fas fa-question-circle"></i>KU Help desk</a>
        </div>
        <div class="box">
            <h3>Locations</h3>
            <a href="#"><i class="fas fa-map-marker-alt"></i> Hanmakonda</a>
            <a href="#"><i class="fas fa-map-marker-alt"></i> Kottagudam</a>
            <a href="#"><i class="fas fa-map-marker-alt"></i> Telangana</a>
        </div>
        <div class="box w-100">
            <h3>Contact info</h3>
            <a href="#"><i class="fas fa-phone"></i> +91-xxxxxxxxxx</a>
            <a href="#"><i class="fas fa-envelope"></i> abc@gmail.com</a>
            <a style="font-size: 16px;" href="#"><i class="fas fa-map-marker-alt"></i>Hanmakonda-Telangana</a>
        </div>
    </div>
</section>
    <!-- Bootstrap JS (optional if you need JS features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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