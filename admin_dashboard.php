<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: adminLogin.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', 'sK23102004!', 'attendease');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle teacher addition
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    $sql = "INSERT INTO teachers (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        $message = "Teacher added successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a202c;
            color: #fbbf24;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #2d3748;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            margin-bottom: 5px;
            display: block;
            color: #cbd5e0;
        }
        .form-group input {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #4a5568;
            border-radius: 5px;
            background-color: #1a202c;
            color: #fbbf24;
        }
        .form-group input:focus {
            outline: none;
            border-color: #fbbf24;
        }
        .button {
            padding: 10px;
            font-size: 1em;
            background-color: #fbbf24;
            color: #1a202c;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #d97706;
        }
        .message {
            text-align: center;
            margin-bottom: 15px;
            color: #38a169;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <?php if (isset($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form action="admin_dashboard.php" method="POST">
            <div class="form-group">
                <label for="name">Teacher Name</label>
                <input type="text" id="name" name="name" placeholder="Enter teacher's name" required>
            </div>
            <div class="form-group">
                <label for="email">Teacher Email</label>
                <input type="email" id="email" name="email" placeholder="Enter teacher's email" required>
            </div>
            <div class="form-group">
                <label for="password">Teacher Password</label>
                <input type="password" id="password" name="password" placeholder="Enter teacher's password" required>
            </div>
            <button type="submit" class="button">Add Teacher</button>
        </form>
    </div>
</body>
</html>
