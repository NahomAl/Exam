<?php
include '../php/db_config.php'; // Include database connection
session_start();

// Check if user is logged in and is an examinee
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'examinee') {
    echo "Unauthorized access!";
    exit;
}

// Get the exam ID from the URL
$exam_id = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;

// Fetch the exam details
$sql = "SELECT exam_name FROM exam WHERE exam_id = $exam_id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "Invalid exam ID!";
    exit;
}

$row = $result->fetch_assoc();
$exam_name = $row['exam_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $exam_name; ?></title>
    <link rel="stylesheet" href="../css/questions_styles.css">
    <script src="../js/questions.js" defer></script>
</head>
<body>
    <div class="exam-container">
        <h2><?php echo $exam_name; ?></h2>
        <form id="exam-form">
            <div id="questions-container"></div>
            <div class="navigation-buttons">
                <button type="button" id="back-button" onclick="navigate(-1)">Back</button>
                <button type="button" id="skip-button" onclick="skipQuestion()">Skip</button>
                <button type="button" id="next-button" onclick="nextQuestion()">Next</button>
                <button type="submit" id="submit-button" style="display:none;">Submit</button>
            </div>
        </form>
    </div>

    <script>
        // Fetch questions based on exam ID
        async function fetchQuestions() {
            const response = await fetch(`../php/questions.php?exam_id=<?php echo $exam_id; ?>`);
            const questions = await response.json();
            totalQuestions = questions.length;
            showQuestion(currentQuestion);
        }

        let questions = [];
        let currentQuestion = 0;
        let totalQuestions = 0;

        function showQuestion(index) {
            const container = document.getElementById('questions-container');
            container.innerHTML = '';

            if (index < 0 || index >= totalQuestions) return;

            const question = questions[index];
            const questionHTML = `
                <div class="question">
                    <h3>${question.question_text}</h3>
                    <label><input type="radio" name="q${question.question_id}" value="A"> ${question.option_a}</label><br>
                    <label><input type="radio" name="q${question.question_id}" value="B"> ${question.option_b}</label><br>
                    <label><input type="radio" name="q${question.question_id}" value="C"> ${question.option_c}</label><br>
                    <label><input type="radio" name="q${question.question_id}" value="D"> ${question.option_d}</label><br>
                </div>
            `;
            container.innerHTML = questionHTML;
            updateButtons();
        }

        function navigate(direction) {
            if (direction === 1 && !isQuestionAnswered(currentQuestion)) {
                alert('Please answer the current question before proceeding.');
                return;
            }

            currentQuestion += direction;

            if (currentQuestion >= totalQuestions) {
                currentQuestion = totalQuestions - 1;
                document.getElementById('next-button').style.display = 'none';
                document.getElementById('submit-button').style.display = 'inline-block';
            } else if (currentQuestion < 0) {
                currentQuestion = 0;
            }

            showQuestion(currentQuestion);
        }

        function skipQuestion() {
            navigate(1);
        }

        function nextQuestion() {
            if (isQuestionAnswered(currentQuestion)) {
                navigate(1);
            } else {
                alert('Please answer the current question before proceeding.');
            }
        }

        function isQuestionAnswered(index) {
            const questionId = questions[index].question_id;
            return document.querySelector(`input[name="q${questionId}"]:checked`) !== null;
        }

        document.getElementById('exam-form').addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const answers = {};

            for (const [key, value] of formData.entries()) {
                if (key.startsWith('q')) {
                    answers[key.substring(1)] = value;
                }
            }

            const response = await fetch('submit_exam.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ exam_id: <?php echo $exam_id; ?>, answers: JSON.stringify(answers) })
            });

            const result = await response.json();
            alert(`Exam submitted! Your score: ${result.score}/${result.total}`);
            // Redirect or show results
        });

        // Initialize the exam form by fetching questions
        fetchQuestions();
    </script>
</body>
</html>
