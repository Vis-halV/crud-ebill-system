<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('header.html'); ?>
    <div class="container">
        <h1>Customer Registration Form</h1>
        <form action="submit.php" method="POST">
            <label for="customer_name">First Name:</label>
            <input type="text" id="customer_name" name="customer_name" required>

            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" required>

            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label>Connection Type:</label>
            <input type="radio" id="public" name="connecttype" value="public" required>
            <label for="public">Public</label>
            <input type="radio" id="commercial" name="connecttype" value="commercial" required>
            <label for="commercial">Commercial</label>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
