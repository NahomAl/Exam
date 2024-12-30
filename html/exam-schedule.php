<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard | Korsat X Parmaga</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../css/scheduler.css">
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
                    <h2>Exam Schedule</h2>
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
                    <div id="calendar">
                    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="../js/schedule.js"></script>
</body>

</html>
