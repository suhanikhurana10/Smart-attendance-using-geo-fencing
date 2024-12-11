<?php
// student_login.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - AttendEase</title>
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
        .login-container {
            background-color: #2d3748;
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .login-container h1 {
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.8em;
        }
        .login-container form {
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
        <form action="process_login.php" method="POST">
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
