<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Dashboard</title>
    <style>
        /*main.wrapper{
            display: flex;
            gap: 10px;
        }
        .header{
            height: 200px;
            width: 500px;
        }
        .exam-form{

        }
        .nav-links{
            display: flex;
        }*/
    </style>
</head>
<body>
    
    <div class="header"></div>
    <main class="wrapper">
        <nav>
            <ul class="nav-links">
                <li><a>Home</a></li>
            </ul>
        </nav>
        <?php
            include_once "dbConnect.php";
            $orgID = $_SESSION["orgID"];
            //echo "org id is $orgID";
            $examsList = mysqli_query($conn, "");
            if (mysqli_num_rows($examsList) > 0) {
                echo "<table>";
                echo "<thead><tr><th>Exam ID</th> <th>Exam name</th> <th>Exam type</th> <th>Date/Time</th> <th>Number of questions</th> <th>Time allotted</th> <th>Number of examinnes</th><tr></thead>";
                echo "<tbody>";
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td id="exam-ID">{$row["exam_ID"]}</td>';
                    echo '<td id="exam-name">{$row["exam_name"]}</td>';
                    echo '<td id="exam-type">{$row["exam_type"]}</td>';
                    echo '<td id="examTime">{$row["time_of_exam"]}</td>';
                    echo '<td id="num-questions">{$row["number_of_questions"]}</td>';
                    echo '<td id="num-examinees">{$row["number_of_examinees"]}</td>';
                    echo '<td><a href="exam-info.php?examID=<?php echo {$row["exam_ID"]} ?>">Edit</a></td>';
                    echo '<td><a href="add-question.php?examID=<?php echo {$row["exam_ID"]} ?>">Add Questions</a></td>';
                    echo '<td><a href="assign-exam-room.php?examID=<?php echo {$row["exam_ID"]} ?>">Assign Exam rooms</a></td>';
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
              } else {
                echo "<h2>No Exams Found</h2>";
              }
              
        ?>
    </main>

    <script src="../js/organizer-dashboard.js"></script>
</body>
</html>