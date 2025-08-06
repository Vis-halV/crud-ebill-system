<?php
// Include the database connection
include '../includes/config.php';

// Fetch customers from the database for the dropdown
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);

// Initialize variables for form submission status
$successMessage = "";
$errorMessage = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = filter_input(INPUT_POST, 'customer', FILTER_VALIDATE_INT);
    $bill_date = filter_input(INPUT_POST, 'bill_date', FILTER_SANITIZE_STRING);
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
    
    // Validate input
    if (!$customer_id || !$bill_date || !$amount) {
        $errorMessage = "Please fill in all fields correctly.";
    } else {
        // Insert the bill data into the database
        $sql = "INSERT INTO bill (Cid, Bill_date, Amnt) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("isd", $customer_id, $bill_date, $amount);
            
            if ($stmt->execute()) {
                $successMessage = "Bill successfully added!";
            } else {
                $errorMessage = "Error adding bill: " . $stmt->error;
            }
            
            $stmt->close();
        } else {
            $errorMessage = "Database error: Unable to prepare statement.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bill</title>
    <style>
        /* General styling for body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        /* Container box styling */
        .container {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        h2 {
            color: black;
            margin-bottom: 20px;
        }
        /* Form elements */
        label, select, input[type="date"], input[type="number"], input[type="submit"] {
            display: block;
            width: 100%;
            margin: 10px 0;
            font-size: 1em;
            color: black;
        }
        select, input[type="date"], input[type="number"], input[type="submit"] {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        /* Success and Error Message Styling */
        .message {
            margin-top: 20px;
            font-size: 1em;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Bill</h2>

        <!-- Form to insert a new bill -->
        <form action="bill_insertion.php" method="POST">
            <label for="customer">Select Customer:</label>
            <select name="customer" id="customer" required>
                <option value="">Select Customer</option>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['Cid'] . "'>" . $row['Fname'] . " " . $row['Lname'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No customers found</option>";
                }
                ?>
            </select>

            <label for="bill_date">Bill Date:</label>
            <input type="date" name="bill_date" id="bill_date" required>

            <label for="amount">Amount (₹):</label>
            <input type="number" name="amount" id="amount" step="0.01" required>

            <input type="submit" value="Add Bill">
        </form>

        <!-- Display success or error message -->
        <?php
        if (!empty($successMessage)) {
            echo "<p class='message success'>$successMessage</p>";
        }
        if (!empty($errorMessage)) {
            echo "<p class='message error'>$errorMessage</p>";
        }
        ?>
    </div>
</body>
</html>
