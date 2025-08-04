<?php

$servername = "localhost";  // or your server IP
$username = "root";         // MySQL username
$password = "Vish@l06076";             // MySQL password (empty for default)
$dbname = "ebms";           // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
?>