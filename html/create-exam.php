<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/create-exam.css">
</head>
<body>
<header>
    <h1>Examination Sytem</h1>
</header>
<div class="container">
        <aside>
            <?php include("nav-links.html") ?>
        </aside>
        <main>
            <form action="form-handler.php" method="post" name="create-exam-form" class="create-exam-form">
                <label for="exam-name">Exam name: </label>
                <input type="text" name="exam-name" id="exam-name" required><br>
                <label for="exam-type">Exam type: </label>
                <select name="exam-type" id="exam-type" required>
                    <option value="none" selected disabled>Select exam type</option>
                    <option value="Academic assessment">Academic Assessment</option>
                    <option value="Certification Exam">Certification Exam</option>
                    <option value="Training Assessment">Training Assessment</option>
                    <option value="Licensing Exam">Licensing Exam</option>
                    <option value="Other">Other</option>
                </select><br>
                <label for="time-allotted">Time Allotted (hours:minutes):</label>
                <input type="time" id="time-allotted" name="time_allotted" required>

                <label for="time-of-exam">Time of Exam:</label>
                <input type="datetime-local" id="time-of-exam" name="time_of_exam" required>
                <input type="submit" name="create-exam" value="Create Exam">
                <div class="err-div"></div>
            </form>
        </main>
    </div>    
    <script>
        let form = document.forms['create-exam-form'];
        form.addEventListener('submit', (e) => validateForm(e));
        function validateForm(e){
            let errDiv = document.querySelector('.err-div');
            errDiv.innerText = '';
            const examName = form['exam-name'];
            const examType = form['exam-type'];
            const regex = /^[A-Z][\w-_ ]*$/i;
            if (!regex.test(examName.value))
                errDiv.innerText += 'Invalid Exam name\n';
            if (examType.value === 'none')
                errDiv.innerText += 'Exam type not selected\n';
            if(errDiv.innerText !== '')
                e.preventDefault();
        }
    </script>
</body>
</html>