<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Bills</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Customer Bill Details</h1>

    <?php
    $conn = new mysqli('localhost', 'root', 'Vish@l06076', 'ebms');

    include('header.html');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT c.Fname, c.Lname, SUM(b.Amount) AS Total_Bill
            FROM customer c
            JOIN bill b ON c.Cid = b.Cid
            GROUP BY c.Cid";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>First Name</th><th>Last Name</th><th>Total Bill</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["Fname"] . "</td><td>" . $row["Lname"] . "</td><td>" . $row["Total_Bill"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No bills found</p>";
    }

    $conn->close();
    ?>

</body>
</html>
