<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', 'sK23102004!', 'attendease');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to fetch password hash from database
    $sql = "SELECT id, name, password FROM students WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();

        // Check password
        if (password_verify($password, $hashed_password)) {
            // Successful login
            $_SESSION['student_logged_in'] = true;
            $_SESSION['student_name'] = $name;
            header("Location: student_dashboard.php");
            exit();
        } else {
            $error = "Incorrect email or password.";
        }
    } else {
        $error = "Incorrect email or password.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - AttendEase</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #1a202c;
            color: #fbbf24;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Login Container */
        .login-container {
            background-color: #2d3748;
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.8em;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            color: #cbd5e0;
            margin-bottom: 5px;
        }

        .form-group input {
            padding: 10px;
            border: 1px solid #4a5568;
            border-radius: 5px;
            background-color: #1a202c;
            color: #fbbf24;
        }

        .button {
            padding: 10px;
            font-size: 1em;
            color: #1a202c;
            background-color: #fbbf24;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #d97706;
        }

        .error-message {
            text-align: center;
            color: red;
            margin-bottom: 15px;
            font-size: 1em;
        }

        .signup {
            margin-top: 15px;
            text-align: center;
            color: #cbd5e0;
        }

        .signup a {
            color: #fbbf24;
            text-decoration: none;
        }

        .signup a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Student Login</h1>
        
        <!-- Show error if login fails -->
        <?php if (isset($error)) { ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>

        <!-- Login Form -->
        <form action="studentLogin.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="button">Login</button>
        </form>

        <div class="signup">
            <p>Don't have an account? <a href="StudentSignup.php">Sign Up</a></p>
        </div>
    </div>
</body>
</html>
