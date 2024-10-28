<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Question</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/add-question.css">
</head>
<?php
    require("dbConnect.php");
    
    if(isset($_SESSION["qID"])){
        $questionID = $_SESSION["qID"];
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
    <header>
        <h1>Examination Sytem</h1>
    </header>
    <div class="container">
        <aside>
            <?php include("nav-links.html") ?>
        </aside>
        <main>
            <form action="form-handler.php" method="post" name="question-form">
                <h1 class="page-title"><?php echo isset($_SESSION["qID"]) ? "Edit Question" : "Add New Question"; ?></h1>
                
                <label for="question">Question</label>
                <textarea name="question" id="question" cols="70" rows="7" required><?php echo htmlspecialchars($questionText); ?></textarea>

                <div class="options">
                    <div>
                        <input type="radio" name="answer" value="A" required <?php echo $answer == 'A' ? 'checked' : ''; ?>>
                        <span for="optionA">A. </span>
                        <textarea name="optionA" id="optionA" cols="50" rows="3" required><?php echo htmlspecialchars($optionA); ?></textarea>
                    </div>
                    <div>
                        <input type="radio" name="answer" value="B" <?php echo $answer == 'B' ? 'checked' : ''; ?>>
                        <label for="optionB">B. </label>
                        <textarea name="optionB" id="optionB" cols="50" rows="3" required><?php echo htmlspecialchars($optionB); ?></textarea>
                    </div>
                    <div>
                        <input type="radio" name="answer" value="C" <?php echo $answer == 'C' ? 'checked' : ''; ?>>
                        <label for="optionC">C. </label>
                        <textarea name="optionC" id="optionC" cols="50" rows="3" required><?php echo htmlspecialchars($optionC); ?></textarea>
                    </div>
                    <div>
                        <input type="radio" name="answer" value="D" <?php echo $answer == 'D' ? 'checked' : ''; ?>>
                        <label for="optionD">D. </label>
                        <textarea name="optionD" id="optionD" cols="50" rows="3" required><?php echo htmlspecialchars($optionD); ?></textarea>
                    </div>
                </div>
                <div class="err-div"></div>
                <input type="submit" name="submitQuestion" value="Done">
            </form>
        </main>
    </div>
</body>
</html>
