<?php
include '../php/db_config.php'; // Include your database configuration

session_start();
$exam_id = 1;  // Get the exam ID from the URL
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'examinee') {
//     echo "Unauthorized access! Please log in.";
//     exit;
// }

// Fetch exam details, including allotted time
$exam_sql = "SELECT exam_name, time_allotted FROM exam WHERE exam_id = $exam_id";
$exam_result = $conn->query($exam_sql);
$exam = $exam_result->fetch_assoc();

$allotted_time = $exam['time_allotted']; // Get allotted time from exam

// Fetch questions for the exam
$questions_sql = "SELECT * FROM question WHERE exam_id = $exam_id";
$questions_result = $conn->query($questions_sql);

$questions = [];
while ($row = $questions_result->fetch_assoc()) {
    $questions[] = [
        'id' => $row['question_id'],
        'question' => $row['question_text'],
        'choice_a' => $row['option_a'],
        'choice_b' => $row['option_b'],
        'choice_c' => $row['option_c'],
        'choice_d' => $row['option_d'],
        'correct' => $row['correct_answer']
    ];
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($exam['exam_name']); ?> - Exam</title>
    <link rel="stylesheet" href="../css/questions_styles.css">
    <style>
        #timer {
            font-size: 20px;
            color: red;
            margin-bottom: 20px;
        }
        .selected {
            background-color: lightblue;
        }
    </style>
</head>
<body>
    <div class="exam-container">
        <div id="progress">Question <span id="current-question-number"></span> of <?= count($questions) ?></div>
        <div id="timer">Time Left: <span id="time-left"></span></div>
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
        let questions = <?php echo json_encode($questions); ?>; // Passing PHP questions to JavaScript
        let allottedTime = '<?php echo $allotted_time; ?>'; // Passing allotted time to JavaScript
        let currentQuestion = 0;
        let totalQuestions = questions.length;
        let timerInterval;
        let answers = {}; // Store answers
        let startTime = Date.now();

        function startTimer() {
            const timeLeftDisplay = document.getElementById('time-left');
            const [hours, minutes, seconds] = allottedTime.split(':').map(Number);
            let totalTimeInSeconds = hours * 3600 + minutes * 60 + seconds;

            timerInterval = setInterval(() => {
                const min = Math.floor(totalTimeInSeconds / 60);
                const sec = totalTimeInSeconds % 60;
                timeLeftDisplay.textContent = `${String(min).padStart(2, '0')}:${String(sec).padStart(2, '0')}`;

                if (totalTimeInSeconds <= 300) { // Less than 5 minutes
                    timeLeftDisplay.style.color = 'red';
                }

                if (totalTimeInSeconds <= 0) {
                    clearInterval(timerInterval);
                    alert('Time is up! Submitting your exam now.');
                    document.getElementById('exam-form').submit(); // Automatically submit the exam
                } else {
                    totalTimeInSeconds--;
                }
            }, 1000);
        }

        function showQuestion(index) {
            const container = document.getElementById('questions-container');
            container.innerHTML = '';

            if (index < 0 || index >= totalQuestions) return;

            const question = questions[index];
            const questionHTML = `
                <div class="question">
                    <h2>${question.question}</h2>
                    <label for="q${question.id}a"><input id="q${question.id}a" type="radio" name="q${question.id}" value="A" onchange="saveAnswer(${question.id}, 'A')" ${getChecked(question.id, 'A')}> ${question.choice_a}</label><br>
                    <label for="q${question.id}b"><input id="q${question.id}b" type="radio" name="q${question.id}" value="B" onchange="saveAnswer(${question.id}, 'B')" ${getChecked(question.id, 'B')}> ${question.choice_b}</label><br>
                    <label for="q${question.id}c"><input id="q${question.id}c" type="radio" name="q${question.id}" value="C" onchange="saveAnswer(${question.id}, 'C')" ${getChecked(question.id, 'C')}> ${question.choice_c}</label><br>
                    <label for="q${question.id}d"><input id="q${question.id}d" type="radio" name="q${question.id}" value="D" onchange="saveAnswer(${question.id}, 'D')" ${getChecked(question.id, 'D')}> ${question.choice_d}</label><br>
                </div>
            `;
            container.innerHTML = questionHTML;
            document.getElementById('current-question-number').textContent = index + 1;
        }

        function getChecked(questionId, choice) {
            return answers[questionId] === choice ? 'checked' : '';
        }

        function navigate(direction) {
            currentQuestion += direction;

            if (currentQuestion >= totalQuestions) currentQuestion = totalQuestions - 1;
            if (currentQuestion < 0) currentQuestion = 0;
            if(currentQuestion < totalQuestions - 1) {
                document.getElementById('next-button').style.display = 'inline-block';
                document.getElementById('submit-button').style.display = 'none';
            }else {
                document.getElementById('next-button').style.display = 'none';
                document.getElementById('submit-button').style.display = 'inline-block';
            }
            showQuestion(currentQuestion);
        }

        function skipQuestion() {
            currentQuestion++;
            if (currentQuestion >= totalQuestions) {
                currentQuestion = totalQuestions - 1;
                document.getElementById('next-button').style.display = 'none';
                document.getElementById('submit-button').style.display = 'inline-block';
            }
            showQuestion(currentQuestion);
        }

        function nextQuestion() {
            if (isQuestionAnswered(currentQuestion)) {
                navigate(1);
            } else {
                alert('Please answer the current question before proceeding.');
            }
        }

        function isQuestionAnswered(index) {
            const questionId = questions[index].id;
            return answers[questionId] !== undefined; // Check if answer exists
        }

        function saveAnswer(questionId, answer) {
            answers[questionId] = answer;
            document.querySelectorAll(`[name="q${questionId}"]`).forEach(input => {
                input.parentElement.classList.remove('selected');
            });
            document.querySelector(`[name="q${questionId}"][value="${answer}"]`).parentElement.classList.add('selected');
        }

        document.getElementById('exam-form').addEventListener('submit', async function(event) {
            event.preventDefault();

            if (Object.keys(answers).length < totalQuestions) {
                let unanswered = totalQuestions - Object.keys(answers).length;
                alert(`You have ${unanswered} unanswered questions.`);
                return;
            }
        
            const timeTaken = Math.floor((Date.now() - startTime) / 1000);
        
            // Use FormData to send the data as a form submission
            const formData = new FormData();
            formData.append('user_id', '<?php echo $_SESSION['user_id']; ?>'); // Add user_id to the form
            fromData.append('role', '<?php echo $_SESSION['role']; ?>'); // Add role to the form
            formData.append('exam_id', <?php echo $exam_id; ?>); // Add exam_id to the form
            formData.append('time_taken', timeTaken);
        
            // Append answers to the FormData
            for (let questionId in answers) {
                formData.append(`answers[${questionId}]`, answers[questionId]);
            }
        
            try {
                const response = await fetch('submit_exam.php', {
                    method: 'POST',
                    body: formData
                });
            
                // Get response as text (since we're not using JSON)
                const result = await response.text();

                // Display the result (server response)
                document.querySelector('.exam-container').innerHTML = result;
                clearInterval(timerInterval); // Stop the timer
            } catch (error) {
                console.error('There was an error:', error.message);
                alert('An error occurred: ' + error.message);
            }
        });     



        window.onload = function() {
            startTimer();
            showQuestion(currentQuestion);
        };
    </script>
</body>
</html>
