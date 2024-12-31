<?php
// student_signup.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Signup - AttendEase</title>
    <style>
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
        .signup-container {
            background-color: #2d3748;
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .signup-container h1 {
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.8em;
        }
        .signup-container form {
            display: flex;
            flex-direction: column;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #cbd5e0;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #4a5568;
            border-radius: 5px;
            background-color: #1a202c;
            color: #fbbf24;
            font-size: 1em;
        }
        .form-group input:focus {
            outline: none;
            border-color: #fbbf24;
            box-shadow: 0 0 5px #fbbf24;
        }
        .button {
            padding: 10px;
            font-size: 1em;
            color: #1a202c;
            background-color: #fbbf24;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        .button:hover {
            background-color: #d97706;
            box-shadow: 0 0 10px #d97706;
        }
        .login {
            margin-top: 15px;
            text-align: center;
            color: #cbd5e0;
        }
        .login a {
            color: #fbbf24;
            text-decoration: none;
        }
        .login a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h1>Student Signup</h1>
        <form action="process_signup.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
            </div>
            <button type="submit" class="button">Sign Up</button>
        </form>
        <div class="login">
            <p>Already have an account? <a href="student_login.php">Login</a></p>
        </div>
    </div>

    <script>
        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
