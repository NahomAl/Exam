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
<?php
    if(isset($_GET["qID"])){
        $questionID = $_GET["qID"];
        $sql = "SELECT * FROM question WHERE Question_ID = $questionID";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $questionText = $row["Question_text"];
        $optionA = $row["Option_A"];
        $optionB = $row["Option_B"];
        $optionC = $row["Option_C"];
        $optionD = $row["Option_D"];
        $answer = $row["Correct_answer"];
    }
    else{
        $questionText = '';
        $optionA = '';
        $optionB = '';
        $optionC = '';
        $optionD = '';
        $answer = '';
    }
    
?>
<body>
    <form action="" method="post">
        <label for="question">Question</label>
        <textarea name="question" id="question" cols="100" rows="7" required>
            <?php if(!isset($questionText)) echo $questionText; ?>
        </textarea><br>
        <label for="optionA">A. </label>
        <input type="radio" name="answer" id="answerA" value="A" required>
        <textarea name="optionA" id="optionA" cols="100" rows="3" required>
            <?php if(!isset($optionA)) echo $optionA; ?>
        </textarea><br>
        <label for="optionB">B. </label>
        <input type="radio" name="answer" id="answerB" value="B">
        <textarea name="optionB" id="optionB" cols="100" rows="3" required>
            <?php if(!isset($optionB)) echo $optionB; ?>
        </textarea><br>
        <label for="optionC">C. </label>
        <input type="radio" name="answer" id="answerC" value="C">
        <textarea name="optionC" id="optionC" cols="100" rows="3" required>
            <?php if(!isset($optionC)) echo $optionC; ?>
        </textarea><br>
        <label for="optionD">D. </label>
        <input type="radio" name="answer" id="answerD" value="D">
        <textarea name="optionD" id="optionD" cols="100" rows="3" required>
            <?php if(!isset($optionD)) echo $optionD; ?>
        </textarea><br>
        <input type="submit" name="done" value="Done">
    </form>

    <?php
        if(isset($_POST["submit"])){
            $question = $_POST["question"];
            $optionA = $_POST["optionA"];
            $optionB = $_POST["optionB"];
            $optionC = $_POST["optionC"];
            $optionD = $_POST["optionD"];
            $answer = $_POST["answer"];
            require("dbConnect.php");
            if (isset($_GET["qID"])){
                $sql = $conn -> prepare("UPDATE question SET 
                                Question_text = ?, 
                                Option_A = ?, 
                                Option_B = ?, 
                                Option_C = ?, 
                                Option_D = ?, 
                                Correct_answer = ?
                                WHERE Question_ID = ?");
                $sql -> bind_param("ssssssi", $question, $optionA, $optionB, $optionC, $optionD, $answer, $questionID);
                $sql -> execute();
                $sql -> close();
                $conn -> close();
            }
            else if (isset($_GET["examID"])){
                $examID = $_GET["examID"];
                $sql = $conn -> prepare("INSERT INTO question(Exam_ID,Question_text,Option_A,Option_B,Option_C,Option_D,Correct_answer)
                                        VALUES (?, ?, ?, ?, ?, ?)");
                $sql -> bind_param("issssss", $examID, $question, $$optionA, $optionB, $optionC, $optionD, $answer);
                $sql -> execute();
                $sql -> close();
                $conn -> close();
            }
        }
    ?>
    <script>
        
    </script>
</body>
</html>