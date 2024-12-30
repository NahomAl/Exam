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
    const row = `<tr><td>ABC${i}</td><td>${scores[i]}</td></tr>`;
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

    
    const ctx = document.getElementById('scoreHistogram').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: uniqueScores,
            datasets: [{
                label: 'Number of Examinees',
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


function sortTable(columnIndex) {
    const table = document.getElementById("examTable");

    const direction = table.getAttribute("data-sort-direction") === "asc" ? "desc" : "asc";
    table.setAttribute("data-sort-direction", direction);

    rows.sort((a, b) => {
        const cellA = a.cells[columnIndex].innerText;
        const cellB = b.cells[columnIndex].innerText;

        // If sorting by scores, compare as numbers
        if (columnIndex === 1) {
            return direction === "asc" ? cellA - cellB : cellB - cellA;
        }
        return direction === "asc" ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
    });

    rows.forEach(row => table.tBodies[0].appendChild(row));
}