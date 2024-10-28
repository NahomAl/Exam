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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Exam</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/exam-editor.css">
</head>
<body>
    <header>
        <h1>Examination Sytem</h1>
    </header>
    <div class="container">
        <aside>
            <?php include("nav-links.html") ?>
        </aside>   
        <main>
            <form id="edit-exam-form" action="form-handler.php" method="post">
                <h2 class="exam-name"><?php echo $_SESSION['examID'] . " - " . $_SESSION['examName'] ?></h2>
                <label for="exam-name">Exam Name:</label>
                <input type="text" id="exam-name" name="exam_name" value="<?php echo htmlspecialchars($exam['Exam_name']); ?>" required>
                <label for="exam-type">Exam Type:</label>
                <select id="exam-type" name="exam_type" required>
                    <option value="none" disabled>Select Exam Type</option>
                    <option value="Academic assessment" <?php echo ($exam['Exam_type'] == 'Academic assessment') ? 'selected' : ''; ?>>Academic assessment</option>
                    <option value="Certification exam" <?php echo ($exam['Exam_type'] == 'Certification exam') ? 'selected' : ''; ?>>Certification exam</option>
                    <option value="Training assessment" <?php echo ($exam['Exam_type'] == 'Training assessment') ? 'selected' : ''; ?>>Training assessment</option>
                    <option value="Licensing exam" <?php echo ($exam['Exam_type'] == 'Licensing exam') ? 'selected' : ''; ?>>Licensing exam</option>
                    <option value="Other" <?php echo ($exam['Exam_type'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>

                <label for="number-of-questions">Number of Questions:</label>
                <input type="number" id="number-of-questions" name="number_of_questions" min="1" value="<?php echo htmlspecialchars($exam['Number_of_questions']); ?>" required>

                <label for="time-allotted">Time Allotted (hours:minutes):</label>
                <input type="time" id="time-allotted" name="time_allotted" disabled value="<?php echo htmlspecialchars($exam['Time_allotted']); ?>" required>

                <label for="time-of-exam">Time of Exam:</label>
                <input type="datetime-local" id="time-of-exam" name="time_of_exam" disabled value="<?php echo htmlspecialchars($exam['Time_of_exam']); ?>" required>
                <a class="schedule-link" href="exam-schedule.php">Schedule Exam</a>

                <label for="number-of-examinees">Number of Examinees:</label>
                <input type="number" id="number-of-examinees" name="number_of_examinees" min="1" disabled value="<?php echo htmlspecialchars($exam['Number_of_examinees']); ?>" required>

                <button type="submit" name="submitExam">Update Exam</button>
            </form>
        </main>
    </div>
</body>
</html>
