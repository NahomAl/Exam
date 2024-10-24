<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
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

// Fetch the student ID (in a real-world scenario, this could come from the session or request)
$student_id = 2; // Example student ID (this would normally be dynamic)

// if (isset($_SESSION['student_id'])) {
//     $student_id = $_SESSION['student_id'];
// } else {
//     echo json_encode(['error' => 'Student ID not found']);
//     exit;
// }

// Query to get the exam results for the student
$sql = "SELECT exam_name, score
        FROM exams WHERE student_id = $student_id 
        ORDER BY exam_date ASC";

// $stmt = $conn->prepare($sql);
// $stmt->bind_param('i', $student_id);
// $stmt->execute();
$result = $conn->query($sql);

// Check if results exist
if ($result->num_rows > 0) {
    // Create an array to store the data
    $resultsData = array();
    
    // Fetch results and store them in the array
    while($row = $result->fetch_assoc()) {
        $resultsData[] = $row;
    }
    
    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($resultsData);
    var_dump($resultsData);
} else {
    // Return empty JSON if no results
    echo json_encode([]);
}

// Close the connection
$conn->close();
?>
