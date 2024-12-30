document.addEventListener('DOMContentLoaded', () => {
    const monthSelect = document.getElementById('month');
    const yearSelect = document.getElementById('year');
    const calendar = document.getElementById('calendar');
    //const selectedDateInput = document.getElementById('selected-date');
    //const saveDateSection = document.getElementById('save-date-section');
    //const examInfoSection = document.getElementById('exam-info-section');
    const examDetailsList = document.getElementById('exam-details-list');
    //const examIdInput = document.getElementById('exam-id');
    //const timeInputDiv = document.getElementById('time-input-div');
    const selectedDateText = document.getElementById('selected-date-text');
    //const newExamTimeInput = document.getElementById('new-exam-time');
    //const timeAllottedInput = document.getElementById('time-allotted');
    //const errorMessage = document.getElementById('error-message');
    //const saveExamDateButton = document.getElementById('save-exam-date');
    //const monthYearForm = document.getElementById('month-year-form');

    /*monthYearForm.addEventListener('submit', ()=>{
        generateDays(parseInt(monthSelect.value), parseInt(yearSelect.value));
    })*/
    // Function to populate the year dropdown
    const populateYears = () => {
        const currentYear = new Date().getFullYear();
        for (let i = currentYear; i <= currentYear + 5; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            yearSelect.appendChild(option);
        }
        yearSelect.value = currentYear; // Default to current year
    };
    // Function to check for overlapping times
    /* function isOverlapping(existingExams, newTime, timeAllotted) {
        const newExamStart = new Date(`1970-01-01T${newTime}:00`);
        const newExamEnd = new Date(newExamStart.getTime() + timeAllotted * 60000);

        for (const exam of existingExams) {
            const [startHour, startMinute] = exam.time_of_exam.split(':');
            const existingExamStart = new Date(1970, 0, 1, startHour, startMinute);
            const existingExamEnd = new Date(existingExamStart.getTime() + exam.time_allotted * 60000);

            if (newExamStart < existingExamEnd && newExamEnd > existingExamStart) {
                return true; // Overlap detected
            }
        }
        return false;
    }; */
    
    function fetchExams(month, year) {
        fetch(`fetch_exams.php?month=${month}&year=${year}`)
            .then(response => response.json())
            .then(data => {
                generateDays(month, year, data);
            })
            .catch(error => console.error('Error fetching exams:-', error));
    }

    function generateDays(month, year, exams) {
        calendar.innerHTML = '';
        const daysInMonth = new Date(year, month, 0).getDate();
        //const monthHeading = document.createElement('h3');
        //monthHeading.textContent = new Date(year, month - 1, 1);
        //console.log(new Date(1, monthSelect.value, 2024));
        //calendar.appendChild(monthHeading);
        for (let day = 1; day <= daysInMonth; day++) {
            const currentDate = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const dayExams = exams.filter((exam) => (exam.Time_of_exam.split(' ')[0] === currentDate));
            if (exams.length === 0){
                const noExams = document.createElement('h2');
                noExams.textContent = "No exams in this month";
                calendar.appendChild(noExams);
                return;
            }

            
            /* 
            examsDiv = document.createElement('div');
            dayDiv.appendChild(examsDiv);
            examsDiv.style.border = '1px solid black'; */
            /* examsDiv.style.height = '100%';
            examsDiv.style.width = '100%';
            examsDiv.style.display = 'inline-block'; */
            if (dayExams.length > 0) {
                
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('day');
    
                const dateHeading = document.createElement('h3');
                dateHeading.textContent = day; //${monthSelect.options[month-1].text}`;
                dayDiv.appendChild(dateHeading);
                dateHeading.style.marginRight = '20px';
                
                
                const examCount = document.createElement('div');
                examCount.className = 'exam-count';
                examCount.textContent = `${dayExams.length} exam${dayExams.length > 1 ? 's' : ''}`;
                
                //examCount.textContent = `and ${(dayExams.length - 2)}` + ' other exam(s)';
                const examList = document.createElement('ul');
                examList.style.listStyle = 'none';

                dayExams.forEach((exam,i) => {
                    const examItem = document.createElement('div');
                    let start = exam.Time_of_exam.split(' ')[1];
                    let end = exam.End_of_exam.split(' ')[1];
                    examItem.textContent = `${exam.Exam_name}     (${start} - ${end})`; //at ${exam.Time_of_exam} (Allotted: ${exam.Time_allotted} min)`;
                    examList.appendChild(examItem);
                    examItem.style.marginTop = '15px';
                    /* examItem.style.marginBottom = '15px';
                    examItem.style.borderBottom = '1px solid #ccc'; */
                });
                dayDiv.appendChild(examCount);
                dayDiv.appendChild(examList);
                /* if ( dayExams.length > 2)
                    dayDiv.appendChild(examCount); */
                // Allow clicking on a day to show more details
                dayDiv.classList.add('clickable-day');
                dayDiv.addEventListener('click', () => {
                    selectedDateInput.value = currentDate;
                    selectedDateText.textContent = currentDate;
                    examInfoSection.style.display = 'block';
                    errorMessage.textContent = ''; // Clear previous errors
                    examInfoSection.scrollIntoView({behavior : 'smooth'});

                    // Populate the exam details for the selected day
                    examDetailsList.innerHTML = '';
                    
                    dayExams.forEach(exam => {
                        const li = document.createElement('li');
                        //const tbl = document.createElement('table');
                        
                        let start = exam.Time_of_exam.split(' ')[1];
                        let end = exam.End_of_exam.split(' ')[1];
                        li.textContent = `${exam.Exam_name}  ${start} - ${end}`;
                        examDetailsList.appendChild(li);
                    });
                });
                calendar.appendChild(dayDiv);
            }
        }
    }
    monthSelect.addEventListener('change', () => {
        fetchExams(parseInt(monthSelect.value)+1, parseInt(yearSelect.value));
    });

    yearSelect.addEventListener('change', () => {
        fetchExams(parseInt(monthSelect.value)+1, parseInt(yearSelect.value));
    });

    /* saveExamDateButton.addEventListener('click', () => {
        const selectedDate = selectedDateInput.value;
        const newTime = newExamTimeInput.value;
        const timeAllotted = parseInt(timeAllottedInput.value, 10);
        const dayExams = exams.filter(exam => exam.exam_date === selectedDate);

        if (!newTime || !timeAllotted) {
            errorMessage.textContent = 'Please enter a valid time and duration.';
            return;
        }

        // Check for overlap with existing exams
        if (isOverlapping(dayExams, newTime, timeAllotted)) {
            errorMessage.textContent = 'The new exam time overlaps with an existing exam.';
            return;
        }

        // If no overlap, submit the form 
        console.log(`Exam scheduled on ${selectedDate} at ${newTime} for ${timeAllotted} minutes.`);
    }); */



    
    populateYears();
    monthSelect.value = new Date().getMonth();
    /* if (examIdInput.value === ''){
        timeInputDiv.style.display = 'none';
    } */
    fetchExams(new Date().getMonth()+1, new Date().getFullYear());
});