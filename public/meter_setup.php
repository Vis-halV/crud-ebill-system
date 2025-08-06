<?php
// Include the database connection
include '../includes/config.php';

// Initialize variables for form submission status
$successMessage = "";
$errorMessage = "";

// Fetch customers from the database for the dropdown
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = filter_input(INPUT_POST, 'customer', FILTER_VALIDATE_INT);
    $meter_id = filter_input(INPUT_POST, 'meter_id', FILTER_SANITIZE_STRING);
    $initial_reading = filter_input(INPUT_POST, 'initial_reading', FILTER_VALIDATE_FLOAT);
    
    // Validate input
    if (!$customer_id || !$meter_id || $initial_reading === false) {
        $errorMessage = "Please fill in all fields correctly.";
    } else {
        // Check if customer already has a meter
        $check_sql = "SELECT * FROM meter WHERE Cid = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $customer_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $errorMessage = "This customer already has a meter assigned.";
        } else {
            // Insert meter data
            $sql = "INSERT INTO meter (Mid, Cid, Reading) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("sid", $meter_id, $customer_id, $initial_reading);
                
                if ($stmt->execute()) {
                    $successMessage = "Meter successfully added for the customer!";
                } else {
                    $errorMessage = "Error adding meter: " . $stmt->error;
                }
                
                $stmt->close();
            } else {
                $errorMessage = "Database error: Unable to prepare statement.";
            }
        }
        
        $check_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meter Setup - EBMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include('header.html'); ?>

<div class="container">
    <h2>Meter Setup</h2>
    <p>Add initial meter readings for customers to enable bill calculation.</p>

    <!-- Form to set up meter for customer -->
    <form action="meter_setup.php" method="POST">
        <label for="customer">Select Customer:</label>
        <select name="customer" id="customer" required>
            <option value="">Select Customer</option>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['Cid'] . "'>" . $row['Fname'] . " " . $row['Lname'] . " (ID: " . $row['Cid'] . ")</option>";
                }
            } else {
                echo "<option value=''>No customers found</option>";
            }
            ?>
        </select>

        <label for="meter_id">Meter ID:</label>
        <input type="text" name="meter_id" id="meter_id" placeholder="e.g., MTR001" required>

        <label for="initial_reading">Initial Reading (Units):</label>
        <input type="number" name="initial_reading" id="initial_reading" step="0.01" placeholder="e.g., 1000.50" required>

        <button type="submit">Add Meter</button>
    </form>

    <!-- Display success or error message -->
    <?php
    if (!empty($successMessage)) {
        echo "<div class='success'>$successMessage</div>";
    }
    if (!empty($errorMessage)) {
        echo "<div class='error'>$errorMessage</div>";
    }
    ?>
    
    <!-- Show existing meters -->
    <h3>Existing Meters</h3>
    <?php
    $meter_sql = "SELECT m.Mid, m.Reading, c.Fname, c.Lname, c.Cid 
                  FROM meter m 
                  JOIN customer c ON m.Cid = c.Cid 
                  ORDER BY c.Fname";
    $meter_result = $conn->query($meter_sql);
    
    if ($meter_result->num_rows > 0) {
        echo "<table style='width:100%; border-collapse:collapse; margin-top:20px;'>";
        echo "<tr style='background:#f2f2f2;'>
                <th style='border:1px solid #ddd; padding:8px;'>Customer</th>
                <th style='border:1px solid #ddd; padding:8px;'>Meter ID</th>
                <th style='border:1px solid #ddd; padding:8px;'>Current Reading</th>
              </tr>";
        
        while($row = $meter_result->fetch_assoc()) {
            echo "<tr>
                    <td style='border:1px solid #ddd; padding:8px;'>" . $row['Fname'] . " " . $row['Lname'] . " (ID: " . $row['Cid'] . ")</td>
                    <td style='border:1px solid #ddd; padding:8px;'>" . $row['Mid'] . "</td>
                    <td style='border:1px solid #ddd; padding:8px;'>" . number_format($row['Reading'], 2) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No meters found. Add meters for customers to enable billing.</p>";
    }
    
    $conn->close();
    ?>
</div>

</body>
</html>
