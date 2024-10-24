<?php
    
    if (isset($_POST["register"])){
        include_once "dbConnect.php";
        $isAllValid = true;
        $regex = "/^[A-Z][\w-_ ]*$/i";
        $regexPassword = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,20}$/";
        $orgName = $_POST['org-name'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $industry = $_POST['industry'];
        $username = $_POST['username'];
        $pass1 = $_POST['password'];
        $pass2 = $_POST['password2'];
        if (!preg_match($regex, $orgName)){
            echo "Invalid organization name<br>";
            $isAllValid = false;
        }
        if (!preg_match($regex, $country)){
            echo "Invalid country input<br>";
            $isAllValid = false;
        }
        if (!preg_match($regex, $city)){
            echo "Invalid city input<br>";
            $isAllValid = false;
        }
        if (!preg_match($regexPassword, $pass1)){
            echo    "password should contain atleast one uppercase character, one lowecase character,
                    one symbol among @$!%*?& and should be between 6-20 characters long<br>";
            $isAllValid = false;
        }
        if ($pass1 != $pass2){
            echo "Passwords don't match<br>";
            $isAllValid = false;
        }
        
        $sql = "SELECT COUNT(*) AS count FROM user WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        if (!$result){
            echo "Problem connecting to database. Please try again";
            die();
        }
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] > 0){
            echo "username taken. choose a different username<br>";
            $isAllValid = false;
        }
        //$sql = "SELECT * FROM organizer WHERE email = '';
        //$sql = "INSERT INTO `user` (`username`, `password`, `role`) VALUES ('$username', '$pass1', 'organizer')";
        //$sql = "INSERT INTO `organizer` (`Organizer name`, `Email`, `Exam count`, `Industry`, `user ID`, `Address ID`) VALUES (NULL, '', '', '', '', '', '')";

        if ($isAllValid){
            $userID = insertUser($conn, $username, $pass1);
            $addressID = insertAddress($conn, $country, $city);
            if (!empty($userID) && !empty($addressID)){
                $orgID = insertOrganizer($conn, $orgName, $email, $industry, $userID, $addressID);
                $_SESSION["orgID"] = $orgID;
                Header("Location: ./organizer-dashboard.php");
            }
        }
    }
    function insertUser($conn, $usr, $pass){
        $sqlStr = "INSERT INTO `user` (`username`, `password`, `role`) VALUES ('$usr', '$pass', 'organizer')";
        if (!mysqli_query($conn, $sqlStr)){
            echo "user insert error";
            return null;
        }
        return mysqli_insert_id($conn);
    }
    function insertAddress($conn, $country, $city){
        $result = mysqli_query($conn, "SELECT Address_ID FROM address WHERE country = '$country' AND city = '$city'");
        if (mysqli_num_rows($result) > 0){
            return mysqli_fetch_assoc($result)["Address_ID"];
        }
        else{
            $sqlStr = "INSERT INTO `address` (`city`, `country`) VALUES ('$city', '$country')";
            if (!mysqli_query($conn, $sqlStr)){
                echo "address insert error";
                return null;
            }
            return mysqli_insert_id($conn);
        }
    }
    function insertOrganizer($conn, $orgName, $email, $industry, $userID, $addressID){
        $sqlStr = "INSERT INTO `organizer` (`Organizer_ID`, `Organizer_name`, `Email`, `Exam_count`, `Industry`, `user_ID`, `address_ID`)
                     VALUES (NULL, '$orgName', '$email', 0, '$industry', $userID, $addressID)";
        if (!mysqli_query($conn, $sqlStr)){
            echo "Organizer insert error";
            return null;
        }
        return mysqli_insert_id($conn);
    }

?>