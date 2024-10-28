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
    <style>
        .exam-questions-container {
            /* max-width: 800px; */
            margin: 20px;
            padding: 40px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .questions {
            /* list-style-type: none; */
            padding: 0;
            margin: 0;
        }

        .question-item {
            margin-bottom: 20px;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .question-text {
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 10px;
        }

        .answers {
            /* list-style-type: upper-alpha; */
            padding-left: 20px;
            margin: 10px 0;
        }

        .answer-option {
            margin: 5px 0;
        }

        .correct-answer {
            font-style: italic;
            color: #4CAF50;
            margin-top: 5px;
        }

        .qButton {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            color: #fff;
            background-color: #007BFF;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9em;
            transition: background-color 0.3s;
        }

        .qButton:hover {
            background-color: #0056b3;
        }
        .exam-questions-container > h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Website Title</h1>
    </header>
        
    <div class="container">
        <aside>
            <?php include('nav-links.html') ?>
        </aside>
        <main>
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
        </main>
    </div>
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

