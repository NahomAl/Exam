<?php
    session_start();
    require_once 'dbConnect.php';

    //From organizer-dashboard.php
    if (isset($_POST['editExam'])){
        $_SESSION['examID'] = $_POST['editExam'];
        $_SESSION['examName'] = $_POST['examName'];
        header("Location: exam-editor2.php");
    }
    if (isset($_POST['deleteExam'])){
        $examID = $_POST['deleteExam'];
        $sql = $conn -> prepare("DELETE FROM exam WHERE Exam_ID = ?");
        $sql -> bind_param("i", $examID);
        if ($sql -> execute())
            header("Location: Org-dash.php");
        else
            die("Delete failed");
    }

    //From organizer-dashboard.php
    if (isset($_POST['viewQuestions'])){
        $_SESSION['examID'] = $_POST['viewQuestions'];
        $_SESSION['examName'] = $_POST['examName'];
        header("Location: exam-questions2.php");
    }

    //From exam-history.php
    if (isset($_POST['showResult'])){
        $_SESSION['examID'] = $_POST['showResult'];
        header("Location: exam-result.php");
    }

    //From create-exam.php
    if (isset($_POST["create-exam"])){
        $regex = "/^[A-Z][\w-_ ]*$/i";
        $examName = $_POST["exam-name"];
        $examType = $_POST["exam-type"];
        $examTime = $_POST['time_of_exam'];
        $timeAllotted = $_POST['time_allotted'];
        $orgID = $_SESSION['orgID'];
        if (!preg_match($regex, $examName))
            echo "Invalid input for exam name";
        else{
            $sql = $conn -> prepare("INSERT INTO exam (Exam_name, Exam_type, Time_allotted, Time_of_exam, Organizer_ID) VALUES (?, ?, ?, ?, ?)");
            $sql -> bind_param("ssssi", $examName, $examType, $timeAllotted, $examTime, $orgID);
            if ($sql -> execute()){
                $sql -> close();
                $conn -> close();
                header("Location: ./organizer-dashboard.php");
            }
            else
                echo "Error creating exam";
        }
        $sql -> close();
        $conn -> close();
    }

    //From exam-questions.php
    if (isset($_POST['editQuestion'])){
        $_SESSION['qID'] = $_POST['editQuestion'];
        header("Location: add-question.php");
    }

    //From exam-questions.php
    if (isset($_POST['addQuestion'])){
        unset($_SESSION['qID']);
        header("Location: add-question.php");
    }
    if (isset($_POST['deleteQuestion'])){
        $qID = $_POST['deleteQuestion'];
        $sql = $conn -> prepare("DELETE FROM question WHERE Question_ID = ?");
        $sql -> bind_param("i", $qID);
        if ($sql -> execute())
            header("Location: exam-questions.php");
        else
            die("Delete failed");
    }


    //From add-question.php
    if (isset($_POST['submitQuestion'])){
        $question = htmlspecialchars($_POST["question"]);
        $optionA = htmlspecialchars($_POST["optionA"]);
        $optionB = htmlspecialchars($_POST["optionB"]);
        $optionC = htmlspecialchars($_POST["optionC"]);
        $optionD = htmlspecialchars($_POST["optionD"]);
        $answer = htmlspecialchars($_POST["answer"]);
        require_once 'dbConnect.php';
        if (isset($_SESSION["qID"])){
            $qID = $_SESSION["qID"];
            $sql = $conn -> prepare("UPDATE question SET 
                            Question_text = ?, 
                            Option_A = ?, 
                            Option_B = ?, 
                            Option_C = ?, 
                            Option_D = ?, 
                            Correct_answer = ?
                            WHERE Question_ID = ?");
            $sql -> bind_param("ssssssi", $question, $optionA, $optionB, $optionC, $optionD, $answer, $qID);
            $status = $sql -> execute();
        }
        else{
            $examID = $_SESSION["examID"];
            $sql = $conn -> prepare("INSERT INTO question(Exam_ID,Question_text,Option_A,Option_B,Option_C,Option_D,Correct_answer)
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
            $sql -> bind_param("issssss", $examID, $question, $optionA, $optionB, $optionC, $optionD, $answer);
            $status = $sql -> execute(); 
        }
        $sql -> close();
        $conn -> close();
        if ($status){
            header("Location: exam-questions.php");
        }
        else
            echo "Operation failed";
    }

    //From exam-editor.php
    if(isset($_POST['submitExam'])){
        $examID = $_SESSION['examID'];
        $examName = $_POST['exam_name'];
        $examType = $_POST['exam_type'];
        $examTime = $_POST['time_of_exam'];
        $timeAllotted = $_POST['time_allotted'];
        $numQuestions = $_POST['number_of_questions'];
        $stmt = $conn -> prepare("UPDATE exam SET Exam_name = ?, Exam_type = ?, Time_of_exam = ?, Time_allotted = ?, Number_of_questions = ? WHERE Exam_ID = $examID");
        $stmt -> bind_param("ssssi", $examName, $examType, $examTime, $timeAllotted, $numQuestions);
        $status = $stmt -> execute();
        $stmt -> close();
        $conn -> close();
        if ($status)
            header("Location: Org-dash.php");
        else
            echo "Error updating exam";
    }

    if (isset($_POST['takeExam'])){
        header("Location: .php");
    }
/* 
    //From exam-editor.php
    if (isset($_POST['setExamSchedule'])){
        $examID = $_SESSION['examID'];
        header("Location: exam-schedule.php");
    } */
?>