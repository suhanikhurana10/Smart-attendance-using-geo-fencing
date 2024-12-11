<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'attendease'); //add password

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT password FROM students WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hashed_password);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        echo "Login successful.";
    } else {
        echo "Incorrect email or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
