<?php
session_start();

// Ensure student is logged in
if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header('Location: studentLogin.php');
    exit();
}

// Get the student's name from session
$student_name = $_SESSION['student_name'];

// Database connection (Modify with your own connection details)
$servername = "localhost";
$username = "root";
$password = "sK23102004!";
$dbname = "attendease"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch subjects from database (Optional if you still want dynamic subjects from DB)
// Commenting out as you requested a fixed list
/*
$subjects = [];
$sql = "SELECT DISTINCT subject FROM attendance"; // Using attendance table and getting distinct subjects
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch subjects into an array
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row['subject'];
    }
}
*/

$conn->close();

// Fixed list of subjects
$subjects = ['MATH', 'OS', 'LDCO', 'PHY', 'DSA'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - AttendEase</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #1a202c;
            color: #fbbf24;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        header {
            background-color: #2d3748;
            width: 100%;
            text-align: center;
            padding: 10px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.7);
            color: #fbbf24;
            font-size: 1.8em;
        }

        .dashboard-container {
            margin: 30px 20px;
            background-color: #2d3748;
            border-radius: 8px;
            padding: 20px 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 2em;
            color: #fbbf24;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 30px;
            color: #cbd5e0;
        }

        .buttons-container {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .button {
            padding: 12px 20px;
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

        select {
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #4a5568;
            background-color: #1a202c;
            color: #fbbf24;
            transition: border-color 0.3s ease;
        }

        select:focus {
            border-color: #fbbf24;
            box-shadow: 0 0 5px #fbbf24;
            outline: none;
        }

        .content-section {
            background-color: #2d3748;
            color: #fbbf24;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        AttendEase - Student Dashboard
    </header>

    <div class="dashboard-container">
        <h1>Hi, <?php echo htmlspecialchars($student_name); ?>! 👋</h1>
        <p>Click on check-in button to mark your attendance and click Check-out button after the class is over!</p>

        <div class="buttons-container">
            <button class="button" onclick="checkLocation('checkin')">Check-In</button>
            <button class="button" onclick="checkLocation('checkout')">Check-Out</button>
            <select id="subject-dropdown">
                <option value="">Select a subject</option>
                <?php
                foreach ($subjects as $subject) {
                    echo "<option value=\"$subject\">$subject</option>";
                }
                ?>
            </select>
        </div>

        <div class="content-section">
            <p id="status">Click "Check-In" or "Check-Out" to log your attendance.</p>
        </div>
    </div>

    <script>
        const roomLat = 12.971598;
        const roomLong = 77.594566;
        const thresholdRadius = 1500000;

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3;
            const toRadians = (degree) => degree * (Math.PI / 180);
            const deltaLat = toRadians(lat2 - lat1);
            const deltaLon = toRadians(lon2 - lon1);
            const a = Math.sin(deltaLat / 2) * Math.sin(deltaLat / 2) +
                      Math.cos(toRadians(lat1)) * Math.cos(toRadians(lat2)) *
                      Math.sin(deltaLon / 2) * Math.sin(deltaLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function checkLocation(action) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const userLat = position.coords.latitude;
                    const userLon = position.coords.longitude;
                    const distance = calculateDistance(userLat, userLon, roomLat, roomLong);
                    const subject = document.getElementById('subject-dropdown').value;

                    if (!subject) {
                        alert("Please select a subject.");
                        return;
                    }

                    if (distance <= thresholdRadius) {
                        const statusMessage = action === 'checkin' ? 
                            "You have checked in." : "You have checked out.";
                        document.getElementById('status').innerText = `${statusMessage} (${distance.toFixed(2)} meters)`;

                        fetch('db_attendance_tracking.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                action,
                                userLat,
                                userLon,
                                subject,
                                userId: <?php echo json_encode($_SESSION['student_id']); ?>
                            })
                        }).then(response => response.json())
                          .then(data => alert(data.message))
                          .catch(error => console.error("Error:", error));
                    } else {
                        document.getElementById('status').innerText = `You are out of range (${distance.toFixed(2)} meters).`;
                    }
                }, error => {
                    document.getElementById('status').innerText = "Error accessing location.";
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
    </script>
</body>
</html>
