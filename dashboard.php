<?php
session_start();

include('header.html');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");  
    exit();
}

// Check if the user has the required role
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    echo "Role is not set.";
}


echo "Welcome, " . $_SESSION['username'] . "!<br>";
echo "You are logged in as an Administrator.";
?>
