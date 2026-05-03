<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'finaldb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for updating appointment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_appointment'])) {
    $appointment_id = $_POST['appointment_id'];
    $appointment_day = $_POST['appointment_day'];

    $updateSql = "UPDATE appointment SET appointment_day = ? WHERE appointment_id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("si", $appointment_day, $appointment_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch total appointments
$totalAppointments = 0;
$sql = "SELECT COUNT(*) FROM appointment";
$result = $conn->query($sql);
if ($result) {
    $totalAppointments = $result->fetch_row()[0];
}

// Fetch today's appointments
$currentDayAppointments = 0;
$sqlToday = "SELECT COUNT(*) FROM appointment WHERE appointment_day = CURDATE()";
$resultToday = $conn->query($sqlToday);
if ($resultToday) {
    $currentDayAppointments = $resultToday->fetch_row()[0];
}

// Fetch upcoming appointments
$upcomingAppointments = 0;
$sqlUpcoming = "SELECT COUNT(*) FROM appointment WHERE appointment_day > CURDATE()";
$resultUpcoming = $conn->query($sqlUpcoming);
if ($resultUpcoming) {
    $upcomingAppointments = $resultUpcoming->fetch_row()[0];
}

// Fetch all appointments for the calendar
$appointments = [];
$sqlAppointments = "SELECT appointment_id, appointment_day, start_time, end_time FROM appointment ORDER BY appointment_day, start_time";
$resultAppointments = $conn->query($sqlAppointments);
if ($resultAppointments) {
    while ($row = $resultAppointments->fetch_assoc()) {
        $appointments[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add styles for the modal */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px; 
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h2>Dental Admin</h2>
    <a href="dash.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
    <a href="appointment.php"><i class="fas fa-calendar-check"></i> Appointments</a>
    <a href="patient.php"><i class="fas fa-users"></i> Patients</a>
    <a href="billing.php"><i class="fas fa-file-invoice"></i> Billing</a>
    <a href="service.php"><i class="fas fa-tooth"></i> Services</a>
    <a href="report.php"><i class="fas fa-chart-bar"></i> Reports</a>
    <a href="setting.php"><i class="fas fa-cog"></i> Settings</a>
    <a href="admin_login.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <div class="box-container">
        <div class="box box-1">
            <h3>Total Appointments</h3>
            <p><?php echo $totalAppointments; ?></p>
        </div>
        <div class="box box-2">
            <h3>Today's Appointments</h3>
            <p><?php echo $currentDayAppointments; ?></p>
        </div>
        <div class="box box-3">
            <h3>Upcoming Appointments</h3>
            <p><?php echo $upcomingAppointments; ?></p>
        </div>
    </div>

    <div class="calendar-wrapper">
        <div class="calendar">
            <div class="calendar-nav">
                <button id="prevMonth">Previous Month</button>
                <span id="monthYear"></span>
                <button id="nextMonth">Next Month</button>
            </div>
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Modal for updating appointment -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Update Appointment</h2>
            <form id="updateForm" method="POST">
                <input type="hidden" name="appointment_id" id="appointment_id">
                <label for="appointment_day">Appointment Day:</label>
                <input type="date" name="appointment_day" id="appointment_day" required>
                <button type="submit" name="update_appointment">Update Appointment</button>
            </form>
        </div>
    </div>
</div>

<script>
    const appointments = <?php echo json_encode($appointments); ?>;
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    function generateCalendar(month, year) {
        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();
        const today = new Date();
        const calendar = document.getElementById("calendar");
        const monthYear = document.getElementById("monthYear");
        calendar.innerHTML = "";
        monthYear.textContent = `${monthNames[month]} ${year}`;
        let table = "<table class='calendar'>";
        table += "<thead><tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr></thead><tbody>";
        let date = 1;

        for (let i = 0; i < 6; i++) {
            table += "<tr>";
            for (let j = 0; j < 7; j++) {
                if (i === 0 && j < firstDay) {
                    table += "<td></td>";
                } else if (date > lastDate) {
                    break;
                } else {
                    const dateStr = `${year}-${(month + 1).toString().padStart(2, "0")}-${date.toString().padStart(2, "0")}`;
                    const dayAppointments = appointments.filter((appointment) => appointment.appointment_day === dateStr);
                    let appointmentButtons = "";
                    dayAppointments.forEach((appointment) => {
                        appointmentButtons += `
                            <button class="appointment-button" onclick="openModal(${appointment.appointment_id}, '${appointment.appointment_day}')">
                                ${appointment.start_time}
                            </button>`;
                    });
                    const isToday = date === today.getDate() && month === today.getMonth() && year === today.getFullYear();
                    const classes = `${isToday ? "today" : ""} ${j === 0 ? "sunday" : ""}`;
                    table += `<td class="${classes}">${date}<div class="appointments">${appointmentButtons}</div></td>`;
                    date++;
                }
            }
            table += "</tr>";
        }

        table += "</tbody></table>";
        calendar.innerHTML = table;
    }

    function openModal(id, appointmentDay, startTime) {
        document.getElementById("appointment_id").value = id;
        document.getElementById("appointment_day").value = appointmentDay;
        document.getElementById("myModal").style.display = "block";
    }

    document.getElementById("closeModal").onclick = function() {
        document.getElementById("myModal").style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById("myModal")) {
            document.getElementById("myModal").style.display = "none";
        }
    }

    document.getElementById("prevMonth").addEventListener("click", () => {
        currentMonth = currentMonth === 0 ? 11 : currentMonth - 1;
        currentYear = currentMonth === 11 ? currentYear - 1 : currentYear;
        generateCalendar(currentMonth, currentYear);
    });

    document.getElementById("nextMonth").addEventListener("click", () => {
        currentMonth = currentMonth === 11 ? 0 : currentMonth + 1;
        currentYear = currentMonth === 0 ? currentYear + 1 : currentYear;
        generateCalendar(currentMonth, currentYear);
    });

    generateCalendar(currentMonth, currentYear);
</script>


<style>
    /* Additional styling for appointment buttons */
    .appointment-button {
        display: block;
        margin: 5px 0;
        padding: 5px 10px;
        font-size: 12px;
        color: #fff;
        background-color: #00abf0;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        transition: background-color 0.3s;
    }
    .appointment-button:hover {
        background-color: #0056b3;
    }
    .appointments {
        margin-top: 10px;
    }
    
            body {
                margin: 0;
                font-family: Arial, sans-serif;
                background-color: #f4f7fc;
            }
    
            .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100%;
        background-color: #00abf0;
        color: #ecf0f1;
        padding-top: 20px;
    }
    
    .sidebar h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .sidebar a {
        display: block;
        padding: 15px 20px;
        color: #ecf0f1;
        text-decoration: none;
        transition: background 0.3s;
    }
    
    .sidebar a:hover {
        background-color: #0056b3;
    }
    
    /* Active link styles */
    .sidebar a.active {
        background-color: #007bff; /* Blue background */
        color: white; /* White text */
    }
    
    
            .main-content {
                margin-left: 250px;
                padding: 20px;
            }
    
            .box-container {
                display: flex;
                justify-content: space-between;
                margin-top: 20px;
                gap: 15px;
            }
    
            .box {
                font-size: 28px;
                width: 24%;
                padding: 50px;
                color: #fff;
                border-radius: 10px;
                text-align: center;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease;
            }
    
            .box:hover {
                transform: translateY(-10px);
            }
    
            .box-1 {
                background-color: #4CAF50; /* Green */
            }
    
            .box-2 {
                background-color: #FF5733; /* Red */
            }
    
            .box-3 {
                background-color: #FFC107; /* Yellow */
            }
    
            .box-4 {
                background-color: #00BCD4; /* Blue */
            }
    
            .box h3 {
                margin: 0;
                font-size: 24px;
                font-weight: 600;
            }
    
            .box p {
                font-size: 18px;
                margin-top: 5px;
            }
    
            .calendar-wrapper {
                display: flex;
                justify-content: space-between;
                margin-top: 20px;
                padding: 20px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
                width: 100%;
                box-sizing: border-box;
            }
    
            .calendar {
                border-collapse: collapse;
                width: 95%; 
                height: auto;
                border-radius: 10px;
                overflow: hidden;
            }
    
            .calendar th, .calendar td {
                padding: 20px;
                text-align: center;
                border: 1px solid #479ebb;
                font-size: 18px;
            }
    
            .calendar th {
                background-color: #00abf0;
                color: white;
                font-weight: 800;
            }
    
            .calendar td {
                height: 50px;
                vertical-align: middle;
                cursor: pointer;
                transition: background-color 0.3s;
            }
    
            .calendar td:hover {
                background-color: #f0f0f0;
            }
    
            .calendar .sunday {
                background-color: #9560adb4; /* Light red for Sundays */
            }
    
            .calendar .holiday {
                background-color: #cc4747ba; /* Yellow for holidays */
                font-weight: bold;
            }
    
            .calendar-nav {
                text-align: center;
                margin-bottom: 20px;
            }
    
            .calendar-nav button {
                padding: 12px 18px;
                font-size: 16px;
                background-color: #00abf0;
                color: white;
                border: none;
                cursor: pointer;
                margin: 0 15px;
                border-radius: 5px;
                transition: background-color 0.3s;
                display: inline-block;
            }
    
            .calendar-nav button:hover {
                background-color: #0056b3;
            }
    
            .calendar-nav span {
                font-size: 20px;
                font-weight: bold;
                margin: 0 20px;
            }
    
            .calendar-legend {
                width: 20%;
                height: 20%;
                padding: 20px;
                background-color: #b7773a98;
                border-radius: 10px;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            }
    
            .legend-item {
                display: flex;
                align-items: right;
                margin-bottom: 10px;
            }
    
            .legend-item span {
                margin-left: 10px;
            }
    
            .legend-item .calendar-color {
                width: 30px;
                height: 20px;
                border-radius: 50%;
            }
            .legend-item .regular-day {
                background-color: #ffffff; /* Same as Regular Days */
            }
    
            .legend-item .sunday {
                background-color: #9560adb4; /* Same as Sundays */
            }
    
            .legend-item .holiday {
                background-color: #cc4747ba; /* Same as Holiday */
            }
    
            .holiday-label {
                display: block;
                font-size: 12px;
                font-weight: bold;
                color: #ffffff;
                background-color: #cc4747;
                padding: 2px 5px;
                border-radius: 5px;
                text-align: center;
                margin-top: 5px;
            }
        </style>
</body>
</html>