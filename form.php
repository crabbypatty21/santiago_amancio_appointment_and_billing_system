<?php
session_start();


// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


// Database connection
$conn = new mysqli('localhost', 'root', '', 'finaldb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$user_id = $_SESSION['user_id'];


// Fetch user email and patient details
$stmt = $conn->prepare(
    "SELECT u.email, p.patient_id, p.first_name, p.last_name, p.date_of_birth, p.gender,
            p.contact_number, p.city_province, p.municipality, p.barangay, p.street, p.house_no
     FROM user u
     INNER JOIN patient p ON u.user_id = p.user_id
     WHERE u.user_id = ?"
);


$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email, $patient_id, $first_name, $last_name, $date_of_birth, $gender, $contact_number, $city_province, $municipality, $barangay, $street, $house_no);
$stmt->fetch();
$stmt->close();


// Fetch services for the dropdown
$sql = "SELECT * FROM services";
$result = $conn->query($sql);


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = $_POST['service_id'] ?? null;
    $appointment_day = $_POST['appointment_day'] ?? null;
    $start_time = $_POST['start_time'] ?? null;
    $end_time = $_POST['end_time'] ?? null;
    $fill_up_date = date('Y-m-d H:i:s'); // Current timestamp


    // Validate required fields
    if ($patient_id && $service_id && $appointment_day && $start_time && $end_time) {
        // Insert the appointment into the database
        $stmt = $conn->prepare("
            INSERT INTO appointment
            (patient_id, service_id, appointment_day, start_time, end_time, fill_up_date)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("iissss", $patient_id, $service_id, $appointment_day, $start_time, $end_time, $fill_up_date);


        if ($stmt->execute()) {
            $success_message = "Appointment booked successfully!";
                // Fetch the service cost
                $service_stmt = $conn->prepare("SELECT service_cost, service_name FROM services WHERE service_id = ?");
                $service_stmt->bind_param("i", $service_id);
                $service_stmt->execute();
                $service_stmt->bind_result($service_cost, $service_name);
                $service_stmt->fetch();
                $service_stmt->close();
            
                // Store data in session variables
                $_SESSION['service_cost'] = $service_cost;
                $_SESSION['service_name'] = $service_name;
                $_SESSION['appointment_day'] = $appointment_day;
                $_SESSION['start_time'] = $start_time;
                $_SESSION['end_time'] = $end_time;
            
                header("Location: payment.php");
                exit; // Make sure to exit after redirection
            } else {
                $error_message = "Error: " . $stmt->error;
            }

        $stmt->close();
    } else {
        $error_message = "Please fill out all required fields.";
    }
}


