

<?php
  session_start();
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
          <th>Student Id</th>
          <th>Exam Name</th>
          <th>Exam Date</th>
          <!-- <th>Status</th> -->
        </tr>
      </thead>
      <tbody>
        <!-- Dynamically populate the table rows -->
       <!-- <?php if (!empty($examsData)): ?>
          <?php foreach ($examsData as $row): ?>
            <tr>
              <td><?php echo $row['student_id']; ?></td>
              <td><?php echo $row['exam_name']; ?></td>  Remove the space issue --
              <td><?php echo date('m/d/Y', strtotime($row['exam_date'])); ?></td> !-- Format date --
              <td><?php echo $row['status']; ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4">No upcoming exams found.</td>
          </tr>
        <?php endif; ?>-->
      </tbody>
    </table>
  </div>

  <script>
    // Fetch data from the PHP backend and render it in the table
    function fetchExamData() {
  fetch('EXAM/my_exams1.php') // Adjust path if necessary
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      const tableBody = document.querySelector('#examTable tbody');
      tableBody.innerHTML = ''; // Clear the table body

      if (data.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="4">No upcoming exams found.</td></tr>';
        return;
      }

      // Populate the table
      data.forEach(exam => {
        const row = `<tr>
                      <td>${exam.student_id}</td>
                      <td>${exam.exam_name}</td>
                      <td>${new Date(exam.exam_date).toLocaleDateString()}</td>
                      // <td>${exam.status}</td>
                    </tr>`;
        tableBody.innerHTML += row;
      });
    })
    .catch(error => {
      console.error('Error fetching exam data:', error);
      document.querySelector('#examTable tbody').innerHTML = '<tr><td colspan="4">Error loading exams.</td></tr>';
    });
}

// Call the function to fetch and display the exam data
fetchExamData();


  </script>

</body>
</html>
