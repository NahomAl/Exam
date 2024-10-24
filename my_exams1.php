<?php
// Database connection parameters
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "final_project"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = 1; // Replace with session data if needed

// Query to get upcoming exams for the student
$sql = "SELECT exam_name, exam_date, status 
        FROM exams 
        WHERE student_id = $student_id AND exam_date >= CURDATE()
        ORDER BY exam_date ASC";

$result = $conn->query($sql);

// HTML table
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard - My Exams</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .content {
      padding: 20px;
      margin: 20px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #f4f4f4;
    }
  </style>
</head>
<body>

  <!-- Dashboard Content -->
  <div class="content">
    <h2>Student Dashboard - My Upcoming Exams</h2>

    <!-- Exam Table -->
    <table id="examTable">
      <thead>
        <tr>
          <th>Exam Name</th>
          <th>Exam Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <!-- Dynamically populate the table rows -->
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['exam_name'] . "</td>";
            echo "<td>" . date('m/d/Y', strtotime($row['exam_date'])) . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='3'>No upcoming exams found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
