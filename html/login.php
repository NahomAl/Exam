<?php
    session_start();
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="../css/header.css">
    <style>
        #form-container {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 70px);
        }
        .login-form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-form label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
        }
        .login-form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 12px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Website Title</h1>
    </header>
    <?php
        if (isset($_POST["login"])){
            include_once "dbConnect.php";
            $user = $_POST["usr"];
            $pwd = $_POST["pwd"];
            $result = mysqli_query($conn, "SELECT * FROM user WHERE username='$user' AND password='$pwd'");
            if (mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                $userID = $row["user_ID"];
                if ($row["role"] == 'organizer'){
                    $result = mysqli_query($conn, "SELECT Organizer_ID FROM organizer WHERE user_ID = $userID");
                    $data = mysqli_fetch_assoc($result);
                    $_SESSION["orgID"] = $data["Organizer_ID"];
                    //Header("Location: ./organizer-dashboard.php");
                    Header("Location: ./Org-dash.php");
                }
                else{
                    $result = mysqli_query($conn, "SELECT Examinee_ID, Organizer_ID FROM Examinee WHERE user_ID = $userID");
                    $data = mysqli_fetch_assoc($result);
                    $_SESSION["orgID"] = $data["Organizer_ID"];
                    $_SESSION["employeeID"] = $data["Employee_ID"];
                    Header("Location: ./Org-dash copy.php");
                }
                //echo "welcome";
            }
        }
    ?>
    <div id="form-container">
        <div class="login-form">
            <form action="login.php" method="post">
                <label for="usr">Username</label>
                <input type="text" name="usr" id="usr" required>
                <label for="pwd">Password</label>
                <input type="password" name="pwd" id="pwd" required>
                <span id="passwordError" class="error">
                    <?php 
                        if (isset($result) && mysqli_num_rows($result) == 0)
                            echo "Incorrect username or password";
                    ?>
                </span>

                <input type="submit" name="login" value="Log-in">
            </form>
        </div>
    </div>
</body>
</html>
