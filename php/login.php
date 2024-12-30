<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../html/dbConnect.php";
    $user = $_POST["username"];
    $pwd = $_POST["password"];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username='$user' AND password='$pwd'");
    if (mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $userID = $row["user_ID"];
        if ($row["role"] == 'organizer'){
            $result = mysqli_query($conn, "SELECT Organizer_ID FROM organizer WHERE user_ID = $userID");
            $data = mysqli_fetch_assoc($result);
            $_SESSION["orgID"] = $data["Organizer_ID"];
            Header("Location: ../html/Org-dash.php");
        }
        else{
            $result = mysqli_query($conn, "SELECT Examinee_ID, Organizer_ID FROM Examinee WHERE user_ID = $userID");
            $data = mysqli_fetch_assoc($result);
            $_SESSION["Org_ID"] = $data["Organizer_ID"];
            $_SESSION["Examinee_ID"] = $data["Employee_ID"];
            Header("Location: ../exams-to-take.php");
        }
    }
}
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape username input
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; 

    // Prepare the SQL statement
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Database query failed: " . $conn->error);
    }

    // Bind and execute the statement
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if the password matches (since passwords are stored as plain text)
        if ($password === $user['password']) {
            $role = $user['role'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
           $_SESSION['user_id'] = $user['id'];
            echo "User ID is: " . $_SESSION['user_id']; // For debugging
            header("Location: questions.php");
            exit(); // Always exit after a header redirect
        } else {
            echo "Invalid username or password"; // Password does not match
        }
    } else {
        echo "Invalid username or password"; // User not found
    }

    $stmt->close();
}


$conn->close();
*/
?>
