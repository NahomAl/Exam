document.addEventListener('DOMContentLoaded', () => {
    const monthSelect = document.getElementById('month');
    const yearSelect = document.getElementById('year');
    const calendar = document.getElementById('calendar');
    const selectedDateInput = document.getElementById('selected-date');
    //const saveDateSection = document.getElementById('save-date-section');
    const examInfoSection = document.getElementById('exam-info-section');
    const examDetailsList = document.getElementById('exam-details-list');
    const examIdInput = document.getElementById('exam-id');
    const timeInputDiv = document.getElementById('time-input-div');
    const selectedDateText = document.getElementById('selected-date-text');
    const newExamTimeInput = document.getElementById('new-exam-time');
    const timeAllottedInput = document.getElementById('time-allotted');
    const errorMessage = document.getElementById('error-message');
    const saveExamDateButton = document.getElementById('save-exam-date');
    const monthYearForm = document.getElementById('month-year-form');

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
    const isOverlapping = (existingExams, newTime, timeAllotted) => {
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
    };
    
    const fetchExams = (month, year) => {
        // Send an AJAX request to fetch exams from the PHP endpoint
        fetch(`fetch_exams.php?month=${month}&year=${year}`)
            .then(response => response.json())
            .then(data => {
                // Update the calendar with the fetched exams

                generateDays(month, year, data);
            })
            .catch(error => console.error('Error fetching exams:', error));
    };

    const clearCalendar = () => {
        calendar.innerHTML = '';
    };

    const generateDays = (month, year, exams) => {
        clearCalendar();
        const daysInMonth = new Date(year, month, 0).getDate();
        //console.log(`Len: ${exams.length}`);
        //const monthHeading = document.createElement('h3');
        //monthHeading.textContent = monthSelect.options[month-1].text;
        //calendar.appendChild(monthHeading);
        for (let day = 1; day <= daysInMonth; day++) {
            const dayDiv = document.createElement('div');
            dayDiv.classList.add('day');

            const dateHeading = document.createElement('h3');
            dateHeading.textContent = day //${monthSelect.options[month-1].text}`;
            dayDiv.appendChild(dateHeading);

            const currentDate = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const dayExams = exams.filter((exam) => (exam.Time_of_exam.split(' ')[0] === currentDate));
            
            if (dayExams.length > 0) {
                const examCount = document.createElement('span');
                examCount.className = 'exam-count';
                examCount.textContent = `and ${(dayExams.length - 2)}` + ' other exam(s)';
                const examList = document.createElement('ul');
                dayExams.forEach((exam,i) => {
                    if (i < 2){
                        const examItem = document.createElement('li');
                        examItem.textContent = exam.Exam_name; //at ${exam.Time_of_exam} (Allotted: ${exam.Time_allotted} min)`;
                        examList.appendChild(examItem);
                    }
                });
                dayDiv.appendChild(examList);
                if ( dayExams.length > 2)
                    dayDiv.appendChild(examCount);
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
                        li.textContent = `${exam.Exam_name} starts at ${exam.Time_of_exam} ends at ${exam.End_of_exam}`;
                        examDetailsList.appendChild(li);
                    });
                });
            }
            calendar.appendChild(dayDiv);
        }
    };


    // Function to generate days of the month with exams
    /*
    const generateDays2 = (month, year, exams, examId = null) => {
        clearCalendar();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        for (let day = 1; day <= daysInMonth; day++) {
            const dayDiv = document.createElement('div');
            dayDiv.classList.add('day');

            const dateHeading = document.createElement('h3');
            dateHeading.textContent = `${day}`; //${monthSelect.options[month].text}
            dayDiv.appendChild(dateHeading);

            const currentDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const dayExams = exams.filter(exam => exam.exam_date === currentDate);

            if (dayExams.length > 0) {
                const examList = document.createElement('ul');
                dayExams.forEach(exam => {
                    const examItem = document.createElement('li');
                    examItem.textContent = exam.exam_name; //`${exam.exam_name} at ${exam.time_of_exam} (Allotted: ${exam.time_allotted} min)`;
                    examList.appendChild(examItem);
                });
                dayDiv.appendChild(examList);
            }

            // Allow clicking on a day to show more details
            if (examId) {
                dayDiv.classList.add('clickable-day');
                dayDiv.addEventListener('click', () => {
                    selectedDateInput.value = currentDate;
                    selectedDateText.textContent = currentDate;
                    examInfoSection.style.display = 'block';
                    errorMessage.textContent = ''; // Clear previous errors

                    // Populate the exam details for the selected day
                    examDetailsList.innerHTML = '';
                    dayExams.forEach(exam => {
                        const li = document.createElement('li');
                        li.textContent = `${exam.exam_name} at ${exam.time_of_exam} for ${exam.time_allotted} minutes`;
                        examDetailsList.appendChild(li);
                    });
                });
            }

            calendar.appendChild(dayDiv);
        }
    };
    */

    // Event listeners for month and year change
    monthSelect.addEventListener('change', () => {
        fetchExams(parseInt(monthSelect.value)+1, parseInt(yearSelect.value));
    });

    yearSelect.addEventListener('change', () => {
        fetchExams(parseInt(monthSelect.value)+1, parseInt(yearSelect.value));
    });

    // Event listener for the "Save Exam Date" button
    saveExamDateButton.addEventListener('click', () => {
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

        // If no overlap, submit the form (you'll need to implement the backend logic)
        // Here you can make an AJAX request to save the new exam date/time or submit a form
        // For now, just log the selected date and time to the console
        console.log(`Exam scheduled on ${selectedDate} at ${newTime} for ${timeAllotted} minutes.`);
    });



    
    populateYears();
    monthSelect.value = new Date().getMonth();
    if (examIdInput.value === ''){
        timeInputDiv.style.display = 'none';
    }
    // Initial setup
    fetchExams(new Date().getMonth()+1, new Date().getFullYear());
    //generateDays(new Date().getMonth(), new Date().getFullYear(), exams);
});