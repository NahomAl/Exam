
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result Report</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Exam Result Report</h1>
    <table id="examTable">
        <thead>
            <tr>
                <th onclick="sortTable(0)">Examinee ID</th>
                <th onclick="sortTable(1)">Score</th>
            </tr>
        </thead>
        <tbody id="examBody">
        </tbody>
    </table>

    <script>
        // Fetch the exam results from PHP
        fetch('exam_result_report.php')
            .then(response => response.json())
            .then(data => {
                // Populate the table with data
                const tableBody = document.getElementById('examBody');
                data.forEach(exam => {
                    const row = `<tr><td>${exam.examinee_ID}</td><td>${exam.score}</td></tr>`;
                    tableBody.innerHTML += row;
                });
            })
            .catch(error => console.error('Error fetching data:', error));

        // Function to sort the table
        function sortTable(columnIndex) {
            const table = document.getElementById("examTable");
            let rows = Array.from(table.rows).slice(1);  // Skip the header row

            const direction = table.getAttribute("data-sort-direction") === "asc" ? "desc" : "asc";
            table.setAttribute("data-sort-direction", direction);

            rows.sort((a, b) => {
                const cellA = a.cells[columnIndex].innerText;
                const cellB = b.cells[columnIndex].innerText;

                // If sorting by scores (column 1), compare as numbers
                if (columnIndex === 1) {
                    return direction === "asc" ? cellA - cellB : cellB - cellA;
                }
                // Otherwise, compare as strings (for column 0 - Examinee ID)
                return direction === "asc" ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
            });

            // Re-attach the sorted rows
            rows.forEach(row => table.tBodies[0].appendChild(row));
        }
    </script>
</body>
</html>