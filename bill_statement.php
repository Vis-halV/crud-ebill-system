<?php
// Include the database connection
include('config.php');

// Fetch customers from the database for the dropdown
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Statement</title>
    <style>
        /* General styling for body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;  /* Ensure all text is visible */
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
        }
        h2 {
            text-align: center;
            color: black; /* Ensure heading text is visible */
        }
        /* Form elements */
        label, select, input[type="submit"] {
            display: block;
            width: 100%;
            margin: 10px 0;
            font-size: 1em;
            color: black; /* Text color for dropdown and button */
        }
        select {
            color: #333; /* Text color for dropdown options */
            background-color: #f9f9f9;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        option {
            color: #333; /* Ensures options are visible */
        }

        select, input[type="submit"] {
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
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #black;  /* Ensure all table text is visible */
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bill Statement</h2>

        <!-- Form to select a customer and view their bill statement -->
        <form action="bill_statement.php" method="POST">
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
            <br><br>

            <input type="submit" value="View Bill Statement">
        </form>

        <?php
        // Process form submission and fetch bill details for the selected customer
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $customer_id = $_POST['customer'];

            // Prepare SQL query
            $sql = "SELECT Bill_id, Bill_date, Amount FROM bill WHERE Cid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $customer_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if any records were returned
            if ($result->num_rows > 0) {
                echo "<h3>Bill Statement for Customer ID: $customer_id</h3>";
                echo "<table>
                        <tr>
                            <th>Bill ID</th>
                            <th>Bill Date</th>
                            <th>Amount (₹)</th>
                        </tr>";

                // Output each bill record
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['Bill_id'] . "</td>
                            <td>" . $row['Bill_date'] . "</td>
                            <td>" . $row['Amount'] . "</td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No bills found for this customer.</p>";
            }

            $stmt->close();
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
