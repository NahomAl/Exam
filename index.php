<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examination System</title>
    <link rel="stylesheet" href="css/questions_styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .homepage-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .button-container {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1.1rem;
            color: white;
            background-color: #2841a7;
            border-radius: 5px;
            text-decoration: none;
        }

        .button:hover {
            background-color: #4846cc;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="homepage-container">
        <h1>Welcome to the Examination System</h1>
        <p>Please log in to take your exams or manage the exam system based on your role.</p>
        <div class="button-container">
            <a href="templates/login.html" class="button">Login</a>
            <a href="templates/register.html" class="button">Register</a>
        </div>

        <div class="footer">
            <p>&copy; 2024 Examination System. All Rights Reserved.</p>
        </div>
    </div>
</body>

</html>