$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
   
    <!-- Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="index.php" class="back-button">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <div class="logo">
                <img src="pictures/log.png" alt="Dental Clinic Logo">
                <div>
                    <div>Santiago-Amancio</div>
                    <span class="dental-clinic">Dental Clinic</span>
                </div>
            </div>



            <!-- Profile Section -->
            <div class="profile-section">
            </div>
        </div>


        <!-- Main Content -->
        <div class="main-content">
            <div class="form-container">
                <div class="form-header">
                    <img src="pictures/log.png" alt="Clinic Logo" width="40">
                    <div>
                        <h3>Santiago-Amancio Dental Clinic</h3>
                        <p>0447 Santiago road St. Lambakin, Marilao Bulacan</p>
                    </div>
                </div>


                <form id="form" method="POST" action="form.php">
                    <!-- Personal Information -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="<?php echo "$first_name"; ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="<?php echo "$last_name"; ?>" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="birthdate" class="form-label">Birthdate</label>
                            <input type="text" class="form-control" id="birthdate" name="birthdate" placeholder="<?php echo "$date_of_birth"; ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender</label>
                            <input type="text" class="form-control" id="gender" name="gender" placeholder="<?php echo "$gender"; ?>" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="<?php echo "$email"; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="contact-no" class="form-label">Contact Number</label>
                        <input type="text" name="contact-no" id="contact-no" class="form-control" placeholder="<?php echo "$contact_number"; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" id="address" class="form-control" placeholder="<?php echo "$house_no, $street, $barangay, $municipality, $city_province"; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="fill_up_date" class="form-label">Current Date and Time</label>
                        <input type="text" class="form-control" id="fill_up_date" name="fill_up_date" readonly>
                    </div>


                    <!-- Service Selection -->
                    <div class="mb-3">
                    <label for="service_id">Select Service:</label>
                    <select name="service_id" id="service_id" required>
                    <option value="" disabled selected>Choose a service</option>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['service_id'] ?>" data-duration="<?= $row['service_duration'] ?>">
                    <?= $row['service_id'] ?>. <?= str_replace('_', ' ', $row['service_name']) ?> - ₱<?= $row['service_cost'] ?> (<?= $row['service_duration'] ?> min.)
                    </option>
                    <?php endwhile; ?>
                    </select>
                    </div>




                    <!-- Appointment Details -->
                    <div class="mb-3">
                        <label for="appointment_day">Select Day:</label>
                        <input type="date" class="form-control" id="appointment_day" name="appointment_day" readonly/>
                    </div>
                    <div class="mb-3">
                        <label for="start_time">Start Time:</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" readonly/>
                    </div>
                    <div class="mb-3">
                        <label for="end_time">End Time:</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" readonly/>
                    </div>


                    <button id="showCalendarButton" type="button">Show Calendar</button>


                    <!-- Calendar Popup -->
                    <div id="calendar">
                        <div id="calendarHeader">
                            <button id="prevMonth">Previous</button>
                            <span id="currentMonthYear"></span>
                            <button id="nextMonth">Next</button>
                    <div id="calendarDays">
                            <div class="calendarHeader">Mon</div>
                            <div class="day-header">Tue</div>
                            <div class="day-header">Wed</div>
                            <div class="day-header">Thu</div>
                            <div class="day-header">Fri</div>
                            <div class="day-header">Sat</div>
                            <div class="day-header">Sun</div>
                    </div>
                           
                        </div>
                        <button id="closeCalendar">Close</button>
                    </div>


                    <!-- Time Slot Popup -->
                    <div id="timeSlotPopup">
                        <h3>Select a Time Slot</h3>
                        <div id="timeSlots"></div>
                        <button id="closeTimeSlotPopup">Close</button>
                    </div>


                    <!-- Submit Appointment Button -->
                     <div>
                    <button id="submit" class="form-control" type="submit" name=submit>Submit Appointment</button>
                    </div>

                    <!-- Terms Modal -->
                    <div id="termsModal">
                        <div id="modalContent">
                            <span class="close">&times;</span>
                            <h2>Terms and Conditions</h2>
                            <h6>1. Non-Refundable Payment Policy</h6>
                            <p>All payments made for dental appointments are non-refundable. This includes deposits and full payments made in advance.</p>
                           
                            <h6>2. Rescheduling Policy</h6>
                            <p>If an appointment needs to be rescheduled due to unforeseen emergencies, such as dentist availability issues or natural disasters, the clinic will notify you immediately and work with you to find a suitable reschedule date.</p>
                           
                            <h6>3. Late Arrivals</h6>
                            <p>Patients arriving more than 15 minutes late may have their appointments rescheduled to avoid delays for other patients.</p>
                           
                            <h6>4. Appointment Confirmation</h6>
                            <p>Patients are required to confirm their appointments 24 hours in advance. Unconfirmed appointments may be canceled by the clinic.</p>
                           
                            <h6>5. Health and Safety</h6>
                            <p>Please inform the clinic of any medical conditions or concerns prior to your appointment to ensure proper care and preparation.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>


    <script>
        function formatDateTo12Hour(date) {
            const hours = date.getHours();
            const minutes = date.getMinutes();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const hour12 = hours % 12 || 12; // Converts to 12-hour format
            const minuteFormatted = minutes < 10 ? '0' + minutes : minutes; // Adds leading zero for single-digit minutes


            return `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')} ${hour12}:${minuteFormatted} ${ampm}`;
        }


        // Get current date and time
        const currentDate = new Date();
        const formattedDate = formatDateTo12Hour(currentDate);


        // Set the current date and time to the input field
        document.getElementById('fill_up_date').value = formattedDate;


        const calendar = document.getElementById('calendar');
        const calendarDays = document.getElementById('calendarDays');
        const appointment_dayInput = document.getElementById('appointment_day');
        const start_timeInput = document.getElementById('start_time');
        const termsCheckbox = document.getElementById('termsCheckbox');
        const submitButton = document.getElementById('submitButton');
        const currentMonthYear = document.getElementById('currentMonthYear');
        const timeSlotPopup = document.getElementById('timeSlotPopup');
        const timeSlotsContainer = document.getElementById('timeSlots');
        const closeTimeSlotPopup = document.getElementById('closeTimeSlotPopup');  
        const termsModal = document.getElementById('termsModal');
        const closeModal = document.getElementsByClassName('close')[0];
        const selectedService = document.getElementById('service_id').value;


        let currentDateObj = new Date(); // Default to the local timezone (browser timezone)
