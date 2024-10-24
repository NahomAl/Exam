<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Question</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        textarea, input[type="radio"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            resize: vertical;
        }

        textarea {
            height: auto;
        }

        .options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .options div {
            width: 48%;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 15px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<?php
    require("dbConnect.php");
    
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
        <h1><?php echo isset($_GET["qID"]) ? "Edit Question" : "Add New Question"; ?></h1>
        
        <label for="question">Question</label>
        <textarea name="question" id="question" cols="100" rows="7" required><?php echo htmlspecialchars($questionText); ?></textarea>

        <div class="options">
            <div>
                <label for="optionA">A. </label>
                <textarea name="optionA" id="optionA" cols="50" rows="3" required><?php echo htmlspecialchars($optionA); ?></textarea>
                <input type="radio" name="answer" value="A" <?php echo $answer == 'A' ? 'checked' : ''; ?>> Correct Answer
            </div>
            <div>
                <label for="optionB">B. </label>
                <textarea name="optionB" id="optionB" cols="50" rows="3" required><?php echo htmlspecialchars($optionB); ?></textarea>
                <input type="radio" name="answer" value="B" <?php echo $answer == 'B' ? 'checked' : ''; ?>> Correct Answer
            </div>
        </div>

        <div class="options">
            <div>
                <label for="optionC">C. </label>
                <textarea name="optionC" id="optionC" cols="50" rows="3" required><?php echo htmlspecialchars($optionC); ?></textarea>
                <input type="radio" name="answer" value="C" <?php echo $answer == 'C' ? 'checked' : ''; ?>> Correct Answer
            </div>
            <div>
                <label for="optionD">D. </label>
                <textarea name="optionD" id="optionD" cols="50" rows="3" required><?php echo htmlspecialchars($optionD); ?></textarea>
                <input type="radio" name="answer" value="D" <?php echo $answer == 'D' ? 'checked' : ''; ?>> Correct Answer
            </div>
        </div>

        <input type="submit" name="done" value="Done">
    </form>

    <?php
        if(isset($_POST["done"])){
            $question = $_POST["question"];
            $optionA = $_POST["optionA"];
            $optionB = $_POST["optionB"];
            $optionC = $_POST["optionC"];
            $optionD = $_POST["optionD"];
            $answer = $_POST["answer"];

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
            }
            else if (isset($_GET["examID"])){
                $examID = $_GET["examID"];
                $sql = $conn -> prepare("INSERT INTO question(Exam_ID,Question_text,Option_A,Option_B,Option_C,Option_D,Correct_answer)
                                        VALUES (?, ?, ?, ?, ?, ?)");
                $sql -> bind_param("issssss", $examID, $question, $optionA, $optionB, $optionC, $optionD, $answer);
                $sql -> execute();
                $sql -> close();
            }
            $conn -> close();
        }
    ?>

    <script>
        // Optional JavaScript functionalities can be added here
        // Example: Alert if form is successfully submitted
        document.querySelector('form').onsubmit = function() {
            alert("Form submitted successfully!");
        }
    </script>
</body>
</html>
