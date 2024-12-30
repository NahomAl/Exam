
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result Report</title>
    <link rel="stylesheet" href="../css/exam-result.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
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
                <div class="wrapper">
                    <h1>Exam Result Report</h1>
                    <div class="summary-container">
                        <table class="summaryTable">
                        <tr><td>Minimum Score</td><td id="minScore"></td></tr>
                        <tr><td>Maximum Score</td><td id="maxScore"></td></tr>
                        <tr><td>Range</td><td id="range"></td></tr>
                        <tr><td>Average Score</td><td id="avgScore"></td></tr>
                        </table>
                        <canvas id="scoreHistogram" width="400px" height="200px"></canvas>
                    </div>
                    <table id="examTable">
                    <thead>
                    <tr>
                        <th onclick="sortTable(0)">Examinee name</th>
                        <th onclick="sortTable(1)">Score</th>
                    </tr>
                    </thead>
                    <tbody id="examBody">
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="assets/js/main.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="../js/exam-result.js"></script>
</body>
</html>