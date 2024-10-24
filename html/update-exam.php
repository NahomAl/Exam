<?php
    session_start();
    if(isset($_POST['submit'])){
        $examID = $_SESSION['examID'];
        $examName = $_POST['exam_name'];
        $examType = $_POST['exam_type'];
        $numQuestions = $_POST['number_of_questions'];
        require_once "dbConnect.php";
        $stmt = mysqli_prepare($conn, 
        "UPDATE exam SET Exam_name = ?, Exam_type = ?, Number_of_questions = ? WHERE Exam_ID = $examID");
        mysqli_stmt_bind_param($stmt, "ssi", $examName, $examType, $numQuestions);
        if (mysqli_stmt_execute($stmt))
            echo "Exam updated succesfully";
        else
            echo "Error updating exam";
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: test.php");
    }
?>