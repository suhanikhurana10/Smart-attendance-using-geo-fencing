<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', 'sK23102004!', 'attendease');

// Check if connection is successful
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare statement to fetch teacher password
    $sql = "SELECT password FROM teachers WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Login successful
            $_SESSION['teacher_logged_in'] = true;
            $_SESSION['teacher_email'] = $email;
            header('Location: teacher_dashboard.php');
            exit();
        } else {
            // Invalid password
            $_SESSION['login_error'] = "Invalid credentials. Please try again.";
            header('Location: teacherLogin.php');
            exit();
        }
    } else {
        // No user found with that email
        $_SESSION['login_error'] = "Invalid credentials. Please try again.";
        header('Location: teacherLogin.php');
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: teacherLogin.php');
    exit();
}
?>

