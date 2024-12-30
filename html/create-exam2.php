<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard | Korsat X Parmaga</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../css/create-exam.css">
</head>

<body>
    </body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
        <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="logo-apple"></ion-icon>
                        </span>
                        <span class="title">Examino</span>
                    </a>
                </li>

                <li>
                    <a href="Org-dash.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="create-exam2.php">
                        <span class="icon">
                            <ion-icon name="create-outline"></ion-icon>
                        </span>
                        <span class="title">Create Exam</span>
                    </a>
                </li>

                <li>
                    <a href="exam-history2.php">
                        <span class="icon">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">Exam History</span>
                    </a>
                </li>
                <li>
                    <a href="exam-schedule.php">
                        <span class="icon">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </span>
                        <span class="title">Exam Schedule</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                

                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>

            <div class="details">
                <div class="recentOrders">
                    <h2>Create a new exam</h2>
                    <form action="form-handler.php" method="post" name="create-exam-form" class="create-exam-form">
                        <label for="exam-name">Exam name: </label>
                        <input type="text" name="exam-name" id="exam-name" required><br>
                        <label for="exam-type">Exam type: </label>
                        <select name="exam-type" id="exam-type" required>
                            <option value="none" selected disabled>Select exam type</option>
                            <option value="Academic assessment">Academic Assessment</option>
                            <option value="Certification Exam">Certification Exam</option>
                            <option value="Training Assessment">Training Assessment</option>
                            <option value="Licensing Exam">Licensing Exam</option>
                            <option value="Other">Other</option>
                        </select><br>
                        <label for="time-allotted">Time Allotted (hours:minutes):</label>
                        <input type="time" id="time-allotted" name="time_allotted" required>

                        <label for="time-of-exam">Time of Exam:</label>
                        <input type="datetime-local" id="time-of-exam" name="time_of_exam" required>
                        <input type="submit" name="create-exam" value="Create Exam">
                        <div class="err-div"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>