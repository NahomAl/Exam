<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam history</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/org-dashboard-style.css">
</head>
<body>
    <header>
        <h1>Examination Sytem</h1>
        <form action="exam-history.php" method="get">
            <input type="text" name="search-term" placeholder="Search exam">
            <button type="submit" class="search-button" name="search-exam-history">Search</button>
        </form>
    </header>
    
    <div class="container">
        <aside>
            <?php include("nav-links.html") ?>
        </aside>
        <main>
            <?php
                include('phpCode.php');
                $orgID = $_SESSION["orgID"];
                if (isset($_GET["search-term"])){
                    $searchTerm = strip_tags($_GET["search-term"]);
                    getExamHistory($orgID, $searchTerm);
                }
                else
                    getExamHistory($orgID, '');
            ?>
        </main>
    </div>
</body>
</html>