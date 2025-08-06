<?php
include '../includes/config.php'; // Include the database connection

// Collect and sanitize form data
$customer_name = filter_input(INPUT_POST, 'customer_name', FILTER_SANITIZE_STRING);
$lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
$contact_number = filter_input(INPUT_POST, 'contact_number', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$connecttype = filter_input(INPUT_POST, 'connecttype', FILTER_SANITIZE_STRING);

// Validate that required fields are not empty
if (empty($customer_name) || empty($contact_number) || empty($address) || !$email) {
    die('Please fill in all required fields correctly');
}

// Validate phone number (allow numbers, spaces, dashes, plus)
if (!preg_match('/^[\d\s\-\+\(\)]+$/', $contact_number)) {
    die('Please enter a valid phone number');
}

// Insert data into the customer table using prepared statement
$sql = "INSERT INTO customer (Fname, Lname, Phno, Email, Address, Cnct_type) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssssss", $customer_name, $lname, $contact_number, $email, $address, $connecttype);
    
    if ($stmt->execute()) {
        echo "<div style='text-align:center; margin:50px; padding:20px; background:#d4edda; border:1px solid #c3e6cb; border-radius:5px;'>";
        echo "<h2>Success!</h2>";
        echo "<p>New customer record created successfully.</p>";
        echo "<a href='index.php' style='color:#28a745;'>Add Another Customer</a> | ";
        echo "<a href='view_customers.php' style='color:#28a745;'>View All Customers</a>";
        echo "</div>";
    } else {
        echo "<div style='text-align:center; margin:50px; padding:20px; background:#f8d7da; border:1px solid #f5c6cb; border-radius:5px;'>";
        echo "<h2>Error!</h2>";
        echo "<p>There was an error creating the customer record. Please try again.</p>";
        echo "<a href='index.php' style='color:#dc3545;'>Go Back</a>";
        echo "</div>";
    }
    
    $stmt->close();
} else {
    echo "Database error: Unable to prepare statement";
}

// Close the connection
$conn->close();
?>
