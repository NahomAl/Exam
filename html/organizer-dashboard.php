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
    function displayExam(){
        include_once "dbConnect.php";
        $orgID = $_SESSION["orgID"];
        $examsList = mysqli_query($conn, "CALL GetUpcomingExams($orgID)");
        $examCount = mysqli_num_rows($examsList);
        if ($examCount > 0){
            echo "<h2>$examCount Upcoming exam(s)</h2>";
            echo '<table class="exams">';
            echo "<tr><th>Exam ID</th> <th>Exam name</th> <th>Exam type</th> <th>Date/Time</th> <th>Number of questions</th> <th>Number of examinees</th><tr>";
            echo "<tbody>";
            while($row = mysqli_fetch_assoc($examsList)) {
                $examID = $row['Exam_ID'];
                //$_SESSION['examID'] = $row['Exam_ID']; //$examID;
                //$editLink = "exam-info.php?examID=" . $examID;
                //$questionsLink = "exam-questions.php?examID=" . $examID;
                //$editLink = "exam-editor.php?examID=" . $row['Exam_ID'];
                //$questionsLink = "exam-questions.php?examID=" . $row['Exam_ID'];
                echo '<tr class="exam">';
                echo "<td>" . $row['Exam_ID'] . "</td>";
                echo "<td>" . $row['Exam_name'] . "</td>";
                echo "<td>" . $row['Exam_type'] . "</td>";
                echo "<td>" . $row['Time_of_exam'] . "</td>";
                echo "<td>" . $row['Number_of_questions'] . "</td>";
                echo "<td>" . $row['Number_of_examinees'] . "</td>";
                echo '<form action="exam-questions" method="post">';
                echo "<td><button type='submit' name='editExam' value='$examID'>Edit</button></td>";
                echo "<td><button type='submit' name='editQuestions' value='$examID'>Questions</button></td>";
                echo '</form>';
                //onclick=\"location.href='$editLink'\"
                //onclick=\"location.href='$questionsLink'\"
                //echo "<td><a href=\"$editLink\">Edit</a></td>";
                //echo "<td><a href=\"$questionsLink\">Add Questions</a></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        else
            echo "<h2>No Upcoming exams</h2>";
        //$conn->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Dashboard</title>
    <link rel="stylesheet" href="../css/new2.css">
</head>
<body>
    
    <header>
        <h1>Website Title</h1>
        <form>
            <input type="text" placeholder="Search exam">
            <button type="submit">Search</button>
        </form>
    </header>
    
    <div class="container">
        <aside>
            <nav>
                <ul>
                    <li><a href="organizer-dashboard.php">Home</a></li>
                    <li><a href="#">Create new exam</a></li>
                    <li><a href="#">Exam History</a></li>
                    <li><a href="#">Exam Schedule</a></li>
                    <li><a href="#">My account</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </nav>
        </aside>
    <!--</div>-->
        <main>
            <h2>Welcome to the organizer dashboard</h2>
            <p>This is where your exams are displayed. You can search for an exam, create a new exam, edit an exam.</p>
            
            <div class="tables">
                <h3>Table 1: Sample Data</h3>
                
                <?php displayExam() ?>
                
            </div>
        </main>
    </div>
</body>
</html>
