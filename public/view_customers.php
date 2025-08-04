<?php
// Include the database connection
include '../includes/config.php';

// Fetch all customers from the customer table
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Customers</title>
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
            width: 80%;
            max-width: 1000px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow-x: auto;
        }
        
        h2 {
            text-align: center;
            color: #4CAF50; /* Green color for title */
        }
        
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        
        th {
            background-color: #4CAF50; /* Green background for table header */
            color: white; /* White text in the header */
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9; /* Alternating row color */
        }
        
        tr:hover {
            background-color: #e7f5e7; /* Hover effect with light green */
        }
        
        /* Styling for no data message */
        p {
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>All Customers</h2>
        
        <?php
        // Check if any customers were found
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>CID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Connection Type</th>
                    </tr>";
                    
            // Output data of each customer
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['Cid']}</td>
                        <td>{$row['Fname']}</td>
                        <td>{$row['Lname']}</td>
                        <td>{$row['Phno']}</td>
                        <td>{$row['Email']}</td>
                        <td>{$row['Address']}</td>
                        <td>{$row['Cnct_type']}</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No customers found.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
