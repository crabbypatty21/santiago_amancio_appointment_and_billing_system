<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic Admin Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to external stylesheet -->
    <style>
       /* General body styling */
body {
    margin: 0;
    font-family: Arial, sans-serif;
}

/* Sidebar styling */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100%;
    background-color: #00abf0;
    color: #ecf0f1;
    padding-top: 20px;
    transition: width 0.3s; /* Smooth transition when resizing */
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
    background-color: #007bff;
    color: white;
}

/* Main content styling */
.main-content {
    margin-left: 250px;
    padding: 20px;
    transition: margin-left 0.3s;
}

/* Settings section styling */
.settings-section {
    margin-bottom: 30px;
}

.settings-section h2 {
    color: #333;
}

/* Form styling */
form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

/* Input and textarea fields */
input[type="text"],
input[type="email"],
input[type="password"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* Button styling */
.btn {
    background-color: #00abf0;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    margin-right: 10px;
}

.btn:hover {
    background-color: #007bff;
}

/* Cancel button styling */
.cancel-btn {
    background-color: #e0e0e0;
    color: black;
}

/* Make the layout responsive */
@media (max-width: 1024px) {
    /* Reduce sidebar width on medium screens */
    .sidebar {
        width: 200px;
    }

    /* Adjust main content margin */
    .main-content {
        margin-left: 200px;
    }

    /* Form input sizes */
    input[type="text"],
    input[type="email"],
    input[type="password"],
    textarea {
        font-size: 14px; /* Slightly smaller font size */
        padding: 8px;
    }

    .btn {
        padding: 8px 15px;
        font-size: 14px;
    }
}

@media (max-width: 768px) {
    /* Hide the sidebar on smaller screens */
    .sidebar {
        width: 0;
        margin-left: -250px;
    }

    .main-content {
        margin-left: 0;
        padding: 15px;
    }

    /* Table and form adjustments for smaller screens */
    input[type="text"],
    input[type="email"],
    input[type="password"],
    textarea {
        font-size: 12px; /* Further reduce font size */
        padding: 6px;
    }

    .btn {
        padding: 8px 14px;
        font-size: 12px;
    }

    .cancel-btn {
        padding: 8px 14px;
        font-size: 12px;
    }

    /* Add a mobile-friendly hamburger menu for the sidebar */
    .sidebar.active {
        width: 250px;
        margin-left: 0;
    }
}

@media (max-width: 480px) {
    /* Make further adjustments for very small screens */
    input[type="text"],
    input[type="email"],
    input[type="password"],
    textarea {
        font-size: 10px; /* Even smaller font size for small screens */
        padding: 5px;
    }

    .btn {
        padding: 8px 12px;
        font-size: 12px;
    }

    .cancel-btn {
        padding: 8px 12px;
        font-size: 12px;
    }

    .sidebar {
        width: 0;
        margin-left: -250px;
    }

    .main-content {
        margin-left: 0;
        padding: 10px;
    }
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
    <h1>Admin Settings</h1>

    <!-- Clinic Information Section -->
    <div class="settings-section">
        <h2>Clinic Information</h2>
        <form action="#" method="POST">
            <label for="clinic_name">Clinic Name</label>
            <input type="text" id="clinic_name" name="clinic_name" value="Dental Care Clinic" required>

            <label for="clinic_address">Clinic Address</label>
            <input type="text" id="clinic_address" name="clinic_address" value="123 Dental St, City, Country" required>

            <label for="clinic_phone">Phone Number</label>
            <input type="text" id="clinic_phone" name="clinic_phone" value="123-456-7890" required>

            <label for="clinic_email">Email Address</label>
            <input type="email" id="clinic_email" name="clinic_email" value="contact@dentalcare.com" required>

            <button type="submit" class="btn">Save Clinic Information</button>
            <button type="reset" class="btn cancel-btn">Cancel</button>
        </form>
    </div>

    <!-- Change Admin Password Section -->
    <div class="settings-section">
        <h2>Change Admin Password</h2>
        <form action="#" method="POST">
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required>

            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit" class="btn">Change Password</button>
            <button type="reset" class="btn cancel-btn">Cancel</button>
        </form>
    </div>

    <!-- Notification Settings Section -->
    <div class="settings-section">
        <h2>Notification Settings</h2>
        <form action="#" method="POST">
            <label for="email_notifications">Email Notifications</label>
            <input type="checkbox" id="email_notifications" name="email_notifications" checked>
            <label for="email_notifications">Enable Email Notifications</label>

            <label for="sms_notifications">SMS Notifications</label>
            <input type="checkbox" id="sms_notifications" name="sms_notifications">
            <label for="sms_notifications">Enable SMS Notifications</label>

            <button type="submit" class="btn">Save Notification Settings</button>
            <button type="reset" class="btn cancel-btn">Cancel</button>
        </form>
    </div>

</div>

<script>
    // Get all the sidebar links
    const links = document.querySelectorAll('.sidebar a');

    // Loop through all the links
    links.forEach(link => {
        // Check if the href of the link matches the current page's URL
        if (window.location.href.includes(link.href)) {
            link.classList.add('active'); // Add the active class to the current link
        } else {
            link.classList.remove('active'); // Remove the active class from others
        }
    });
</script>

</body>
</html>
