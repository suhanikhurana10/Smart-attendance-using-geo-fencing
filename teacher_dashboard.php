<?php
session_start();
if (!isset($_SESSION['teacher_logged_in'])) {
    header('Location: teacherLogin.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard - AttendEase</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Page Background */
        body {
            font-family: Arial, sans-serif;
            background-color: #1a202c;
            color: #fbbf24;
            line-height: 1.6;
        }

        /* Header Section */
        header {
            background-color: #2d3748;
            color: #fbbf24;
            padding: 10px 0;
            text-align: center;
            border-bottom: 2px solid #fbbf24;
        }

        /* Main Navigation Menu */
        nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 10px 0;
            background-color: #4a5568;
        }

        nav a {
            color: #fbbf24;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #d97706;
        }

        /* Dashboard Container */
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 20px auto;
            background: #2d3748;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.5);
            color: #cbd5e0;
        }

        /* Section Styling */
        .section {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #4a5568;
            border-radius: 8px;
            background-color: #1a202c;
        }

        .section-title {
            font-size: 1.5em;
            color: #fbbf24;
            margin-bottom: 10px;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px 0;
            color: #1a202c;
            background-color: #fbbf24;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #d97706;
        }

        /* Tables */
        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
            color: #cbd5e0;
        }

        table th,
        table td {
            padding: 8px;
            text-align: center;
            border: 1px solid #4a5568;
        }

        table th {
            background-color: #2d3748;
        }

        /* Logout Button */
        footer {
            margin-top: 20px;
            text-align: center;
            color: #cbd5e0;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>Welcome to the AttendEase Teacher Dashboard</h1>
    </header>

    <!-- Main Navigation -->
    <nav>
        <a href="teacher_dashboard.php">Dashboard</a>
        <a href="manage_geofence.php">Manage Geofences</a>
        <a href="view_attendance.php">View Attendance</a>
        <a href="logout.php">Logout</a>
    </nav>

    <!-- Dashboard Content -->
    <div class="container">
        <!-- Dashboard Home Section -->
        <div class="section">
            <h2 class="section-title">Dashboard Home</h2>
            <p>Welcome, <strong><?php echo $_SESSION['teacher_name']; ?></strong>. Use the options above to manage attendance, geofence areas, or view attendance logs.</p>
            <a href="manage_geofence.php" class="btn">Manage Geofences</a>
            <a href="view_attendance.php" class="btn">View Attendance Logs</a>
        </div>

        <!-- Geofence Management Section -->
        <div class="section">
            <h2 class="section-title">Quick Links</h2>
            <p>
                From here, you can manage geofences for attendance tracking or check attendance logs easily. Geofences will define locations monitored for attendance.
            </p>
            <a href="manage_geofence.php" class="btn">Set Geofence</a>
            <a href="view_attendance.php" class="btn">View Logs</a>
        </div>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2023 AttendEase | All rights reserved.</p>
    </footer>
</body>
</html>