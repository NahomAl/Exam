<?php
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$db = 'exam_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT id, question, choice_a, choice_b, choice_c, choice_d, correct_answer FROM questions";
$result = $conn->query($sql);

$questions = array();
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}

$conn->close();

echo json_encode($questions);
?>
