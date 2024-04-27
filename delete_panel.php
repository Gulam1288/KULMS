<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
 // Redirect to login page or display access denied message
 header("Location: index.html");
 exit();
 }

 // Database connection
 $conn = new mysqli("sql307.infinityfree.com", "if0_36040027", "WOeS5G5X9Esua", "if0_36040027_logindata");

 // Retrieve username from session variable
 $username = $_SESSION['username'];

 // Check if the user is a superadmin
 $sql = "SELECT role FROM faculty WHERE username = '$username'";
 $result = $conn->query($sql);
 if ($result->num_rows > 0) {
 $row = $result->fetch_assoc();
 $role = $row['role'];
 $isSuperAdmin = ($role == 'superadmin');
 } else {
 // Handle error if user not found in faculty table
 // For example, redirect to login page or display access denied message
 header("Location: delete_panel.php");
 exit();
 }

 // Fetch list of faculty members or users based on selection
 $userType = isset($_GET['type']) ? $_GET['type'] : 'faculty';
 if ($userType === 'faculty') {
 $sql = "SELECT * FROM faculty where role = 'admin'";
 } elseif ($userType === 'users') {
 $sql = "SELECT * FROM users";
 }
 $result = $conn->query($sql);
 $userList = array();
 if ($result->num_rows > 0) {
 while($row = $result->fetch_assoc()) {
 $userList[] = $row;
 }
 }

 // Delete a user
 if ($isSuperAdmin && isset($_POST['delete_id'])) {
 $id = $_POST['delete_id'];
 if ($userType === 'faculty') {
 $sql = "DELETE FROM faculty WHERE id = $id";
 } elseif ($userType === 'users') {
 $sql = "DELETE FROM users WHERE id = $id";
 }
 if ($conn->query($sql) === TRUE) {
 echo '<script>alert("User deleted successfully");</script>';
 // Refresh the page after deletion
 echo '<script>window.location.href = "delete_panel.php?type=' . $userType . '";</script>';
 } else {
 echo '<script>alert("Failed to delete user");</script>';
 }
 }
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 <meta charset="UTF-8">
 <link rel="icon" href="https://tse3.mm.bing.net/th?id=OIP.neMoV_sF2wamLIaJFhzF-AAAAA&pid=Api&P=0&h=180" type="image/jpeg">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>SuperAdmin Panel</title>
 <style>
 .body {
 font-family: Arial, sans-serif;
 background: #1A1A1A; /* Change background color to dark */
 color: #fff; /* Change text color to white */
 margin: 0;
 padding: 0;
 }

 .navbar img {
 width: 50px;
 height: 50px;
 border-radius: 50%;
 object-fit: cover;
 }
 .wrap {
 max-width: 800px;
 margin: 100px auto 20px;
 background-color: #222; /* Dark background color */
 padding: 20px;
 box-shadow: 0 0 10px rgba(255, 255, 255, 0.1); /* Adjust shadow color */
 }
 .wrap h2 {
 color: #fff;
 margin-top: 10px;
 padding-bottom: 10px;
 border-bottom: 1px solid #aaa; /* Adjust border color */
 }
 .wrap ul {
 list-style-type: none;
 padding: 0;
 }
 .wrap li {
 margin-bottom: 10px;
 padding: 10px;
 border-radius: 5px;
 color: #FFF;
 background-color: #444; /* Darker background color */
 border: 1px solid #666; /* Adjust border color */
 display: flex;
 align-items: center;
 justify-content: space-between;
 }
 .delete {
 background-color: #dc3545;
 color: white;
 border: none;
 padding: 5px 10px;
 border-radius: 5px;
 cursor: pointer;
 transition: background-color 0.3s ease;
 }
 .delete:hover {
 background-color: #c82333;
 }
 .user-type-selector {
 color: #FFF;
 margin-top: 25px;
 margin-bottom: 20px;
 }
 </style>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 </head>
 <body class="body">
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
 <div class="wrap">
 <h2>SuperAdmin Panel</h2>
 <div class="user-type-selector">
 <label for="user-type">Select User Type:</label>
 <select class="form-select" id="user-type" onchange="changeUserType(this)">
 <option value="faculty" <?php if ($userType === 'faculty') echo 'selected'; ?>>Faculty</option>
 <option value="users" <?php if ($userType === 'users') echo 'selected'; ?>>Users</option>
 </select>
 </div>
 <?php if ($isSuperAdmin): ?>
 <h2><?php echo ucfirst($userType); ?> List</h2>
 <?php if (empty($userList)): ?>
 <p>Currently empty.</p>
 <?php else: ?>
 <ul>
 <?php foreach ($userList as $user): ?>
 <li>
 <span><?php echo $user['username']; ?></span>
 <form method="post" style="display: inline;">
 <input type="hidden" name="delete_id" value="<?php echo $user['id']; ?>">
 <button class="delete" type="submit">Delete</button>
 </form>
 </li>
 <?php endforeach; ?>
 </ul>
 <?php endif; ?>
 <?php else: ?>
 <p>You do not have permission to access this page.</p>
 <?php endif; ?>
 </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 <script>
 function changeUserType(select) {
 var userType = select.value;
 window.location.href = 'delete_panel.php?type=' + userType;
 }
 if (localStorage.getItem('u-type') === 'users') {
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

 function faculty() {
 window.location.href = 'lecturers.html';
 }

 function courses() {
 var userType = localStorage.getItem('u-type');

 // If userType is neither "admin" nor "users", show the alert and redirect
 if (userType !== "admin" && userType !== "users") {
 if (confirm("Access not allowed without login. Press OK to redirect to login page.")) {
 window.location.href = "login.html";
 }
 } else {
 window.location.href = "courses.php"; // Redirect to courses page for logged-in users
 }

 }

 // Attach logout function to logout link
 document.getElementById("logoutLink").addEventListener("click", logout);
 document.getElementById("courses").addEventListener("click", courses);

 </script>
 </body>
 </html>