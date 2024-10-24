<?php
// Database connection parameters
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "final_project"; 

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = 1;
// Retrieve the student ID from the session or URL (in this case, assuming session)
// session_start();
// if (isset($_SESSION['student_id'])) {
//     $studentId = $_SESSION['student_id'];
// } else {
//     echo json_encode(['error' => 'Student ID not found']);
//     exit;
// }

// Query to get upcoming exams for the student
// Assuming the status column holds 'Pending', 'Registered', or 'Completed'
$sql = "SELECT exam_name, exam_date, status 
        FROM exams 
        WHERE student_id = $student_id AND exam_date >= CURDATE()
        ORDER BY exam_date ASC";

// $stmt = $conn->prepare($sql);
// $stmt->bind_param('i', $studentId);
// $stmt->execute();
$result = $conn->query($sql);

// Check if results exist
if ($result->num_rows > 0) {
    $examsData = array();
    while ($row = $result->fetch_assoc()) {
        $examsData[] = $row; // Add each exam's details to the array
    }
    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($examsData);
} else {
    // No upcoming exams
    echo json_encode([]);
}

// Close the connection
$conn->close();
?>
