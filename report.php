<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic Reports</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to external stylesheet -->
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
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

        .report-section {
            margin-bottom: 30px;
        }

        .report-section h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
        
        .btn-download {
            align: center;
            background-color: #00abf0;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-download:hover {
            background-color: #007bff;
        }
        @media (max-width: 480px) {
    .sidebar {
        width: 100%; /* Make sidebar full-width */
        position: relative;
        height: auto;
    }

    .main-content {
        margin-left: 0; /* Remove left margin */
        padding: 10px; /* Adjust padding */
    }

    .new-appointment-btn {
        padding: 8px 16px; /* Smaller button padding */
    }

    table th, table td {
        font-size: 12px; /* Reduce table font size further */
        padding: 5px; /* Adjust padding */
    }

    .action-buttons {
        gap: 5px; /* Adjust gap between buttons */
    }

    .form-floating input,
    .form-floating select {
        font-size: 14px; /* Adjust font size for inputs */
        padding: 10px; /* Adjust padding */
    }

    .form-wide {
        font-size: 14px; /* Adjust font size */
    }
    .table-container {
        width: 100%; /* Full width container */
        overflow-x: auto; /* Horizontal scrolling */
    }

    table {
        min-width: 600px; /* Ensure table is large enough to scroll */
    }

    th, td {
        font-size: 12px; /* Reduce font size for smaller screens */
        padding: 6px; /* Reduce padding */
    }
}

@media (max-width: 480px) {
    th, td {
        font-size: 10px; /* Further reduce font size for mobile */
        padding: 5px; /* Further reduce padding */
    }

    table {
        min-width: 500px; /* Ensure it stays wide enough to scroll */
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
    <h1>Dental Clinic Reports</h1>

    <!-- Appointments Report -->
    <div class="report-section">
        <h2>Appointments Report</h2>
        <table>
            <thead>
                <tr>
                    <th>Appointment_ID</th>
                    <th>Patient Name</th>
                    <th>Service</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example data, you can replace it with dynamic data -->
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>Teeth Cleaning</td>
                    <td>2024-11-15</td>
                    <td>Completed</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jane Smith</td>
                    <td>Tooth Extraction</td>
                    <td>2024-11-18</td>
                    <td>Pending</td>
                </tr>
            </tbody>
        </table>
        <a href="#" class="btn-download">Download Appointments Report</a>
    </div>

    <!-- Billing Report -->
    <div class="report-section">
        <h2>Billing Report</h2>
        <table>
            <thead>
                <tr>
                    <th>Billing_ID</th>
                    <th>Patient Name</th>
                    <th>Payment Date</th>
                    <th>Payment Amount</th>
                    <th>Service</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example data, replace it with dynamic data -->
                <tr>
                    <td>101</td>
                    <td>John Doe</td>
                    <td>2024-11-15</td>
                    <td>$50.00</td>
                    <td>Teeth Cleaning</td>
                </tr>
                <tr>
                    <td>102</td>
                    <td>Jane Smith</td>
                    <td>2024-11-18</td>
                    <td>$150.00</td>
                    <td>Tooth Extraction</td>
                </tr>
            </tbody>
        </table>
        <a href="#" class="btn-download">Download Billing Report</a>
    </div>

    <!-- Patient Statistics Report -->
    <div class="report-section">
        <h2>Patient Statistics</h2>
        <table>
            <thead>
                <tr>
                    <th>Patient_ID</th>
                    <th>Full Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Total Appointments</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example data, replace it with dynamic data -->
                <tr>
                    <td>001</td>
                    <td>John Doe</td>
                    <td>30</td>
                    <td>Male</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>002</td>
                    <td>Jane Smith</td>
                    <td>28</td>
                    <td>Female</td>
                    <td>3</td>
                </tr>
            </tbody>
        </table>
        <a href="#" class="btn-download">Download Patient Statistics Report</a>
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
