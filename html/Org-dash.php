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
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../css/org-dashboard-style.css">
</head>

<body>
    </body>
    <?php 
        require("phpCode.php");
    ?>
    <div class="container">
        <!-- <div class="navigation">
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
        </div> -->
        <?php include("nav-links.html"); ?>

        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <form action="Org-dash.php" method="get">
                        <label>
                            <input type="text" name="keyword" placeholder="Search exam">
                            <ion-icon name="search-outline"></ion-icon>
                        </label>
                    </form>
                </div>

                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers">3</div>
                        <div class="cardName">Upcoming Exams</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="numbers">1,504</div>
                        <div class="cardName">Examinees</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">80</div>
                        <div class="cardName">Exams given</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Upcoming Exams</h2>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Name</td>
                                <td>Type</td>
                                <td>Date/Time</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $orgID = $_SESSION["orgID"];
                                if (isset($_GET["keyword"])){
                                    displayExam($orgID, $_GET["keyword"]);
                                }
                                else
                                    displayExam($orgID, '');
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>