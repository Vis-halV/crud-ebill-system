<?php
include '../includes/config.php'; // Include the database connection
// Collect form data
$customer_name = isset($_POST['customer_name']) ? $_POST['customer_name'] : '';
$contact_number = isset($_POST['contact_number']) ? $_POST['contact_number'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

// Validate that required fields are not empty
if ($customer_name == '' || $contact_number == '' || $address == '' || $email == '') {
    die('Please fill in all fields');
}

// Validate phone number is a valid integer
if (!is_numeric($contact_number)) {
    die('Please enter a valid phone number');
}

// Insert data into the customer table
$sql = "INSERT INTO customer (Fname, Lname, Phno, Email, Address, Cnct_type) 
        VALUES ('$customer_name', '', '$contact_number', '$email', '$address', '')"; // Assuming no Lname and Cnct_type are given

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>
