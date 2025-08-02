<?php
// Include the database connection
include('config.php');

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
</head>
<body>
    <h2>Bill Calculation</h2>

    <!-- Form for bill calculation -->
    <form action="bill_calculate.php" method="POST">
        <label for="customer">Select Customer:</label>
        <select name="customer" id="customer" required>
            <option value="">Select Customer</option>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['Cid'] . "'>" . $row['customer_name'] . "</option>";
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
        $customer_id = $_POST['customer'];
        $meter_reading = $_POST['meter_reading'];

        // Fetch the last meter reading for the selected customer
        $sql = "SELECT * FROM meter WHERE Cid = '$customer_id' ORDER BY Meter_id DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $previous_reading = $row['Reading'];
            $rate_per_unit = 10; // Example rate per unit, you can adjust this

            // Calculate the bill
            $units_consumed = $meter_reading - $previous_reading;
            $bill_amount = $units_consumed * $rate_per_unit;

            // Insert the bill into the 'bill' table
            $sql = "INSERT INTO bill (Cid, Mid, Readings, Bill_date, Amnt) 
                    VALUES ('$customer_id', '{$row['Mid']}', '$meter_reading', CURDATE(), '$bill_amount')";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Bill successfully calculated and saved!</p>";
                echo "<p>Total Amount: ₹$bill_amount</p>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<p>No previous meter reading found for this customer.</p>";
        }
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
