<?php
// Start the session
session_start();

// Check if examID is set in the session
if (!isset($_SESSION['examID'])) {
    echo "Exam ID is not set in the session.";
    exit;
}

// Include the database connection file
include 'dbConnect.php'; // Make sure to replace with your actual DB connection file

// Get the examID from session
$examID = $_SESSION['examID'];

// Query to get examinee_ID and score from examinee_takes_exam table
$sql = "SELECT Examinee_ID, Score FROM examinee_takes_exam WHERE Exam_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $examID);
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to store the results
$exam_results = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $exam_results[] = $row;  // Add each result row to the array
    }
}

// Close the connection
$stmt->close();
$conn->close();

// Encode the results array to JSON and pass it to the frontend
echo json_encode($exam_results);
?>