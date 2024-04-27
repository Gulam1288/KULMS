<?php
// Database configuration
$conn = new mysqli("sql307.infinityfree.com", "if0_36040027", "WOeS5G5X9Esua", "if0_36040027_logindata");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>