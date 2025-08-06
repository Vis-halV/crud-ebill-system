<?php
session_start();
include '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    // Check the credentials from the database using prepared statement
    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // For now, we'll use plain text comparison (will be fixed with password hashing later)
        if ($password === $user['password']) {
            // Login successful - set session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = true;
            
            $stmt->close();
            $conn->close();
            header("Location: dashboard.php");
            exit;
        } else {
            $error_message = "Invalid username or password";
        }
    } else {
        // Invalid credentials
        $error_message = "Invalid username or password";
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include('header.html'); ?>

<div class="container">
    <h1>Admin Login</h1>

    <?php
    if (isset($error_message)) {
        echo "<div class='error'>$error_message</div>";
    }
    ?>

    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
