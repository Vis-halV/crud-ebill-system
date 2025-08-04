<!-- index.php -->
<?php
include('header.html');
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php"); // Redirect to login if not authenticated
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration - EBMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include('header.html'); ?> <!-- Include header content -->

<div class="container">
    <h1>Customer Registration Form</h1>
    <form action="submit.php" method="POST">
        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name" placeholder="Enter full name" required>

        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" placeholder="Enter last name" required>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" placeholder="Enter phone number" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" placeholder="Enter address" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter email" required>

        <label for="connecttype">Connection Type:</label><br>
        <label class="radio-container">
            <input type="radio" id="connecttype" name="connecttype" value="public">
            Public
        </label>
        <label class="radio-container">
            <input type="radio" id="connecttype" name="connecttype" value="commercial">
            Commercial
        </label>
        
        <button type="submit">Submit</button>
    </form>
</div>
</body>
</html>
