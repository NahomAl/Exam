<?php
    session_start();
    require_once 'dbConnect.php';
    if (!isset($_SESSION['orgID'])) {
        die('Organizer ID not provided.');
    }
    $orgID = $_SESSION['orgID'];

    $query = "SELECT * FROM organizer WHERE Organizer_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $orgID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die('No organizer found with the provided ID.');
    }

    $org = $result->fetch_assoc();
    $stmt->close();
    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $org['user_ID']);
    $stmt->execute();
    $result = $stmt->get_result();
    $usr = $result->fetch_assoc();
    $stmt->close();

    /* $_SESSION['examTime'] = $exam['Time_of_exam'];
    $_SESSION['timeAllotted'] = $exam['Time_allotted']; */

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
            <form action="form-handler.php" method="post">
                <label for="org-name">Organizer name:</label>
                <input type="text" id="org-name" name="org-name" value="<?php echo htmlspecialchars($org['Organizer_name']); ?>" required>
                <label for="org-email">E-mail:</label>
                <input type="email" id="org-email" name="org-email" value="<?php echo htmlspecialchars($org['Email']); ?>" required>
                <label for="industry">Industry</label>
                <select name="industry">
                    <option value="none" selected disabled>Select an industry</option>
                    <option value="education" <?php echo ($org['Industry'] == 'Education') ? 'selected' : ''; ?>>Education</option>
                    <option value="corp-training" <?php echo ($org['Industry'] == 'corp-training') ? 'selected' : ''; ?>>Corporate training</option>
                    <option value="certification" <?php echo ($org['Industry'] == 'certification') ? 'selected' : ''; ?>>Certification</option>
                    <option value="other" <?php echo ($org['Industry'] == 'other') ? 'selected' : ''; ?>>Other</option>
                </select>
                <label for="user-name">User name:</label>
                <input type="text" id="user-name" name="user-name" value="<?php echo htmlspecialchars($usr['user']); ?>" required>
                
                <label for="time-allotted">Time Allotted (hours:minutes):</label>
                <input type="time" id="time-allotted" name="time_allotted" value="<?php echo htmlspecialchars($exam['Time_allotted']); ?>" required>

                <label for="time-of-exam">Time of Exam:</label>
                <input type="datetime-local" id="time-of-exam" name="time_of_exam" value="<?php echo htmlspecialchars($exam['Time_of_exam']); ?>" required>
                <!--<a class="schedule-link" href="exam-schedule.php">Schedule Exam</a>-->
                <!--<button class="schedule-link" type="submit" name="setExamSchedule">Schedule Exam</button>-->
                <label for="number-of-examinees">Number of Examinees:</label>
                <input type="number" id="number-of-examinees" name="number_of_examinees" min="1" disabled value="<?php echo htmlspecialchars($exam['Number_of_examinees']); ?>" required>

                <button type="submit" name="submitExam">Update Exam</button>
            </form>
        </main>
    </div>
</body>
</html>