let selectedDate = 0;

document.getElementById('showCalendarButton').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const selectedService = document.getElementById('service_id').value;

    // Check if a service is selected
    if (!selectedService) {
        alert("Please pick a service first."); // Alert if no service is selected
        return; // Exit the function
    }

    renderCalendar(currentDateObj);
    calendar.style.display = 'block'; // Show the calendar
});

document.getElementById('prevMonth').addEventListener('click', function(event) {
    event.preventDefault();
    currentDateObj.setMonth(currentDateObj.getMonth() - 1);
    renderCalendar(currentDateObj); // Render the previous month
});

document.getElementById('nextMonth').addEventListener('click', function(event) {
    event.preventDefault();
    currentDateObj.setMonth(currentDateObj.getMonth() + 1);
    renderCalendar(currentDateObj); // Render the next month
});

// Function to render the calendar
function renderCalendar(date) {
    calendarDays.innerHTML = ''; // Clear previous days
    const month = date.getMonth();
    const year = date.getFullYear();
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const daysInMonth = lastDay.getDate();
    const startDay = firstDay.getDay();

    // Update the month and year display
    currentMonthYear.textContent = `${firstDay.toLocaleString('default', { month: 'long' })} ${year}`;

    // Render days of the week
    const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    daysOfWeek.forEach(day => {
        const dayHeader = document.createElement('div');
        dayHeader.textContent = day;
        dayHeader.className = 'day-header'; // Add class for styling
        calendarDays.appendChild(dayHeader);
    });

    // Fill in the empty days before the first day of the month
    for (let i = 0; i < startDay; i++) {
        const emptyDiv = document.createElement('div');
        calendarDays.appendChild(emptyDiv);
    }

    // Create day elements
    for (let day = 1; day <= daysInMonth; day++) {
        const dayDiv = document.createElement('div');
        let displayText = day; // Default display text is the day number

        // If it's Sunday (dayOfWeek === 0), append "Closed" and apply the "closed" class for red coloring
        const dayOfWeek = (startDay + day - 1) % 7;
        if (dayOfWeek === 0) {
            displayText += " (Closed)"; // Add "Closed" for Sundays
            dayDiv.classList.add('closed'); // Add the "closed" class for Sundays
        }

        dayDiv.textContent = displayText; // Set the display text

        // Add event listener to select the date
        dayDiv.addEventListener('click', function() {
            const selectedFullDate = new Date(year, month, day);
            console.log("Raw selected date:", selectedFullDate);

            // Adjust to Philippine Time (UTC+8)
            const phtDate = new Date(selectedFullDate.getTime() + 8 * 60 * 60 * 1000); // Add 8 hours
            console.log("Selected date in PHT:", phtDate);

            // Format the date for the input field (YYYY-MM-DD)
            const yearPHT = phtDate.getFullYear();
            const monthPHT = String(phtDate.getMonth() + 1).padStart(2, '0');
            const dayPHT = String(phtDate.getDate()).padStart(2, '0');
            appointment_dayInput.value = `${yearPHT}-${monthPHT}-${dayPHT}`;
            console.log("Formatted PHT date:", appointment_dayInput.value);

            if (phtDate >= new Date()) {
                selectedDate = phtDate;
                calendar.style.display = 'none'; // Hide the calendar
                renderTimeSlots(); // Show available time slots
            }
        });

        calendarDays.appendChild(dayDiv);
    }
}document.getElementById('service_id').addEventListener('change', function() {
    // Get the selected option
    const selectedOption = this.options[this.selectedIndex];
   
    // Extract service duration from the selected option (assuming it's stored as data attribute)
    selectedServiceDuration = parseInt(selectedOption.getAttribute('data-duration'));


    // Clear the previous selections
    starttimeInput.value = '';
    document.getElementById('end_time').value = '';
    appointment_dayInput.value = ''; // Clear previously selected date


    // Re-render time slots based on the new service duration
    if (selectedDate) { // Check if a date is already selected
        renderTimeSlots();
    }
});


