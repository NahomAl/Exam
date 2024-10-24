
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="examinee-apply-exam.php" method="post">
        <input type="search" name="exam-name" id="exam-name" placeholder="Exam name">
        <input type="submit" name="search" value="Search">
    </form>
    <ul class="exam-list">
        
    </ul>
    <?php
        include_once 'dbConnect.php';
        if (isset($_POST["search"])){
            $key = $_POST["exam-name"];
            $sql = "SELECT exam name from exam WHERE exam name like '%$key%'";
            //echo $sql;
        }
        
        
    ?>

</body>
</html>