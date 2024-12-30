<?php
    session_start();
    require_once 'dbConnect.php';
    if (!isset($_SESSION['examID'])) {
        die('Exam ID not provided.');
    }
    $examID = $_SESSION['examID'];

    $query = "SELECT * FROM exam WHERE Exam_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $examID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die('No exam found with the provided ID.');
    }

    $exam = $result->fetch_assoc();
    $_SESSION['examTime'] = $exam['Time_of_exam'];
    $_SESSION['timeAllotted'] = $exam['Time_allotted'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard | Korsat X Parmaga</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../css/exam-questions.css">
</head>

<body>
    </body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
        <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="logo-apple"></ion-icon>
                        </span>
                        <span class="title">Examino</span>
                    </a>
                </li>

                <li>
                    <a href="Org-dash.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="create-exam2.php">
                        <span class="icon">
                            <ion-icon name="create-outline"></ion-icon>
                        </span>
                        <span class="title">Create Exam</span>
                    </a>
                </li>

                <li>
                    <a href="exam-history2.php">
                        <span class="icon">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">Exam History</span>
                    </a>
                </li>
                <li>
                    <a href="exam-schedule.php">
                        <span class="icon">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </span>
                        <span class="title">Exam Schedule</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                

                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>

            <!-- ======================= Cards ================== -->

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                <?php
                $examID = htmlspecialchars($_SESSION["examID"], ENT_QUOTES, 'UTF-8');
                require("dbConnect.php");
                $sql = $conn -> prepare("SELECT * FROM question WHERE Exam_ID = ?");
                $sql -> bind_param("i", $examID);
                $sql -> execute();
                $result = $sql -> get_result();
                ?>
            <div class="exam-questions-container">
                <h2>Questions for: <?php echo $_SESSION['examID'] . " - " . $_SESSION['examName'] ?></h2>
                <ol class="questions">
                    <?php
                    if ($result -> num_rows > 0){
                        while ($row = $result->fetch_assoc()) {
                            echo "<li class='question-item'>";
                            echo "<p class='question-text'>{$row['Question_text']}</p>";
                            echo '<ol type="A" class="answers">';
                            echo "<li class='answer-option'><p>{$row['Option_A']}</p></li>";
                            echo "<li class='answer-option'><p>{$row['Option_B']}</p></li>";
                            echo "<li class='answer-option'><p>{$row['Option_C']}</p></li>";
                            echo "<li class='answer-option'><p>{$row['Option_D']}</p></li>";
                            echo "</ol>";
                
                            echo "<p class='correct-answer'>Correct Answer: {$row['Correct_answer']}</p>";
                            echo '<form action="form-handler.php" method="post">';
                            echo "<button type='submit' name='editQuestion' value='$row[Question_ID]' class='qButton'>Edit</button>";
                            echo "<button type='submit' name='deleteQuestion' value='$row[Question_ID]' class='qButton del'>Delete</button>";
                            echo '</form>';
                            echo "</li>";
                        }
                    }
                    else
                        echo "<p>No questions found</p>";
                    ?>
                </ol>
                <form action="form-handler.php" method="post">
                    <button type='submit' name='addQuestion' class='qButton'>Add Question</button>
                </form>
            </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>

                
<?php
    /*
    $examID = htmlspecialchars($_SESSION["examID"], ENT_QUOTES, 'UTF-8');
    require("dbConnect.php");
    $sql = $conn -> prepare("SELECT * FROM question WHERE Exam_ID = ?");
    $sql -> bind_param("i", $examID);
    $sql -> execute();
    $result = $sql -> get_result();
    //$count = 1;
    echo "<ol class='questions'>";
    while ($row = $result -> fetch_assoc()){
        echo "<li>";
        echo "<p>{$row['Question_text']}</p>";
        echo '<ol type="A" class="answers">';
        echo    "<li><p>{$row['Option_A']}</p></li>";
        echo    "<li><p>{$row['Option_B']}</p></li>";
        echo    "<li><p>{$row['Option_C']}</p></li>";
        echo    "<li><p>{$row['Option_D']}</p></li>";
        echo "</ol>";
        echo "</li>";
        echo "<p class='correct-answer'>Correct Answer: {$row['Correct_answer']}</p>";
        echo '<a href="add-question.php?qID=<?php echo {$row["Question_ID"]} ?>">Edit</a>';
        echo '<a href="add-question.php?qID=<?php echo {$row["Question_ID"]} ?>">Edit</a>';
    }
    echo "</ol>";
    echo '<a href="add-question.php?examID=<?php echo $examID ?>">Add Question</a>';
    $sql -> close();
    $conn -> close();
    */
?>



