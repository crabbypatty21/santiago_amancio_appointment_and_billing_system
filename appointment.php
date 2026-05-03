<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'finaldb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search variable
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

// Prepare the SQL statement based on the search prefix
if (strpos($search_query, 'p') === 0) {
    // Search for patient_id
    $patient_id = substr($search_query, 1); // Get the actual patient ID after 'p'
    $sql = "SELECT * FROM appointment WHERE patient_id = ?";
} elseif (strpos($search_query, 's') === 0) {
    // Search for service_id
    $service_id = substr($search_query, 1); // Get the actual service ID after 's'
    $sql = "SELECT * FROM appointment WHERE service_id = ?";
} else {
    // Default: fetch all appointments if no valid prefix
    $sql = "SELECT * FROM appointment";
}

$stmt = $conn->prepare($sql);
if (strpos($search_query, 'p') === 0 || strpos($search_query, 's') === 0) {
    // Bind the parameter only if searching by ID
    $id = (strpos($search_query, 'p') === 0) ? $patient_id : $service_id;
    $stmt->bind_param("s", $id);
}
$stmt->execute();
$result = $stmt->get_result();

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to external stylesheet -->
    <style>
        /* Add your existing styles here */

        .highlight {
            background-color: yellow; /* Highlight color */
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
    <form method="GET" action="">
        <input type="text" class="search-input" name="search" placeholder="Search (p: Patient ID, s: Service ID)" aria-label="Search">
        <button class="search-button" type="submit">Search</button>
    </form>
</div>

<br><br><br><br>
<div class="main-content">
    <h1>Appointment Records</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient ID</th>
                    <th>Service ID</th>
                    <th>Appointment Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Fill Up Date</th>
                </tr>";
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $highlight_patient = (isset($patient_id) && $row["patient_id"] == $patient_id) ? 'highlight' : '';
            $highlight_service = (isset($service_id) && $row["service_id"] == $service_id) ? 'highlight' : '';
            echo "<tr>
                    <td>" . $row["appointment_id"] . "</td>
                    <td class='$highlight_patient'>" . $row["patient_id"] . "</td>
                    <td class='$highlight_service'>" . $row["service_id"] . "</td>
                    <td>" . $row["appointment_day"] . "</td>
                    <td>" . $row["start_time"] . "</td>
                    <td>" . $row["end_time"] . "</td>
                    <td>" . $row["fill_up_date"] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    ?>
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
<style>
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
        transition: transform 0.3s ease-in-out;
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

    /* Main content styling */
    .main-content {
        margin-left: 250px;
        padding: 20px;
        transition: margin-left 0.3s ease-in-out;
    }

    /* Table styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd; /* Add borders between columns */
    }

    th {
        background-color: #00abf0;
        color: #fff;
    }

    tr:hover {
        background-color: #f2f2f2;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .sidebar {
            width: 200px; /* Shrink sidebar width for smaller screens */
        }

        .main-content {
            margin-left: 200px;
        }

        table {
            font-size: 14px; /* Reduce font size for tables */
        }

        th,
        td {
            padding: 8px; /* Adjust padding for smaller screens */
        }
    }

    @media (max-width: 480px) {
        .sidebar {
            width: 100%; /* Sidebar becomes full-width */
            position: relative; /* Make sidebar scrollable */
            height: auto;
        }

        .main-content {
            margin-left: 0; /* Remove left margin for smaller screens */
            padding: 10px;
        }

        table {
            font-size: 12px; /* Further reduce font size */
        }

        th,
        td {
            padding: 6px;
        }

        .sidebar a {
            padding: 10px; /* Adjust link padding */
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
        transition: background-color  0.3s ease; /* Smooth transition for hover effect */
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
</body>
</html>