<?php
include 'db_config.php';
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'examinee') {
    echo "Unauthorized access! Please log in.";
    exit;
}

// Fetch examinee_id from session
$examinee_id = $_SESSION['user_id'];

// Get POST data
$exam_id = $_POST['user_id'];
$time_taken = $_POST['time_taken'];
$answers = $_POST['answers']; // This is an associative array

$score = 0;
$total = count($answers);
$unanswered = [];

// Check each answer
foreach ($answers as $question_id => $answer) {
    $sql = "SELECT correct_answer FROM question WHERE question_id = $question_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['correct_answer'] == $answer) {
            $score++;
        }
    } else {
        $unanswered[] = $question_id;
    }
}

// Update the examinee's score and submission time
$sql = "UPDATE examinee_takes_exam SET score=$score, submission_time=NOW() WHERE examinee_id=$examinee_id AND exam_id=$exam_id";
if ($conn->query($sql) === TRUE) {
    echo "<h1>Exam Completed</h1>";
    echo "<p>You scored $score/$total.</p>";
    echo "<p>Time taken: $time_taken seconds.</p>";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
