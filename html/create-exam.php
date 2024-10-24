<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" name="create-exam-form">
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
        <label for="num-of-questions">Number of Questions</label>
        <input type="number" min="5" max="200" value="5" name="num-of-questions" id="number-of-questions"><br>
        <label for="time-alloted">Time allotted</label>
        <input type="time" min="00:30" max="06:00" value="00:30" name="time-allotted" id="time-alloted"><br>
        <label for="num-of-examinees">Number of Examinees</label>
        <input type="number" min="10" max="1000000" value="10" name="num-of-examinees" id="num-of-examinees"><br>
        <label for="exam-time">Data/Time of Exam</label>
        <input type="datetime-local" name="exam-time" id="exam-time"><br>
        <input type="submit" name="create" value="Create Exam">
        <div class="err-div"></div>
    </form>
    <?php
        if (isset($_POST["create"])){
            $regex = "/^[A-Z][\w-_ ]*$/i";
            $examName = $_POST["exam-name"];
            $examType = $_POST["exam-type"];
            $numQuestion = $_POST["num-of-questions"];
            $timeAlloted = $_POST["time-allotted"];
            $numExaminees = $_POST["num-of-examinees"];
            $orgID = $_SESSION['orgID'];
            if (!preg_match($regex, $examName))
                echo "Invalid input for exam name";
            else{
                $sql = "INSERT INTO exam (Exam_name, Exam_type, Number_of_questions, Time_alloted, Number_of_examinees,
                        Organizer_ID) VALUES ('$examName', '$examType', $numQuestion, $timeAlloted, $numExaminees, $orgID)";
                if (mysqli_query($conn, $sql))
                    header("Location: ./organizer-dashboard.php");
                else
                    echo "Error creating exam";
            }
        }
    ?>
    <script>
        let form = document.forms['create-exam-form'];
        form.addEventListener('submit', (e) => validateForm(e));
        function validateForm(e){
            let errDiv = document.querySelector('.err-div');
            errDiv.innerText = '';
            const examName = form['exam-name'];
            const examType = form['exam-type'];
            const numQuestion = parseInt(form['num-of-questions']);
            const timeAllotted = form['time-alloted'];
            const numExaminees = form['num-of-examinees'];
            

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