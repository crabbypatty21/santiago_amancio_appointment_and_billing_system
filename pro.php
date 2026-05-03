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
            background-color: lightblue;
        }
        .dashboard-container {
            display: flex;
            height: 100vh;
            flex-direction: row;
            align: center;
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

       

        /* Footer styles */
        .footer {
            text-align: center;
            padding: 15px;
            background-color: #f4f6f9;
            font-size: 14px;
            color: #777;
            margin-top: auto; /* Push the footer to the bottom */
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
    weight: 40px;
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
        /* Responsive Design */
@media (max-width: 768px) {
    .dashboard-container {
        flex-direction: column; /* Stack items vertically */
    }

    .main-content {
        margin-left: 0; /* Remove left margin */
        padding: 15px; /* Reduce padding */
    }

    .header h2 {
        font-size: 24px; /* Smaller font size for header */
    }

    .btn-primary {
        width: 100%; /* Full width buttons */
    }

    .profile-picture img {
        width: 100px; /* Smaller profile picture */
        height: 100px; /* Smaller profile picture */
    }

    .profile-info-form input,
    .profile-info-form textarea {
        font-size: 14px; /* Smaller font size for inputs */
    }

    .back-button {
        font-size: 12px; /* Smaller font size for back button */
    }

    .sidebar {
        left: -250px; /* Hide sidebar off-screen */
        position: absolute;
        transition: left 0.3s ease; /* Smooth transition */
    }

    .sidebar.show {
        left: 0; /* Show sidebar */
    }

    .hamburger-menu {
        display: block; /* Show hamburger menu */
    }
}
    </style>

</body>
</html>
