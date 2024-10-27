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
}

function nextQuestion() {
    currentQuestion++;
    if (currentQuestion >= totalQuestions) {
        document.getElementById('next-button').style.display = 'none';
        document.getElementById('submit-button').style.display = 'inline-block';
    }
    showQuestion(currentQuestion);
}

document.getElementById('exam-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    const answers = {};
    
    for (const [key, value] of formData.entries()) {
        answers[key.substring(1)] = value;
    }

    const response = await fetch('submit_exam.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ answers: JSON.stringify(answers) })
    });

    const result = await response.json();
    alert(`Exam submitted! Your score: ${result.score}/${result.total}`);
});

fetchQuestions();
