<?php
$servername = "db"; // Docker service name for MySQL
$username = "user";
$password = "userpass";
$dbname = "ebill_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>