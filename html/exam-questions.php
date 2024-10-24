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
    <?php
        $examID = htmlspecialchars($_GET["examID"], ENT_QUOTES, 'UTF-8');
        require("dbConnect.php");
        $sql = $conn -> prepare("SELECT * FROM question WHERE Exam_ID = ?");
        $sql -> bind_param("i", $examID);
        $sql -> execute();
        $result = $sql -> get_result();
        //$count = 1;
        echo "<ol>";
        while ($row = $result -> fetch_assoc()){
            echo "<li>";
            echo "<p>{$row['Question_text']}</p>";
            echo '<ol type="A">';
            echo    "<li><p>{$row['Option_A']}</p></li>";
            echo    "<li><p>{$row['Option_B']}</p></li>";
            echo    "<li><p>{$row['Option_C']}</p></li>";
            echo    "<li><p>{$row['Option_D']}</p></li>";
            echo "</ol>";
            echo "</li>";
            echo "<p>Correct Answer: {$row['Correct_answer']}</p>";
            echo '<a href="add-question.php?qID=<?php echo {$row["Question_ID"]} ?>">Edit</a>';
            echo '<a href="add-question.php?qID=<?php echo {$row["Question_ID"]} ?>">Edit</a>';
        }
        echo "</ol>";
        echo '<a href="add-question.php?examID=<?php echo $examID ?>">Add Question</a>';
        $sql -> close();
        $conn -> close();
    ?>
</body>
</html>