<?php
// Include the database connection
include '../includes/config.php';

// Fetch customers from the database to populate the dropdown menu
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Calculation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include('header.html'); ?>

<div class="container">
    <h2>Bill Calculation</h2>

    <!-- Form for bill calculation -->
    <form action="bill_calculate.php" method="POST">
        <label for="customer">Select Customer:</label>
        <select name="customer" id="customer" required>
            <option value="">Select Customer</option>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['Cid'] . "'>" . $row['Fname'] . " " . $row['Lname'] . "</option>";
                }
            }
            ?>
        </select>
        <br><br>

        <label for="meter_reading">Enter Meter Reading:</label>
        <input type="number" id="meter_reading" name="meter_reading" required>
        <br><br>

        <input type="submit" value="Calculate Bill">
    </form>

    <?php
    // Process the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $customer_id = filter_input(INPUT_POST, 'customer', FILTER_VALIDATE_INT);
        $meter_reading = filter_input(INPUT_POST, 'meter_reading', FILTER_VALIDATE_FLOAT);

        if (!$customer_id || !$meter_reading) {
            echo "<p style='color:red;'>Invalid input data. Please try again.</p>";
        } else {
            // Fetch the last meter reading for the selected customer using prepared statement
            $sql = "SELECT * FROM meter WHERE Cid = ? ORDER BY Meter_id DESC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $customer_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $previous_reading = $row['Reading'];
                $rate_per_unit = 10; // Example rate per unit, you can adjust this

                // Calculate the bill
                $units_consumed = $meter_reading - $previous_reading;
                $bill_amount = $units_consumed * $rate_per_unit;

                // Insert the bill into the 'bill' table using prepared statement
                $insert_sql = "INSERT INTO bill (Cid, Mid, Readings, Bill_date, Amnt) VALUES (?, ?, ?, CURDATE(), ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("isdd", $customer_id, $row['Mid'], $meter_reading, $bill_amount);

                if ($insert_stmt->execute()) {
                    echo "<div style='background:#d4edda; padding:15px; margin:10px 0; border-radius:5px;'>";
                    echo "<h3>Bill Successfully Calculated!</h3>";
                    echo "<p>Previous Reading: " . number_format($previous_reading, 2) . " units</p>";
                    echo "<p>Current Reading: " . number_format($meter_reading, 2) . " units</p>";
                    echo "<p>Units Consumed: " . number_format($units_consumed, 2) . " units</p>";
                    echo "<p>Rate per Unit: ₹" . $rate_per_unit . "</p>";
                    echo "<p><strong>Total Amount: ₹" . number_format($bill_amount, 2) . "</strong></p>";
                    echo "</div>";
                    
                    // Update meter reading
                    $update_sql = "UPDATE meter SET Reading = ? WHERE Cid = ? AND Mid = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param("dis", $meter_reading, $customer_id, $row['Mid']);
                    $update_stmt->execute();
                    $update_stmt->close();
                } else {
                    echo "<p style='color:red;'>Error saving bill. Please try again.</p>";
                }
                
                $insert_stmt->close();
            } else {
                echo "<p style='color:orange;'>No previous meter reading found for this customer. Please add a meter reading first.</p>";
            }
            
            $stmt->close();
        }
    }

    // Close the database connection
    $conn->close();
    ?>
</div>
</body>
</html>
