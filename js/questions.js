let questions = [];
        let currentQuestion = 0;
        let totalQuestions = 0;

        async function fetchQuestions() {
            const response = await fetch('../php/questions.php');
            questions = await response.json();
            totalQuestions = questions.length;
            showQuestion(currentQuestion);
        }

        function showQuestion(index) {
            const container = document.getElementById('questions-container');
            container.innerHTML = '';

            if (index < 0 || index >= totalQuestions) return;

            const question = questions[index];
            const questionHTML = `
                <div class="question">
                    <h2>${question.question}</h2>
                    <label><input type="radio" name="q${question.id}" value="A"> ${question.choice_a}</label><br>
                    <label><input type="radio" name="q${question.id}" value="B"> ${question.choice_b}</label><br>
                    <label><input type="radio" name="q${question.id}" value="C"> ${question.choice_c}</label><br>
                    <label><input type="radio" name="q${question.id}" value="D"> ${question.choice_d}</label><br>
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
            const questionId = questions[index].id;
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
                body: new URLSearchParams({ answers: JSON.stringify(answers) })
            });

            const result = await response.json();

            if (result.unanswered.length > 0) {
                alert(`You have not answered the following questions: ${result.unanswered.join(', ')}`);
            } else {
                alert(`Exam submitted! Your score: ${result.score}/${result.total}`);
            }
        });

        // Initialize the exam form by fetching questions
fetchQuestions();
