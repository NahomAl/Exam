<?php
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
                echo '<form action="html/form-handler.php" method="post">';
                echo "<input type='hidden' name='examName' value='$examName'>";
                echo "<td><button type='submit' name='takeExam' value='$examID' class='btn'>Take Exam</button></td>";
           
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

    function displayResults($examineeID, $keyword){
        //echo "<h2>Welcome to the organizer dashboard</h2>";
        //echo "<p>This is where your exams are displayed. You can search for an exam, create a new exam, edit an exam.</p>";
        include_once "dbConnect.php";
        if ($keyword == '')
            $result = mysqli_query($conn, "SELECT * FROM exam WHERE Organizer_ID = $orgID AND NOW() - Time_of_exam > Time_allotted");
        else
            $result = mysqli_query($conn, "SELECT * FROM exam WHERE Organizer_ID = $orgID AND NOW() - Time_of_exam > Time_allotted AND Exam_name like '%$keyword%'");
        
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
                echo "<td>" . getresult($examineeID) . "</td>";

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

    function getresult($examineeID){
        include_once "dbConnect.php";
        $result = mysqli_query($conn, "SELECT Score FROM examinee_takes_exam WHERE Examinee_ID = $examineeID");
        $row=mysqli_fetch_assoc($Result);
        return $row["Score"];
    }

?>