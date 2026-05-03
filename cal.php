<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compact Calendar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f9f9f9;
        }

        .calendar-container {
            position: relative;
        }

        .calendar-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .calendar-btn:hover {
            background-color: #0056b3;
        }

        .calendar-popup {
            display: none;
            position: absolute;
            top: 50px;
            left: 0;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            width: 600px; /* Compact width */
            padding: 15px;
            overflow: hidden;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 5px;
            background-color: #f0f0f0;
            border-bottom: 1px solid #ddd;
        }

        .calendar-header button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 8px;
            cursor: pointer;
        }

        .calendar-header button:hover {
            background-color: #0056b3;
        }

        .calendar-header span {
            font-size: 18px;
            font-weight: bold;
        }

        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr); /* 7 columns for the days */
            gap: 0;
            text-align: center;
            font-size: 16px;
        }

        .day {
            font-weight: bold;
            padding: 5px 0;
            background-color: #f0f0f0;
            border-bottom: 1px solid #ddd;
        }

        .date {
            padding: 8px 0;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .date:hover {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="calendar-container">
        <button class="calendar-btn" onclick="toggleCalendar()">Open Calendar</button>
        <div class="calendar-popup" id="calendar">
            <div class="calendar-header">
                <button onclick="changeMonth(-1)">&#9664; Prev</button>
                <span id="month-year"></span>
                <button onclick="changeMonth(1)">Next &#9654;</button>
            </div>
            <div class="calendar-days" id="calendar-days">
                <!-- Calendar days will be generated here -->
            </div>
        </div>
    </div>

    <script>
        const calendar = document.getElementById("calendar");
        const monthYear = document.getElementById("month-year");
        const calendarDays = document.getElementById("calendar-days");
        let currentDate = new Date();

        function toggleCalendar() {
            if (calendar.style.display === "none" || calendar.style.display === "") {
                calendar.style.display = "block";
                generateCalendar(currentDate);
            } else {
                calendar.style.display = "none";
            }
        }

        function generateCalendar(date) {
            // Clear previous calendar
            calendarDays.innerHTML = "";

            // Get month and year
            const month = date.getMonth();
            const year = date.getFullYear();

            // Display current month and year
            monthYear.textContent = date.toLocaleString("default", { month: "long" }) + " " + year;

            // Get first day and number of days in the month
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Add day labels (Sun, Mon, Tue, ...)
            const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
            days.forEach(day => {
                const dayElement = document.createElement("div");
                dayElement.className = "day";
                dayElement.textContent = day;
                calendarDays.appendChild(dayElement);
            });

            // Add empty spaces for days before the first day
            for (let i = 0; i < firstDay; i++) {
                const emptyCell = document.createElement("div");
                calendarDays.appendChild(emptyCell);
            }

            // Add date cells with numbers
            for (let i = 1; i <= daysInMonth; i++) {
                const dateCell = document.createElement("div");
                dateCell.className = "date";
                dateCell.textContent = i;

                // Add click event for the date cell
                dateCell.addEventListener("click", () => {
                    alert(`Selected date: ${i} ${monthYear.textContent}`);
                });

                calendarDays.appendChild(dateCell);
            }
        }

        function changeMonth(step) {
            currentDate.setMonth(currentDate.getMonth() + step);
            generateCalendar(currentDate);
        }
    </script>
</body>
</html>
