<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // Don't hash the password
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address_id = $_POST['address_id'];

    // Prepare the SQL statement to prevent SQL injection for users table
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'examinee')");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id; // Get the last inserted user ID

        // Prepare the SQL statement for the examinees table
        $stmt_examinee = $conn->prepare("INSERT INTO examinee (user_id, first_name, last_name, age, gender, address_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt_examinee->bind_param("issisi", $user_id, $first_name, $last_name, $age, $gender, $address_id);

        if ($stmt_examinee->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt_examinee->error;
        }

        $stmt_examinee->close();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
