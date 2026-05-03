<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
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
    "SELECT u.email, p.first_name, p.last_name, p.date_of_birth, p.gender,contact_number, 
            p.city_province, p.municipality, p.barangay, p.street, p.house_no
     FROM user u
     INNER JOIN patient p ON u.id = p.user_id
     WHERE u.id = ?"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email, $first_name, $last_name, $date_of_birth, $gender,$contact_number, $city_province, $municipality, $barangay, $street, $house_no);
$stmt->fetch();

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
</head>
<body>

<div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="pictures/log.png" alt="Dental Clinic Logo">
            <div>
                <div>Santiago-Amancio</div>
                <span class="dental-clinic">Dental Clinic</span>
            </div>
        </div>

        <!-- Profile Section -->
        <div class="profile-section">
    <img src="https://via.placeholder.com/50" alt="User Icon">
    <div class="profile-info">
        <h3>
            <?php echo "$first_name";?>
             <i class="fas fa-check-circle status-indicator"></i> <!-- Green check icon -->
        <div class="status">
            <!-- Optional additional status info -->
        </div>
    </div>
</div>


        <!-- Navigation Links -->
        <nav>
            <a href="profile.php" class="<?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : '' ?>">Profile</a>
            <a href="form.php" class="<?= basename($_SERVER['PHP_SELF']) == 'form.php' ? 'active' : '' ?>">Book Appointment</a>
            <a href="#" class="<?= basename($_SERVER['PHP_SELF']) == '#' ? 'active' : '' ?>">Invoice</a>
            <a href="login.php" class="<?= basename($_SERVER['PHP_SELF']) == 'logoutp.php' ? 'active' : '' ?>">Log out</a>
         
        </nav>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


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

/* Dashboard Container */
.dashboard-container {
    display: flex;
    flex-direction: row;
    height: 100vh;
    overflow-x: hidden; /* Prevent horizontal scrolling */
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

/* Logo section */
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

/* Sidebar Navigation */
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
    margin-top: auto;
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

/* Main Content */
.main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    background-color: #ffffff;
    padding: 30px;
    margin-left: 250px;
    justify-content: flex-start;
}

/* Header Section */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.header h2 {
    font-size: 32px;
    font-weight: 700;
}

/* Footer Section */
.footer {
    text-align: center;
    padding: 15px;
    background-color: #f4f6f9;
    font-size: 14px;
    color: #777;
    margin-top: auto;
}

/* Profile Section */
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

/* Custom card colors */
.card-group {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
}

.card {
    border-radius: 10px;
    margin: 0;
    text-decoration: none;
    height: 150px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card.blue {
    background-color: #007bff;
    color: white;
}

.card.yellow {
    background-color: #ffc107;
    color: white;
}

.card.green {
    background-color: #28a745;
    color: white;
}

.card.red {
    background-color: #dc3545;
    color: white;
}

.card .card-body {
    display: flex;
    align-items: center;
    padding: 20px;
    justify-content: flex-start;
}

.card i {
    font-size: 24px;
    margin-right: 15px;
}

.card h4 {
    font-size: 18px;
    margin-top: 10px;
}

/* Hover effect: card lifts up and casts a shadow */
.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

/* Responsive Styles */
@media (max-width: 1024px) {
    /* Adjust the sidebar */
    .sidebar {
        width: 200px;
    }

    .main-content {
        margin-left: 200px;
        padding: 20px;
    }
}

@media (max-width: 768px) {
    /* Responsive layout for tablets and smaller screens */
    .dashboard-container {
        flex-direction: column;
    }

    /* Adjust sidebar */
    .sidebar {
        position: fixed;
        width: 100%;
        height: auto;
        top: 0;
        left: 0;
        transform: translateX(-100%); /* Hide by default */
    }

    .sidebar.open {
        transform: translateX(0); /* Slide in */
    }

    .main-content {
        margin-left: 0;
    }

    .header h2 {
        font-size: 24px;
    }

    /* Adjust cards for small screens */
    .card-group {
        flex-direction: column;
        gap: 20px;
    }

    .card {
        height: auto;
        width: 100%;
    }

    .profile-section {
        flex-direction: column;
        align-items: flex-start;
        padding: 20px;
    }
}

/* Hamburger menu styles (for small screens) */
.hamburger-menu {
    display: none;
    cursor: pointer;
}

.hamburger-menu span {
    display: block;
    width: 30px;
    height: 3px;
    background-color: white;
    margin: 6px 0;
}

/* Show hamburger menu for smaller screens */
@media (max-width: 768px) {
    .hamburger-menu {
        display: block;
        z-index: 110; /* Make sure it's above the sidebar */
    }
}

    </style>
    </body>
    </html>