<?php
// Example results processing, you should validate and sanitize inputs in a real application

$submitted_answers = $_POST['answers'];
$correct_answers = [
    1 => 'C', // Correct answers for each question
    2 => 'B',
    3 => 'C',
    4 => 'A'
];

$score = 0;
$unanswered = [];

foreach ($submitted_answers as $question_id => $answer) {
    if ($answer === $correct_answers[$question_id]) {
        $score++;
    } else if (empty($answer)) {
        $unanswered[] = $question_id;
    }
}

$response = [
    'score' => $score,
    'total' => count($correct_answers),
    'unanswered' => $unanswered
];

echo json_encode($response);
?>
