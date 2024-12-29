<!DOCTYPE html>
<?php
    /* session_start();
    if (isset($_SESSION['examID'])){
        $examID = $_SESSION['examID'];
        $examName = $_SESSION['examName'];
        $examTime = $_SESSION['examTime'];
        $timeAllotted = $_SESSION['timeAllotted'];
    } */
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Schedule</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/scheduler.css">
</head>
<body>
    <header>
        <h1>Exam Schedule</h1>
        <div class="month-year-selector">
                <label for="month">Month:</label>
                <select name="month" id="month">
                    <option value="0">January</option>
                    <option value="1">February</option>
                    <option value="2">March</option>
                    <option value="3">April</option>
                    <option value="4">May</option>
                    <option value="5">June</option>
                    <option value="6">July</option>
                    <option value="7">August</option>
                    <option value="8">September</option>
                    <option value="9">October</option>
                    <option value="10">November</option>
                    <option value="11">December</option>
                </select>

                <label for="year">Year:</label>
                <select name="year" id="year">
                    <!-- Year options dynamically populated -->
                </select>
        </div>
    </header>
    
    <div class="container">
        <aside>
            <nav>
                <ul>
                    <li><a href="organizer-dashboard.php">Home</a></li>
                    <li><a href="create-exam.php">Create new exam</a></li>
                    <li><a href="exam-history.php">Exam History</a></li>
                    <li><a href="exam-schedule.php">Exam Schedule</a></li>
                    <li><a href="#">My account</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </nav>
        </aside>
        <main>
            <form id="set-exam-date-form" action="set-exam-date.php" method="POST">
                <!-- <input type="hidden" id="exam-id" name="exam-id" value="<?php if (isset($examID)) echo $examID; ?>">
                <input type="hidden" id="exam-time" name="exam-time">
                <input type="hidden" id="selected-date" name="selected-date" value=""> -->
                
                <div id="calendar">
                    <!-- Calendar days will be dynamically generated here -->
                </div>
                <!-- Section for more information about the selected day -->
                <div id="exam-info-section">
                    <h3>Exams on <span id="selected-date-text"></span></h3>
                    <ul id="exam-details-list"></ul>
                </div>
                <!-- <div id="time-input-div">
                    <input type="hidden" name="examID" value="<?php if (!empty($examID)) echo $examID ?>">
                    <input type="text">
                    <label for="new-exam-time">Exam Time: </label>
                    <input type="datetime-local" id="new-exam-time" required value="<?php if (!empty($examTime)) echo $examTime ?>">
                    <label for="time-allotted">Time Allotted: </label>
                    <input type="time" id="time-allotted" required value="<?php if (!empty($timeAllotted)) echo $timeAllotted ?>">
                    <button id="save-exam-date">Save Exam Date/Time</button>
                    <div id="error-message" style="color:red;"></div>
                </div> -->
                <!--
                <div id="save-date-section">
                    <input type="hidden" id="exam-id" value="">
                    <input type="hidden" id="selected-date" value="">
                </div>
                -->
                <!-- <div id="save-date-section" style="display: none;">
                    <button type="submit">Save Exam Date</button>
                </div> -->
            </form>
        </main>
    </div>


    <script src="../js/schedule.js"></script>
</body>
</html>
