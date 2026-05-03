<?php
session_start();

// Database connection using Environment Variables with local XAMPP fallbacks
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
$db   = getenv('DB_NAME') ?: 'finaldb';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$date = $_GET['date'] ?? null;

if ($date) {
    $stmt = $conn->prepare("
        SELECT start_time, end_time 
        FROM appointment 
        WHERE appointment_day = ?"
    );
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $stmt->bind_result($start_time, $end_time);

    $booked_slots = [];
    while ($stmt->fetch()) {
        $booked_slots[] = [
            'start_time' => $start_time,
            'end_time' => $end_time,
        ];
    }
    $stmt->close();

    // Return booked slots as JSON
    header('Content-Type: application/json'); // Good practice to explicitly declare JSON
    echo json_encode($booked_slots);
}

$conn->close();
?>