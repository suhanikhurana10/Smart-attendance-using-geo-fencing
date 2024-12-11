<?php
// welcome.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AttendEase</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #1a202c;
            color: #fbbf24;
        }
        .header {
            background-color: #2d3748;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5em;
        }
        .nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 10px;
        }
        .nav a {
            color: #fbbf24;
            text-decoration: none;
            font-size: 1em;
        }
        .container {
            text-align: center;
            padding: 60px 20px;
        }
        .container h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .container p {
            font-size: 1.2em;
            margin-bottom: 30px;
            color: #cbd5e0;
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .button {
            padding: 15px 30px;
            font-size: 1em;
            color: #1a202c;
            background-color: #fbbf24;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #d97706;
        }
        .about, .how-it-works {
            background-color: #2d3748;
            color: #cbd5e0;
            padding: 40px 20px;
            text-align: center;
        }
        .section-title {
            font-size: 2em;
            margin-bottom: 20px;
            color: #fbbf24;
        }
        .steps {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .step {
            background-color: #1a202c;
            padding: 20px;
            border-radius: 10px;
            color: #fbbf24;
            width: 200px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>AttendEase</h1>
        <div class="nav">
            <a href="#about">About</a>
            <a href="#how-it-works">How It Works</a>
            <a href="#team">Team</a>
            <a href="#contact">Contact</a>
        </div>
    </div>

    <div class="container">
        <h1>Welcome to AttendEase</h1>
        <p>Revolutionizing attendance with smart geofencing technology for colleges. Effortless, secure, and accurate.</p>
        <div class="button-container">
            <button class="button" onclick="location.href='studentLogin.php'">Student Login</button>
            <button class="button" onclick="location.href='teacherLogin.php'">Administrator Login</button>
        </div>
    </div>

    <div id="about" class="about">
        <h2 class="section-title">About AttendEase</h2>
        <p>AttendEase is your ultimate solution for hassle-free attendance management. Using geofencing technology, we ensure attendance is automatically recorded when students enter predefined zones, saving time and reducing errors.</p>
    </div>

    <div id="how-it-works" class="how-it-works">
        <h2 class="section-title">How AttendEase Works</h2>
        <div class="steps">
            <div class="step">
                <h3>1. Define the Geofence</h3>
                <p>Set the location boundaries for attendance tracking.</p>
            </div>
            <div class="step">
                <h3>2. Track Location</h3>
                <p>Monitor students' location in real time.</p>
            </div>
            <div class="step">
                <h3>3. Mark Attendance</h3>
                <p>Automatically mark students present or absent based on their location.</p>
            </div>
        </div>
    </div>
</body>
</html>