// Modify renderTimeSlots function
function renderTimeSlots() {
    const timeSlots = [];
    const openingHour = 13; // 1 PM
    const closingHour = 17; // 5 PM


    const now = new Date();
    const isToday = selectedDate.toDateString() === now.toDateString();


    for (let hour = openingHour; hour < closingHour; hour++) {
        for (let minute = 0; minute < 60; minute += selectedServiceDuration) {
            const timeSlot = new Date(selectedDate);
            timeSlot.setHours(hour, minute, 0);
            if (!isToday || timeSlot > now) {
                timeSlots.push(timeSlot);
            }
        }
    }


    // Clear previous time slots
    timeSlotsContainer.innerHTML = '';


    // Display time slots
    timeSlots.forEach(slot => {
        const slotButton = document.createElement('button');
        slotButton.textContent = slot.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        slotButton.type = 'button'; // Ensure button type is 'button'
        slotButton.addEventListener('click', function() {
            start_timeInput.value = slot.toTimeString().split(' ')[0]; // Set selected time to input
           
            // Calculate and set end time
            const endTime = new Date(slot);
            endTime.setMinutes(endTime.getMinutes() + selectedServiceDuration);
            document.getElementById('end_time').value = endTime.toTimeString().split(' ')[0]; // Set end time to input
           
            timeSlotPopup.style.display = 'none'; // Hide popup
            checkSubmitButtonState(); // Check if submit button can be enabled
        });
        timeSlotsContainer.appendChild(slotButton);
    });


    timeSlotPopup.style.display = 'block'; // Show time slot popup
}
        termsCheckbox.addEventListener('change', function() {
            if (this.checked) {
                termsModal.style.display = 'block';
            } else {
                submitButton.readonly = true;
            }
        });


        closeModal.addEventListener('click', function() {
            termsModal.style.display = 'none';
            termsCheckbox.checked = true; // Uncheck the checkbox when modal is closed
            submitButton.readonly = false; // Disable submit button
        });


        window.addEventListener('click', function(event) {
            if (event.target === termsModal) {
                termsModal.style.display = 'none';
                termsCheckbox.checked = false; // Uncheck the checkbox when modal is closed
                submitButton.readonly = true; // Disable submit button
            }
        });


        submitButton.addEventListener('click', function() {
            if (termsCheckbox.checked) {
                alert("appointment booked.");
            }
        });


        // Enable submit button when terms are accepted and both date and time are filled
        termsCheckbox.addEventListener('change', checkSubmitButtonState);
        appointment_dayInput.addEventListener('change', checkSubmitButtonState);
        start_timeInput.addEventListener('change', checkSubmitButtonState);


        function checkSubmitButtonState() {
            const isDateFilled = appointment_dayInput.value !== '';
            const isTimeFilled = start_timeInput.value !== '';
            submitButton.readonly = !(isDateFilled && isTimeFilled && termsCheckbox.checked);
        }
    </script>




