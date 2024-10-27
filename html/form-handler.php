<?php
    session_start();
    if (isset($_POST['editExam'])){
        $_SESSION['examID'] = $_POST['editExam'];
        header("Location: exam-editor.php");
    }
    if (isset($_POST['editQuestions'])){
        $_SESSION['examID'] = $_POST['editQuestions'];
        header("Location: exam-questions.php");
    }

    if (isset($_POST["create-exam"])){
        $regex = "/^[A-Z][\w-_ ]*$/i";
        $examName = $_POST["exam-name"];
        $examType = $_POST["exam-type"];
        $numQuestion = $_POST["num-of-questions"];
        //$timeAlloted = $_POST["time-allotted"];
        //$numExaminees = $_POST["num-of-examinees"];
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