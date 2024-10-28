
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result Report</title>
    <link rel="stylesheet" href="../css/header.css">
    <style>
        /* Basic reset and styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /*body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f9;
        }*/

        main {
            /*width: 80%;
            max-width: 1200px;*/
            /* margin: 20px; */
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Heading */
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8em;
            color: #333;
        }

        /* Container for summaryTable and canvas */
        .summary-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        /* Styling for summary table */
        .summaryTable {
            width: 45%;
            border-collapse: collapse;
        }

        .summaryTable td {
            padding: 10px;
            /*border: 1px solid #ddd;*/
            font-size: 1em;
        }

        .summaryTable tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Styling for canvas */
        canvas {
            /*width: 100%;*/
            max-width: 400px;
            max-height: 400px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 10px;
            /* box-sizing: border-box; */
        }

        /* Styling for exam table */
        #examTable {
            width: 50%;
            max-height: 100px;
            margin-top: 20px;
            overflow-y: scroll;
            border-collapse: collapse;
            text-align: left;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #examTable th, #examTable td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        #examTable thead {
            background-color: #007bff;
            color: white;
            position: sticky;
            top: 0;
        }

        #examTable tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Hover and click styling for headers */
        #examTable th {
            cursor: pointer;
            background-color: #0056b3;
            transition: background-color 0.3s;
        }

        #examTable th:hover {
            background-color: #003d80;
        }
        /*Custom scroll bar*/ 
        #examTable::-webkit-scrollbar {
            width: 8px;
        }

        #examTable::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
        }

        #examTable::-webkit-scrollbar-thumb:hover {
            background-color: #aaa;
        }

    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<header>
    <h1>Examination Sytem</h1>
</header>
<div class="container">
        <aside>
            <?php include("nav-links.html") ?>
        </aside>
        <main>
            <h1>Exam Result Report</h1>
            <div class="summary-container">
                <table class="summaryTable">
                    <tr><td>Minimum Score</td><td id="minScore"></td></tr>
                    <tr><td>Maximum Score</td><td id="maxScore"></td></tr>
                    <tr><td>Range</td><td id="range"></td></tr>
                    <tr><td>Average Score</td><td id="avgScore"></td></tr>
                </table>
                <canvas id="scoreHistogram" width="400px" height="200px"></canvas>
            </div>
            <table id="examTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Examinee name</th>
                        <th onclick="sortTable(1)">Score</th>
                    </tr>
                </thead>
                <tbody id="examBody">
                </tbody>
            </table>
            
        </main>
    </div>



    <script>
        // Fetch the exam results from PHP
        /*
        fetch('get-result.php')
            .then(response => response.json())
            .then(data => {
                // Populate the table with data
                const tableBody = document.getElementById('examBody');
                let scores = [];
                data.forEach(exam => {
                    const row = `<tr><td>${exam.Full_name}</td><td>${exam.Score}</td></tr>`;
                    tableBody.innerHTML += row;
                    //scoreSum += exam.Score;
                    scores.push(exam.Score);
                });
                createSummary(scores);
                createHistogram(scores);
            })
            .catch(error => console.error('Error fetching data:', error));
        */
        const tableBody = document.getElementById('examBody');
        let scores = [];
        for(let i = 0; i < 100; i++){
            scores.push(Math.floor(Math.random() * 11));
            const row = `<tr><td>AAA</td><td>${scores[i]}</td></tr>`;
            tableBody.innerHTML += row;
        }
        createSummary(scores);
        createHistogram(scores);


        function createSummary(scores){
            let min = Math.min(...scores);
            let max = Math.max(...scores);
            let range = max - min;
            let avg = (scores.reduce((sum, score) => sum + score)) / scores.length;
            document.getElementById('minScore').innerText = min;
            document.getElementById('maxScore').innerText = max;
            document.getElementById('range').innerText = range;
            document.getElementById('avgScore').innerText = avg;
        }

        function createHistogram(scores){
            const scoreCounts = {};
            scores.forEach(score => {
                scoreCounts[score] = (scoreCounts[score] || 0) + 1;
            });
            const uniqueScores = Object.keys(scoreCounts).map(Number).sort((a, b) => a - b);
            const frequencies = uniqueScores.map(score => scoreCounts[score]);

            // Create the histogram
            const ctx = document.getElementById('scoreHistogram').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: uniqueScores, // Scores on the horizontal axis
                    datasets: [{
                        label: 'Number of Examinees',
                        data: frequencies, // Frequency of each score on the vertical axis
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Scores'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Number of Examinees'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        
        
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