<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    #calendar {
        position: fixed; /* Make it fixed to the viewport */
        top: 50%; /* Center vertically */
        left: 50%; /* Center horizontally */
        transform: translate(-50%, -50%); /* Adjust for the size of the element */
        width: 80vw; /* Full width */
        height: 80vh; /* Full height */
        background-color: #e6f7ff; /* Light sky blue background */
        overflow: auto; /* Allow scrolling if needed */
        z-index: 1000; /* Ensure it appears above other elements */
        display: none; /* Initially hidden */
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    #calendarHeader {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px; /* Larger font size */
        color: #0056b3; /* Darker blue text color */
    }

    #calendarDays {
        display: grid; /* Use grid layout */
        grid-template-columns: repeat(7, 1fr); /* 7 columns for days of the week */
        gap: 10px; /* Space between days */
    }

    #calendarDays div {
        padding: 20px; /* Increased padding */
        text-align: center;
        cursor: pointer;
        border: 1px solid #b3e0ff; /* Light border color */
        height: 100px; /* Increased fixed height for uniformity */
        line-height: 60px; /* Center text vertically */
        background-color: #e0f7fa; /* Lighter background for days */
        transition: background-color 0.3s; /* Smooth transition for hover effect */
    }

    #calendarDays div.closed {
        color: #ff4d4d; /* Red for closed days */
    }

    #calendarDays div.selected {
        background-color: #007bff; /* Sky blue for selected */
        color: white;
    }

    #calendarDays div.today {
        background-color: #99ccff; /* Highlight today's date */
    }
