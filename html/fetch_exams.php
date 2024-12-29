<?php
    require_once "dbConnect.php";
    // Get month and year from request
    $month = isset($_GET['month']) ? intval($_GET['month']) : null;// date('m');
    $year = isset($_GET['year']) ? intval($_GET['year']) : null;// date('Y');
    // Prepare and execute the SQL query to fetch exams for the selected month and year
    $result = mysqli_query($conn, "SELECT *, ADDTIME(Time_of_exam,Time_allotted) as End_of_exam FROM exam WHERE MONTH(Time_of_exam) = $month AND YEAR(Time_of_exam) = $year ORDER BY Time_of_exam");

    $exams = mysqli_fetch_all($result, MYSQLI_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($exams);

    //$query->execute(['month' => $month, 'year' => $year]);

    // Fetch all exams as an associative array
    //$exams = $query->fetchAll(PDO::FETCH_ASSOC);

    // Return exams as a JSON response
?>