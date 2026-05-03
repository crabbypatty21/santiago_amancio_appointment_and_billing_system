<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic Admin Dashboard</title>
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

        .sidebar a.active {
            background-color: #007bff;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
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
    <a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <h1>Welcome to the Admin Dashboard</h1>
    <p>Here you can manage all aspects of the dental clinic system.</p>
</div>

</body>
</html>
