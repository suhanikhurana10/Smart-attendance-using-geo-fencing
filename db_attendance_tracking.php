<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata'); // For IST

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("POST Request Received: " . file_get_contents('php://input'));
    $data = json_decode(file_get_contents('php://input'), true);
    error_log("Decoded JSON Data: " . json_encode($data));

    // Extract the received data
    $userId = $data['userId'];
    $subject = $data['subject'];
    $action = $data['action'];
    $latitude = $data['userLat'];
    $longitude = $data['userLon'];
    error_log("UserID received: " . $userId);

    // Validate the input fields
    if (empty($userId) || empty($subject) || empty($action)) {
        error_log("Invalid Input: UserID = $userId, Subject = $subject, Action = $action");
        echo json_encode(["success" => false, "message" => "Invalid input."]);
        exit();
    }

    // Validate if the userId exists in the database
    $sql = "SELECT * FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // If user is not found, return an error
    if ($result->num_rows === 0) {
        error_log("User not found with ID: " . $userId);
        echo json_encode(["success" => false, "message" => "User not found."]);
        exit();
    }

    // Proceed with the attendance logic
    $timestamp = date("Y-m-d H:i:s");

    if ($action === 'checkin') {
        $query = "INSERT INTO attendance (user_id, subject, check_in_time, latitude, longitude, status) 
                  VALUES (?, ?, ?, ?, ?, 'unmarked')";
    } elseif ($action === 'checkout') {
        // Get the check-in time to calculate the duration
        $query = "SELECT check_in_time FROM attendance WHERE user_id = ? AND subject = ? AND check_out_time IS NULL";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $userId, $subject);
        $stmt->execute();
        $stmt->bind_result($check_in_time);
        $stmt->fetch();

        // Free the result to avoid the "Commands out of sync" error
        $stmt->free_result(); // Important to free the result before running another query

        // Calculate the time difference between check-in and check-out
        $check_in = new DateTime($check_in_time);
        $check_out = new DateTime($timestamp);
        $interval = $check_in->diff($check_out);

        // Determine the status based on time difference (1 hour threshold)
        $status = ($interval->h >= 1) ? 'present' : 'absent';

        // Update the check-out time and status
        $query = "UPDATE attendance 
                  SET check_out_time = ?, status = ?, latitude = ?, longitude = ? 
                  WHERE user_id = ? AND subject = ? AND check_out_time IS NULL";
    } else {
        error_log("Invalid Action: " . $action);
        echo json_encode(["success" => false, "message" => "Invalid action."]);
        exit();
    }

    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    error_log("Preparing query for action: " . $action);

    if ($action === 'checkin') {
        $stmt->bind_param("sssss", $userId, $subject, $timestamp, $latitude, $longitude);
    } elseif ($action === 'checkout') {
        $stmt->bind_param("ssssss", $timestamp, $status, $latitude, $longitude, $userId, $subject);
    }

    if ($stmt->execute()) {
        $message = $action === 'checkin' ? "Check-in recorded successfully." : "Check-out recorded successfully.";
        error_log("SQL Success: " . $message);
        echo json_encode(["success" => true, "message" => $message]);
    } else {
        error_log("SQL Error: " . $stmt->error);
        echo json_encode(["success" => false, "message" => "Error saving attendance."]);
    }

    $stmt->close();
} else {
    error_log("Invalid Request Method: " . $_SERVER['REQUEST_METHOD']);
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

$conn->close();
error_log("Script execution completed.");
?>

