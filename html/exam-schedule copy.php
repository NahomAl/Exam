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
                
                <div id="calendar">
                    
                </div>
            </form>
        </main>
    </div>


    <script src="../js/schedule.js"></script>
</body>
</html>
