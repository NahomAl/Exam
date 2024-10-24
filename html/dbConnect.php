<?php
    $host = "localhost";
    $db = 'examination_sytem_db';
    $user = 'root';
    $pass = '';

    $conn = mysqli_connect($host, $user, $pass, $db);
    if (!$conn)
        echo "Database connection failed"

?>