/* Style for days marked as "Closed" (Sundays) */
.closed {
    color: red;
    font-weight: bold;
}


    #timeSlotPopup {
        display: none;
        position: absolute;
        top: 50%; /* Center vertically */
        left: 50%; /* Center horizontally */
        transform: translate(-50%, -50%); /* Adjust for the size of the element */
        background-color: #e6f7ff; /* Light sky blue */
        border: 1px solid #b3e0ff; /* Light border color */
        padding: 20px; /* Increased padding */
        z-index: 1001;
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    #timeSlotPopup button {
        margin: 10px; /* Increased margin */
        background-color: #007bff; /* Sky blue button */
        color: white; /* White text for buttons */
        border: none;
        padding: 10px 20px; /* Increased padding for buttons */
        border-radius: 5px; /* Rounded corners for buttons */
        cursor: pointer; /* Pointer cursor on hover */
        transition: background-color 0.3s; /* Smooth transition for hover effect */
    }

    #timeSlotPopup button:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }

    /* Modal styles */
    #termsModal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1002; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0, 0, 0); /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
    }

    #modalContent {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
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
        color: #0056b3; /* Darker blue on hover */
        text-decoration: none;
        cursor: pointer;
    }

    /* Days of the week styles */
    .day-header {
        font-weight: bold;
        background-color: #cceeff; /* Light blue for day headers */
        border: 1px solid #b3e0ff; /* Light border color */
        height: 40px; /* Fixed height for uniformity */
        line-height: 40px; /* Center text vertically */
        text-align: center; /* Center text horizontally */
    }

    /* Lighter styling for the day numbers */
    .day-number {
        background-color: #e0f7fa; /* Lighter background for day numbers */
        color: #333; /* Darker text color for contrast */
        border-radius: 5px; /* Slightly rounded corners */
        transition: background-color 0.3s; /* Smooth transition for hover effect */
    }

    .day-number:hover {
        background-color: #b2ebf2; /* Even lighter on hover */
    }

    /* Responsive styles */
    @media (max-width: 600px) {
        #calendar {
            width: 90vw; /* Adjust width for smaller screens */
            height: 90vh; /* Adjust height for smaller screens */
        }

        #calendarDays div {
            height: 50px; /* Adjust height for smaller screens */
            line-height: 50px; /* Center text vertically */
        }

        #calendarHeader {
            font-size: 20px; /* Smaller font size for smaller screens */
        }
    }
    </style>
 <style>
     /* General styles */
     * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #f4f6f9;
        }
        .dashboard-container {
            display: flex;
            height: 100vh;
            flex-direction: row;
        }
        .sidebar {
            background-color: #00abf0;
            color: white;
            width: 250px;
            padding: 20px 10px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transition: transform 0.3s ease;
            font-weight: bold;
        }
        .sidebar .logo {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            color: #fff;
            text-transform: uppercase;
            border-bottom: 2px solid #fff;
            padding-bottom: 10px;
        }
        .logo img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        .logo .dental-clinic {
            color: #003d80;
            margin-top: 2px;
            font-weight: bold;
        }
        .sidebar nav {
            flex: 1;
            margin-top: 20px;
        }
        .sidebar nav a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            display: block;
            transition: background 0.3s;
        }
        .sidebar nav a:hover {
            background-color: #003d80;
            padding-left: 15px;
        }
        .sidebar nav a.active {
            background-color: #007bff;
        }
        .sidebar nav a.logout {
            margin-top: auto; /* Pushes the logout button to the bottom */
            background-color: #dc3545;
            color: white;
            font-size: 18px;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .sidebar nav a.logout:hover {
            background-color: #c82333;
        }


    /* Main content styles */
    .main-content {
        margin-left: 250px;
        padding: 30px;
        width: 100%;
    }


    .header h2 {
        font-size: 32px;
        font-weight: 700;
    }


    /* Form container styles */
    .form-container {
        background-color: #ffffff;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
    }


    .form-header {
        background-color: #00abf0;
        color: white;
        padding: 8px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        gap: 10px;
    }


    .form-header img {
        height: 40px;
        width: auto;
    }


    .form-header h3 {
        font-family: 'times new roman', sans-serif;
        color: #0056b3;
        margin-bottom: 0;
        font-weight: 700;
        font-size: 28px;
    }


    .form-header p {
        font-family: 'times new roman', sans-serif;
        color: white;
        margin-bottom: 0;
        font-weight: 700;
        font-size: 16px;
    }


    .form-container input,
    .form-container select {
        width: 100%;
        padding: 7px;
        margin-bottom: 10px;
        border-radius: 10px;
        border: 1px solid #ccc;
    }


    .footer {
        text-align: center;
        padding: 15px;
        background-color: #f4f6f9;
        font-size: 14px;
        color: #777;
    }
/* Button styling (optional, if you want to style the Show Calendar button) */
#showCalendarBtn {
    margin-top: 10px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    background-color: #80d8ff; /* Light blue background */
    border: none; /* Remove default border */
    border-radius: 5px; /* Slightly rounded corners */
    color: #000; /* Dark text for contrast */
    transition: background-color 0.3s, color 0.3s; /* Smooth transition */
}

#showCalendarBtn:hover {
    background-color: #40c4ff; /* Lighter blue on hover */
    color: white; /* Change text color to white on hover */
}
/* Style the modal */
.modal-content {
    border-radius: 10px;
    padding: 20px;
}
    button[type="submit"] {
    width: 100%; /* Ensure button spans full width of its container */
    padding: 10px;
    background-color: #00abf0;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    margin-top: 10px;
    display: block; /* Ensure it behaves like a block-level element */
    text-align: center; /* Align text in the center */
}


