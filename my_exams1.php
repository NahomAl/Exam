<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "final_project"; 

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// Query to fetch data
$sql = "SELECT student_id, exam_name, exam_date
        FROM exams 
        -- WHERE exam_date >= CURDATE()
        ORDER BY exam_date ASC";

$result = $conn->query($sql);

function getExams($examineeID){
    
}


/* // Check query result
if ($result && $result->num_rows > 0) {
    $examsData = [];
    while ($row = $result->fetch_assoc()) {
        $examsData[] = $row; // Add each exam to the array
    }
    header('Content-Type: application/json');
    echo json_encode($examsData); // Return the data as JSON
} else {
    header('Content-Type: application/json');
    echo json_encode([]); // Return an empty array if no exams found
} */

$conn->close();
?>
