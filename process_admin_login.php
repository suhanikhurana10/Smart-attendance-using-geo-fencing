<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', 'sK23102004!', 'attendease');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Predefined admin credentials
$admin_email = "admin@gmail.com";
$admin_password = "12345";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate credentials
    if ($email === $admin_email && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $admin_email;

        // Redirect to the admin dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Invalid credentials
        $_SESSION['login_error'] = "Invalid credentials. Please try again.";
        header("Location: adminLogin.php");
        exit();
    }
} else {
    // Redirect if accessed directly
    header("Location: adminLogin.php");
    exit();
}
?>
