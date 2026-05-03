<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Database connection using Environment Variables with local XAMPP fallbacks
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
$db   = getenv('DB_NAME') ?: 'finaldb';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch user email and patient details
$stmt = $conn->prepare(
    "SELECT u.email, p.first_name, p.last_name, p.date_of_birth, p.gender,contact_number, 
            p.city_province, p.municipality, p.barangay, p.street, p.house_no
     FROM user u
     INNER JOIN patient p ON u.user_id = p.user_id
     WHERE u.user_id = ?"
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="hamburger-menu" id="hamburgerMenu">
        <i class="fas fa-bars"></i>
    </div>

    <script>
        const hamburgerMenu = document.getElementById('hamburgerMenu');
        const sidebar = document.getElementById('sidebar');

        // Toggle Sidebar visibility when the hamburger menu is clicked
        hamburgerMenu.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    </script>

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
    <img src="https://via.placeholder.com/50" alt="User Icon" class="profile-img">
    <span class="profile-name">
        <?php echo "$first_name";?>
        
     <i class="fas fa-check-circle status-indicator"></i> <!-- Green check icon -->
        <div class="status">
            <!-- Optional additional status info -->
        </div>
    </div>
           


        <!-- Navigation Links -->
        <nav>
            <a href="form.php" class="<?= basename($_SERVER['PHP_SELF']) == 'form.php' ? 'active' : '' ?>">Book Appointment</a>
            <a href="login.php" class="<?= basename($_SERVER['PHP_SELF']) == 'logoutp.php' ? 'active' : '' ?>">Log out</a>
        </nav>
   
        </div>

       <!-- Main content -->
    <div class="main-content">
        <div class="header">
        </div>

        <div class="profile-picture">
            <img src="pictures/lei.jpg" alt="Profile Picture">
            <form action="upload.php" method="POST" enctype="multipart/form-data">  
                <input type="file" name="profile_picture" id="profile_picture">
                <button type="submit" class="btn btn-primary mt-2">Upload Picture</button>
            </form>
        </div>

        <!-- Patient Info Form -->
        <div class="profile-info-form">
            <form action="" method="POST">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" placeholder="<?php echo "$first_name $last_name"; ?> " disabled >

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="<?php echo "$email";?>" disabled>

                <label for="contact">Contact</label>
                <input type="text" id="contact" name="contact" placeholder="<?php echo "$contact_number"; ?>" disabled>

                <label for="address">Address</label>
                <input type="text" id="address" name="address" placeholder=" <?php echo "$house_no, $street, $barangay, $municipality, $city_province"; ?> "disabled >

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
        </div>
    </div>

    <footer class="footer">
        &copy; 2024 Santiago-Amancio Dental Clinic. All rights reserved.
    </footer>
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

        /* Main content section */
.main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    background-color: #ffffff;
    padding: 30px;
    justify-content: flex-start;
    overflow: auto; /* To ensure content scrolls if it overflows */
    margin-left: 250px; /* To leave space for sidebar */
}

        /* Header for main content */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #003d80;
        }

        /* Profile picture section */
        .profile-picture {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile-picture img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .profile-picture input[type="file"] {
            font-size: 16px;
        }

        /* Footer styles */
        .footer {
            text-align: center;
            padding: 15px;
            background-color: #f4f6f9;
            font-size: 14px;
            color: #777;
            margin-top: auto; /* Push the footer to the bottom */
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
    color: green; /* Green color for online */
    font-size: 18px; /* Adjust size of the check icon */
    margin-left: 10px; /* Adds spacing between the name and the check icon */
    vertical-align: middle; /* Align icon with text */
}
        /* Form Styles */
        .profile-info-form input, .profile-info-form textarea {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px;
            width: 100%;
            font-size: 16px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .profile-info-form input:focus, .profile-info-form textarea:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }
        .profile-info-form label {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

/* Ensure that the profile picture does not overlap sidebar */
.profile-picture {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 30px;
    width: 100%; /* Ensures no overflow */
    box-sizing: border-box; /* Includes padding in the width calculation */
}

/* Form styles */
.profile-info-form input, .profile-info-form textarea {
    border-radius: 8px;
    border: 1px solid #ddd;
    padding: 10px;
    width: 100%;
    font-size: 16px;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    box-sizing: border-box; /* Avoids overflow */
}

/* Profile Picture */
.profile-picture img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 15px;
}
/* Back Button Styles */
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
 /* Responsive Design */
 @media (max-width: 768px) {
            .sidebar {
                left: -250px;
                position: absolute;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .hamburger-menu {
                display: block;
            }
        }
    </style>

</body>
</html>
