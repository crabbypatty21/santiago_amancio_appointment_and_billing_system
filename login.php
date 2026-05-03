<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection using Environment Variables with local XAMPP fallbacks
    $host = getenv('DB_HOST') ?: 'localhost';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
    $db   = getenv('DB_NAME') ?: 'finaldb';

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verify user
    $stmt = $conn->prepare("SELECT user_id, password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            header("Location: index.php"); // Redirect to home page
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this email.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santiago-Amancio Dental Clinic - Log In</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <div class="header-title">
            <div class="title-line1">SANTIAGO-AMANCIO</div>
            <div class="title-line2">DENTAL CLINIC</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="logo-container">
            <img src="pictures/log.png" alt="Dental Clinic Logo">
        </div>
    
        <!-- Login Form -->
        <div class="login-container" style="display: block;">
            <h3>
                <img src="pictures/tooth.png" alt="Tooth Icon" class="tooth-icon"> 
                LOG IN
            </h3>
            <form action="login.php" method="POST">
            <div class="container">
  
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email Address:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="login" name="login">
            </div>
            <p><a href="signup.php" class="signup-link">Don't have an account? Sign Up</a></p>
            </div>
            </form>
        </div>
    </div>
<style>
    /* Reset styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Times New Roman', Times, serif;
        background-color: #ffffff;
    }

    .main-content {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 50px;
        padding-top: 100px;
        max-height: calc(100vh - 80px);
        overflow-y: auto;
        background-color: #fff;
    }

    /* Header styles */
    .header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        padding: 20px 10%;
        background: #00abf0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 100;
    }

    .header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        padding: 15px 5%;
        background: #00abf0;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        z-index: 100;
    }

    .header-title {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .header-title .title-line1 {
        font-size: 24px;
        font-weight: 700;
        color: blue;
        text-shadow: 2px 2px 4px white;
    }

    .header-title .title-line2 {
        font-size: 32px;
        font-weight: 700;
        color: white;
        text-shadow: 2px 2px 4px black;
    }


    /* Navigation links styling */
    .nav-links {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .nav-links a {
        font-size: 18px;
        color: #ededed;
        text-decoration: none;
        font-weight: 600;
        position: relative;
        transition: color 0.3s;
    }

    .nav-links a:hover,
    .nav-links a.active {
        color: blue;
    }

    .nav-links a::after {
        content: '';
        display: block;
        width: 0;
        height: 2px;
        background: blue;
        transition: width 0.3s;
        position: absolute;
        left: 0;
        bottom: -5px;
    }

    .nav-links a:hover::after {
        width: 100%;
    }

    /* Logo section */
    .logo-container {
        width: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .logo-container img {
        max-width: 100%;
        height: auto;
    }

    /* Login and Sign Up form section */
    .login-container {
        width: 100%;
        max-width: 500px;
        margin: auto;
        background-color: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .login-container input {
        width: 100%;
        padding: 15px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 16px;
        background-color: #f9f9f9;
    }

    .login-container button {
        width: 100%;
        padding: 15px;
        margin-top: 20px;
        font-size: 18px;
        color: white;
        background-color: #00bfff;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .login-container button:hover {
        background-color: #009ad6;
    }

    .login-container h3 {
        font-size: 24px;
        font-weight: 600;
        color: #00abf0;
        margin-bottom: 20px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }

    .login-container a {
        color: #2660b7;
        text-decoration: none;
        display: block;
        text-align: center;
        margin-top: 10px;
    }
    .tooth-icon {
            width: 60px;
            height: 60px;
            margin-right: 10px;
        }

    /* Responsive styles */
    @media (max-width: 768px) {
        .header {
            padding: 15px 5%;
            flex-direction: column;
            align-items: center;
        }

        .header-title {
            text-align: center;
        }

        .header-title .title-line1 {
            font-size: 24px;
        }

        .header-title .title-line2 {
            font-size: 35px;
        }

        .nav-links {
            gap: 10px;
        }

        .main-content {
            flex-direction: column;
            padding: 20px;
            height: auto;
        }

        .logo-container {
            width: 100%;
            margin-bottom: 20px;
        }

        .login-container {
            padding: 20px;
        }

        .login-container h3 {
            font-size: 20px;
        }

        .login-container input,
        .login-container button {
            font-size: 14px;
        }
    }

    @media (max-width: 480px) {
        .header {
            padding: 15px 2%;
        }

        .header-title .title-line1 {
            font-size: 18px;
        }

        .header-title .title-line2 {
            font-size: 28px;
        }

        .nav-links {
            flex-direction: column;
            align-items: center;
        }

        .nav-links a {
            font-size: 14px;
        }

        .login-container {
            padding: 15px;
        }

        .login-container h3 {
            font-size: 16px;
        }

        .login-container input,
        .login-container button {
            font-size: 12px;
        }
    }
</style>


</body>
</html>