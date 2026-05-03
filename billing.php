<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic Admin Dashboard</title>
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
    transition: margin-left 0.3s; /* Smooth transition for content shift */
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    table-layout: fixed; /* Ensures columns stay equal width */
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
    font-size: 16px; /* Adjusted font size */
}

th {
    background-color: #00abf0;
    color: white;
}

/* Action buttons in table */
.action-buttons {
    gap: 10px;
    display: flex;
    justify-content: center;
}

.accept-btn, .decline-btn {
    padding: 8px 16px;
    cursor: pointer;
    position: relative;
}

.accept-btn {
    background-color: #4CAF50;
    color: white;
}

.decline-btn {
    background-color: #f44336;
    color: white;
}

/* Make the table responsive */
.table-container {
    overflow-x: auto; /* Allows horizontal scrolling for the table */
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on mobile */
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
.search-container {
            position: absolute; /* Positions the container absolutely */
            top: 20px; /* Distance from the top */
            right: 20px; /* Distance from the right */
            display: flex;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.9); /* Slightly more opaque background */
            border-radius: 50px; /* Makes the container oblong */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* More pronounced shadow */
            backdrop-filter: blur(15px); /* Applies a stronger blur effect to the background */
            padding: 10px 20px; /* Adds padding around the content */
        }
        .search-input {
            padding: 15px 20px; /* Increased padding for a more spacious look */
            font-size: 18px; /* Increased font size */
            border: none;
            border-radius: 50px; /* Makes the input field oblong */
            width: 350px; /* Increased width */
            outline: none; /* Removes the default outline */
            background-color: #e7f1ff; /* Light blue background color */
            color: #333; /* Dark text color for contrast */
            transition: background-color 0.3s ease; /* Smooth transition for hover effect */
        }
        .search-input:focus {
            background-color: #d0e4ff; /* Lighter blue on focus */
        }
        .search-button {
            padding: 15px 25px; /* Increased padding for a more spacious look */
            font-size: 18px; /* Increased font size */
            border: none;
            border-radius: 50px; /* Makes the button oblong */
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            margin-left: -5px; /* Slight overlap for a seamless look */
            transition: background-color 0.3s ease; /* Smooth transition for hover effect */
        }
        .search-button:hover {
            background-color: #0056b3;
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

<div class="search-container">
        <input type="text" class="search-input" placeholder="Search..." aria-label="Search">
        <button class="search-button" type="submit">Search</button>
    </div>
<br> <br> <br> <br> 
<div class="main-content">
    <!-- Billing Records Table -->
    <h2>Billing Records</h2>
    <table>
        <thead>
            <tr>
                <th>Billing_ID</th>
                <th>Full Name</th>
                <th>Payment Date</th>
                <th>Payment Amount</th>
                <th>Service</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example row 1 -->
            <tr>
                <td>1</td>
                <td>Juan Dela Cruz</td>
                <td>2024-11-22</td>
                <td>$100.00</td>
                <td>Teeth Cleaning</td>
            </tr>
            <!-- Example row 2 -->
            <tr>
                <td>2</td>
                <td>Ana Reyes</td>
                <td>2024-11-20</td>
                <td>$150.00</td>
                <td>Tooth Extraction</td>
            </tr>
        </tbody>
    </table>
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
