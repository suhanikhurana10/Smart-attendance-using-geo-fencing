<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$dbname = 'attendease';
$username = 'root';
$password = 'sK23102004!';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("Database Connection Failed: " . $conn->connect_error);
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get student ID and subject from the request
    $userId = $_GET['userId'];
    $subject = $_GET['subject'];

    // Validate the input fields
    if (empty($userId) || empty($subject)) {
        error_log("Invalid Input: UserID = $userId, Subject = $subject");
        echo json_encode(["success" => false, "message" => "Invalid input."]);
        exit();
    }

    // Fetch attendance status for the student for the given subject
    $sql = "SELECT check_in_time, check_out_time, status FROM attendance 
            WHERE user_id = ? AND subject = ? ORDER BY check_in_time DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $userId, $subject);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(["success" => false, "message" => "No attendance data found for this subject."]);
    } else {
        $row = $result->fetch_assoc();
        $check_in_time = $row['check_in_time'];
        $check_out_time = $row['check_out_time'];
        $status = $row['status'];

        // If there's no check-out time, the student is considered checked in
        if (is_null($check_out_time)) {
            $attendance_status = "Checked in at $check_in_time.";
        } else {
            $attendance_status = "Checked out at $check_out_time. Status: $status";
        }

        echo json_encode(["success" => true, "attendance_status" => $attendance_status]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

$conn->close();
?>



