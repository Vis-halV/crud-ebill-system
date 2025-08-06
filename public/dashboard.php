<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['username'])) {
    header("Location: login.php");  
    exit();
}

// Get user information from session
$username = htmlspecialchars($_SESSION['username']);
$role = isset($_SESSION['role']) ? htmlspecialchars($_SESSION['role']) : 'user';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EBMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include('header.html'); ?>

<div class="container">
    <h1>Admin Dashboard</h1>
    
    <div style="background:#e6f3ff; padding:20px; border-radius:8px; margin:20px 0;">
        <h2>Welcome, <?php echo $username; ?>!</h2>
        <p>You are logged in as: <strong><?php echo ucfirst($role); ?></strong></p>
        <p>Login Time: <?php echo date('Y-m-d H:i:s'); ?></p>
    </div>
    
    <div class="dashboard-menu" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-top:30px;">
        <div class="menu-item" style="background:#f8f9fa; padding:20px; border-radius:8px; text-align:center;">
            <h3>Customer Management</h3>
            <p><a href="index.php" style="color:#4CAF50;">Add New Customer</a></p>
            <p><a href="view_customers.php" style="color:#4CAF50;">View All Customers</a></p>
        </div>
        
        <div class="menu-item" style="background:#f8f9fa; padding:20px; border-radius:8px; text-align:center;">
            <h3>Billing</h3>
            <p><a href="bill_calculate.php" style="color:#4CAF50;">Calculate Bills</a></p>
            <p><a href="bill_insertion.php" style="color:#4CAF50;">Manual Bill Entry</a></p>
            <p><a href="view_bills.php" style="color:#4CAF50;">View All Bills</a></p>
        </div>
        
        <div class="menu-item" style="background:#f8f9fa; padding:20px; border-radius:8px; text-align:center;">
            <h3>Reports</h3>
            <p><a href="bill_statement.php" style="color:#4CAF50;">Customer Bill Statements</a></p>
        </div>
    </div>
</div>

</body>
</html>
