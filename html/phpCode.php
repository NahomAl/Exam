<?php
    function displayExam2($orgID, $keyword){
        //echo "<h2>Welcome to the organizer dashboard</h2>";
        //echo "<p>This is where your exams are displayed. You can search for an exam, create a new exam, edit an exam.</p>";
        include_once "dbConnect.php";
        if ($keyword == '')
            $result = mysqli_query($conn, "SELECT * FROM exam WHERE Organizer_ID = $orgID");
        else
            $result = mysqli_query($conn, "SELECT * FROM exam WHERE Organizer_ID = $orgID AND NOW() < Time_of_exam AND Exam_name like '%$keyword%'");
        
        $examCount = mysqli_num_rows($result);
        if ($examCount > 0){
            //echo "<h2>$examCount Upcoming exam(s)</h2>";
            echo '<div class="tables">';
            echo '<table class="exams">';
            echo "<tr><th>Exam ID</th> <th>Exam name</th> <th>Exam type</th> <th>Date/Time</th> <th></th><th></th><th></th><tr>";
            echo "<tbody>";
            while($row = mysqli_fetch_assoc($result)) {
                $examID = $row['Exam_ID'];
                $examName = $row['Exam_name'];
                echo '<tr class="exam">';
                echo "<td>" . $examID . "</td>";
                echo "<td>" . $examName . "</td>";
                echo "<td>" . $row['Exam_type'] . "</td>";
                echo "<td>" . $row['Time_of_exam'] . "</td>";
                /* echo "<td>" . $row['Number_of_questions'] . "</td>";
                echo "<td>" . $row['Number_of_examinees'] . "</td>"; */
                echo '<form action="form-handler.php" method="post">';
                echo "<input type='hidden' name='examName' value='$examName'>";
                echo "<td><button type='submit' name='editExam' value='$examID'>Edit</button></td>";
                echo "<td><button type='submit' name='deleteExam' class='del' value='$examID'>Delete</button></td>";
                echo "<td><button type='submit' name='viewQuestions' value='$examID'>Questions</button></td>";
                echo '</form>';
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        }
        else{
            "<h2>No exam found</h2>";
        }
        //$conn->close();
    }
    function displayExam($orgID, $keyword){
        //echo "<h2>Welcome to the organizer dashboard</h2>";
        //echo "<p>This is where your exams are displayed. You can search for an exam, create a new exam, edit an exam.</p>";
        include_once "dbConnect.php";
        if ($keyword == '')
            $result = mysqli_query($conn, "SELECT * FROM exam WHERE Organizer_ID = $orgID");
        else
            $result = mysqli_query($conn, "SELECT * FROM exam WHERE Organizer_ID = $orgID AND NOW() < Time_of_exam AND Exam_name like '%$keyword%'");
        
        $examCount = mysqli_num_rows($result);
        if ($examCount > 0){
            //echo "<h2>$examCount Upcoming exam(s)</h2>";
            //echo '<div class="tables">';
            //echo '<table class="exams">';
            //echo "<tr><th>Exam ID</th> <th>Exam name</th> <th>Exam type</th> <th>Date/Time</th> <th></th><th></th><th></th><tr>";
            //echo "<tbody>";
            while($row = mysqli_fetch_assoc($result)) {
                $examID = $row['Exam_ID'];
                $examName = $row['Exam_name'];
                echo '<tr class="exam">';
                echo "<td>" . $examID . "</td>";
                echo "<td>" . $examName . "</td>";
                echo "<td>" . $row['Exam_type'] . "</td>";
                echo "<td>" . $row['Time_of_exam'] . "</td>";
                echo '<form action="form-handler.php" method="post">';
                echo "<input type='hidden' name='examName' value='$examName'>";
                echo "<td><button type='submit' name='editExam' value='$examID' class='btn'>Edit</button></td>";
                echo "<td><button type='submit' name='deleteExam' class='del' value='$examID' class='btn'>Delete</button></td>";
                echo "<td><button type='submit' name='viewQuestions' value='$examID' class='btn'>Questions</button></td>";
                echo '</form>';
                echo "</tr>";
            }
            /* echo "</tbody>";
            echo "</table>";
            echo "</div>"; */
        }
        else{
            "<h2>No exam found</h2>";
        }
        //$conn->close();
    }

    function getExamHistory($orgID, $keyword){
        include_once "dbConnect.php";
        if ($keyword == '')
            $result = mysqli_query($conn, "SELECT * FROM exam WHERE Organizer_ID = $orgID");
        else
            $result = mysqli_query($conn, "SELECT * FROM exam WHERE Organizer_ID = $orgID AND NOW() > Time_of_exam AND Exam_name like '%$keyword%'");
        $examCount = mysqli_num_rows($result);
        if ($examCount > 0){
            echo "<h2>$examCount exam(s)</h2>";
            echo '<div class="tables">';
            echo '<table class="exams">';
            echo "<tr><th>Exam ID</th> <th>Exam name</th> <th>Exam type</th> <th>Date/Time</th><th></th><tr>";
            echo "<tbody>";
            while($row = mysqli_fetch_assoc($result)) {
                $examID = $row['Exam_ID'];
                echo '<tr class="exam">';
                echo "<td>" . $row['Exam_ID'] . "</td>";
                echo "<td>" . $row['Exam_name'] . "</td>";
                echo "<td>" . $row['Exam_type'] . "</td>";
                echo "<td>" . $row['Time_of_exam'] . "</td>";
                echo '<form action="form-handler.php" method="post">';
                echo "<td><button type='submit' name='showResult' value='$examID'>Show result</button></td>";
                echo '</form>';
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        }
        else{
            "<h2>No exam found</h2>";
        }
    }
?>