button[type="submit"]:hover {
    background-color: #007bff;
    transform: scale(1.05);
}
/* Profile Section Styles */
     .profile-section {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #00abf0;
            border-radius: 80px;
            margin-bottom: px;
            margin-top: -10px;
        }
        .profile-section img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }
        .profile-section .profile-info {
            color: #fff;
        }
        .profile-section .profile-info h3 {
            font-size: 16px;
            margin: 0;
            font-weight: bold;
        }
        .profile-section .status {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }
        .profile-section .status .status-indicator {
            width: 10px;
            height: 10px;
            background-color: #28a745;
            border-radius: 50%;
            margin-left: 5px;
        }
        .profile-section .status-indicator {
    color: #28a745; /* Green color for online */
    font-size: 18px; /* Adjust size of the check icon */
    margin-left: 10px; /* Adds spacing between the name and the check icon */
    vertical-align: middle; /* Align icon with text */
}
/* Reduce margin between form fields */
form .mb-3 {
    margin-bottom: 5px; /* Further decrease space between fields */
    padding-right: 3px; /* Less space between columns */
    padding-left: 3px; /* Less space between columns */
}


form .mb-2 {
    margin-bottom: 3px; /* Tighter spacing between fields */
    padding-right: 3px; /* Less space between columns */
    padding-left: 3px; /* Less space between columns */
}


/* Adjust the input field height and padding for more compactness */
form .form-control {
    padding: 4px 6px; /* Smaller padding for a more compact input field */
    font-size: 13px; /* Slightly smaller font size for tighter alignment */
}


/* Adjust select fields */
form .form-select {
    padding: 4px 6px; /* Reduced padding for select dropdown */
    font-size: 13px; /* Slightly smaller font for better alignment */
}


/* Adjust the labels */
form .form-label {
    font-size: 13px; /* Smaller font size for labels */
    margin-bottom: 2px; /* Minimal space between label and input */
}


/* Adjust column spacing */
form .row {
    margin-bottom: 5px; /* Minimal space between rows */
}


form .col-md-6 {
    padding-right: 3px; /* Less space between columns */
    padding-left: 3px; /* Less space between columns */
}


/* Optional: Adjust the submit button margin */
form .text-center button {
    margin-top: 8px; /* Minimal space above the button */
}


/* For small screens (optional, if needed) */
@media (max-width: 768px) {
    form .col-md-6 {
        padding-right: 2px;
        padding-left: 2px;
    }
}
.back-button {
    display: flex;
    align-items: center;
    color: white;
    font-size: 13px;
    margin-bottom: 10px; /* Adjust space between the button and the logo */
    text-decoration: none;
    padding: 10px;
    border-radius: 50px;
    background-color: #007bff;
    transition: background-color 0.3s;
}


.back-button:hover {
    background-color: #0056b3;
}


.back-button i {
    margin-right: 10px;
}
.form-check {
    display: flex;
    align-items: center;
    justify-content: flex-start; /* Align checkbox and label correctly */
}


.form-check-input {
    margin-right: 10px; /* Space between checkbox and label */
    width: 16px !important; /* Set a smaller width for the checkbox */
    height: 16px !important; /* Set a smaller height for the checkbox */
    transform: none;
    appearance: checkbox;
    border: 1px solid #ccc;
    border-radius: 3px;
    background-color: white;
}


.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}


.form-check-label {
    font-size: 14px;
    color: #333;
}


.terms-link {
    color: #007bff;
    text-decoration: none;
}


.terms-link:hover {
    text-decoration: underline;
}
 .modal-content {
        background-color: white; /* Sky Blue */
        color: #ffffff; /* Default white text */
        border: 2px solid #4682B4; /* Steel Blue border */
        border-radius: 10px; /* Smooth corners */
        padding: 20px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); /* Floating effect */
    }


    .modal-header {
        background-color: #4682B4; /* Steel Blue */
        color: #ffffff; /* White text */
    }


    .modal-body p {
        color: black; /* White font for paragraphs */
    }


    .modal-body h6 {
        font-weight: bold; /* Bold titles for each section */
        color: #4682B4; /* Black font for titles */
    }
    </style>
</body>
</html>

