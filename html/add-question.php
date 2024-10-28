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
    <style>
        /*body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }*/
        form {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
        }

        /* Form header styling */
        .page-title {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Label styling */
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #555;
        }

        /* Styling for textarea input */
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: none;
            font-size: 16px;
            color: #333;
        }

        /* Styling for options section */
        .options {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 15px;
        }

        /* Individual option styling */
        .options div {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .options textarea {
            flex: 1;
            font-size: 16px;
        }

        /* Radio button styling */
        input[type="radio"] {
            transform: scale(1.2);
            margin-right: 10px;
        }

        /* Submit button styling */
        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Mobile-friendly adjustments */
        @media (max-width: 600px) {
            form {
                width: 95%;
            }
        }
        /*form {
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
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .options div {
            
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
        }*/
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
    <header>
        <h1>Examination Sytem</h1>
    </header>
    <div class="container">
        <aside>
            <?php include("nav-links.html") ?>
        </aside>
        <main>
            <form action="form-handler.php" method="post" name="question-form">
                <h1 class="page-title"><?php echo isset($_GET["qID"]) ? "Edit Question" : "Add New Question"; ?></h1>
                
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
                <input type="submit" name="addQuestion" value="Done">
            </form>
        </main>
    </div>

    <?php
        if(isset($_POST["done"])){
            $question = htmlspecialchars($_POST["question"]);
            $optionA = htmlspecialchars($_POST["optionA"]);
            $optionB = htmlspecialchars($_POST["optionB"]);
            $optionC = htmlspecialchars($_POST["optionC"]);
            $optionD = htmlspecialchars($_POST["optionD"]);
            $answer = htmlspecialchars($_POST["answer"]);

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
            else
                echo "<h2>Problem</h2>";
            $conn -> close();
            //Header("Location: exam-question.php");
        }
    ?>
    <script>
        /* let form = document.forms['question-form'];
        form.addEventListener('submit', () => validateForm());
        function validateForm(){
            let errDiv = document.querySelector('.err-div');
            errDiv.innerText = '';
            
            if (!regex.test(examName.value))
                errDiv.innerText += 'Invalid Exam name\n';
            if (examType.value === 'none')
                errDiv.innerText += 'Exam type not selected\n';
            if(errDiv.innerText !== '')
                e.preventDefault(); */
        
    </script>
</body>
</html>
