<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santiago-Amancio Dental Clinic</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    
</head>
<body>

     <!-- Header section -->
     <div class="header">
    <div class="header-title">
        <div class="title-line1">SANTIAGO-AMANCIO</div>
        <div class="title-line2">DENTAL CLINIC</div>
    </div>

    <div class="nav-links">
        <a href="index.php">HOME</a>
        <a href="about.php">ABOUT US</a>
        <a href="services.php">SERVICES</a>
        <a href="pro.php">PROFILE</a>
        <a href="login.php">LOG OUT</a>
    </div>
<!-- Hamburger Menu Icon -->
<div class="hamburger-menu">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const hamburgerMenu = document.querySelector(".hamburger-menu");
    const navLinks = document.querySelector(".nav-links");

    hamburgerMenu.addEventListener("click", () => {
        navLinks.classList.toggle("active");
    });
});
</script>
    <br>
    <br>
    <br>
    <br>
    <!-- Main content section with logo and service boxes -->
    <div class="main-content">
        <!-- Left side with logo -->
        <div class="logo-container">
            <img src="pictures/logo.jpg" alt="Santiago-Amancio Dental Clinic Logo">
        </div>
    

        <div class="container">
            <div class="box">
                <img src="pictures/Oral.jpeg" alt="Oral Consultation">
                <div class="service-title">ORAL CONSULTATION</div>
                <div class="service-description">Get a thorough examination of your oral health and receive personalized recommendations.</div>
            </div>
            <div class="box">
                <img src="pictures/toothex.jpg" alt="Tooth Extraction">
                <div class="service-title">TOOTH EXTRACTION</div>
                <div class="service-description">Safe and painless tooth extraction procedures to alleviate your discomfort.</div>
            </div>
            <div class="box">
                <img src="pictures/ortho.jpeg" alt="Orthodontics">
                <div class="service-title">ORTHODONTICS</div>
                <div class="service-description">Expert orthodontic care to straighten your teeth and improve your smile.</div>
            </div>
            <div class="box">
                <img src="pictures/cleaning.jpg" alt="Oral Cleaning">
                <div class="service-title">ORAL TOOTH CLEANING</div>
                <div class="service-description">Professional cleaning to remove plaque and tartar, ensuring a healthy mouth.</div>
            </div>
            <div class="box">
                <img src="pictures/filling.jpg" alt="Tooth Filing">
                <div class="service-title">TOOTH FILING</div>
                <div class="service-description">Restorative procedures for cavities and damaged teeth to restore their function.</div>
            </div>
            <div class="box">
                <img src="pictures/canal.jpg" alt="Root Canal Therapy">
                <div class="service-title">ROOT CANAL THERAPY</div>
                <div class="service-description">Comprehensive root canal treatment to save your tooth and relieve pain.</div>
            </div>
            <div class="box">
                <img src="pictures/dentures.jpeg" alt="Dentures">
                <div class="service-title">DENTURES</div>
                <div class="service-description">Custom-made dentures to restore your smile and improve chewing function.</div>
            </div>
            <div class="box">
                <img src="pictures/jacket.jpg" alt="Jacket Crown and Bridge">
                <div class="service-title">JACKET CROWN AND BRIDGE</div>
                <div class="service-description">Durable crowns and bridges to enhance your smile and restore your bite.</div>
            </div>
            <div class="box">
                <img src="pictures/surgery.png" alt="Dental Surgery">
                <div class="service-title">DENTAL SURGERY</div>
                <div class="service-description">Advanced surgical procedures for various dental conditions and concerns.</div>
            </div>
        </div>
        
    </div>

    <script>
        // Function to trigger animations for elements one by one
        window.onload = function() {
            const container = document.querySelector('.container');
            const boxes = document.querySelectorAll('.box');

            // Show container with animation
            container.style.opacity = 1;
            container.style.animation = 'fadeInUp 0.5s forwards';

            // Trigger animations for each box with delay
            boxes.forEach((box, index) => {
                setTimeout(() => {
                    box.style.opacity = 1;
                    box.style.animation = 'fadeIn 0.5s forwards';
                }, index * 200); // Delay each box appearance
            });
        }
    </script>
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
    overflow-x: hidden; /* Prevent horizontal scrolling */
}

/* Header styles */
.header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 20px 5%;
    background: #00abf0;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    z-index: 100;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.header-title {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.header-title .title-line1 {
    font-size: 26px;
    font-weight: 700;
    color: blue;
    text-shadow: 2px 2px 4px white;
}

.header-title .title-line2 {
    font-size: 36px;
    font-weight: 700;
    color: white;
    text-shadow: 2px 2px 4px black;
}

/* Navigation links styling */
.nav-links {
    display: flex;
    align-items: center;
}

.nav-links a {
    font-size: 20px;
    color: #ededed;
    text-decoration: none;
    font-weight: 600;
    margin-left: 30px;
    transition: color 0.3s;
    position: relative;
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

/* Main content styling */
.main-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 20px;
    width: 100%;
    margin-top: 80px; /* Ensure it doesn't hide behind the fixed header */
}

/* Styling for the logo and text on the left */
.logo-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50%;
    text-align: center;
}

.logo-container img {
    width: 80%;
    max-width: 500px;
}

/* Service description styles */
.service-description {
    font-size: 1rem;
    color: #333;
    margin-top: 5px;
    padding: 10px;
    background-color: #e9ecef;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s;
}

.box:hover .service-description {
    background-color: #d0e8ff;
}

/* Styling for the service boxes */
.container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    width: 80%;
    margin-left: auto;
    margin-right: auto;
    padding: 20px;
    padding-bottom: 80px;
}

.box {
    padding: 20px;
    text-align: center;
    font-size: 1.2rem;
    transition: transform 0.3s ease, background-color 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    position: relative;
    background-color: #f8f9fa;
}

.box img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    margin-bottom: 10px;
}

/* Animation keyframes */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hamburger Menu styles */
.hamburger-menu {
    display: none;
    flex-direction: column;
    justify-content: space-between;
    width: 30px;
    height: 24px;
    cursor: pointer;
    z-index: 110;
}

.hamburger-menu .line {
    height: 4px;
    background-color: white;
    border-radius: 2px;
}

/* Show hamburger menu on smaller screens */
@media (max-width: 768px) {
    .hamburger-menu {
        display: flex;
    }

    .nav-links {
        display: none;
        flex-direction: column;
        position: absolute;
        top: 70px;
        right: 0;
        background-color: #00abf0;
        width: 100%;
        text-align: center;
        z-index: 100;
    }

    .nav-links.active {
        display: flex;
    }

    .main-content {
        flex-direction: column;
        align-items: center;
    }

    .logo-container {
        width: 100%;
        padding: 10px;
    }

    .logo-container img {
        width: 90%;
    }

    .container {
        grid-template-columns: 1fr; /* One column on small screens */
        width: 90%; /* Slightly smaller width */
    }

    .box {
        font-size: 1rem; /* Slightly smaller font size for smaller screens */
    }

    .service-description {
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    /* Further adjustment for very small screens */
    .header {
        padding: 15px 5%;
    }

    .header-title .title-line1 {
        font-size: 22px;
    }

    .header-title .title-line2 {
        font-size: 28px;
    }

    .nav-links a {
        font-size: 16px;
    }

    .main-content {
        padding: 15px;
    }

    .container {
        grid-template-columns: 1fr; /* Single column on very small screens */
        padding: 10px;
    }

    .box img {
        width: 80px;
        height: 80px;
    }
}

    </style>
</body>
</html>
