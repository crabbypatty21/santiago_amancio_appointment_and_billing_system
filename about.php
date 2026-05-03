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
    <div class="hamburger-menu">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div class="nav-links">
        <a href="index.php">HOME</a>
        <a href="about.php">ABOUT US</a>
        <a href="services.php">SERVICES</a>
        <a href="pro.php">PROFILE</a>
        <a href="login.php">LOG OUT</a>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const hamburgerMenu = document.querySelector(".hamburger-menu");
        const navLinks = document.querySelector(".nav-links");

        // Toggle the visibility of nav-links on click
        hamburgerMenu.addEventListener("click", () => {
            navLinks.classList.toggle("active");
        });
    });
</script>

    <!-- About Us Section -->
    <div class="about-section" id="about">
        <br>
<br>
<br>
        <!-- Text Content -->
        <div class="about-text">
            <h2>Welcome to Santiago-Amancio Dental Clinic</h2>
            <p>Welcome to Santiago-Amancio Dental Clinic, where your smile is our passion! Our clinic is dedicated to providing high-quality dental care in a warm and friendly environment.</p>
            <p>At Santiago-Amancio, we understand that each patient is unique, which is why we take the time to listen to your needs and concerns. Our experienced team of dental professionals is committed to offering personalized treatment plans that cater to your individual goals, whether it’s routine preventive care, restorative treatments, or cosmetic enhancements.</p>
            <p>Equipped with the latest technology and techniques, our state-of-the-art facility ensures that you receive the best care possible. We prioritize patient comfort and education, helping you make informed decisions about your dental health.</p>
            <p>From the moment you walk through our doors, you’ll be greeted with a smile. We believe that a positive dental experience can make all the difference, and our friendly staff is here to support you every step of the way.</p>
            <p>Thank you for choosing Santiago-Amancio Dental Clinic. We look forward to partnering with you on your journey to a healthier, brighter smile!</p>
        </div>

        <!-- Images on the Right -->
        <div class="about-image-right">
            <img src="pictures/e.jpg" alt="Dental image 1">
            <br><br><br>
            <img src="pictures/d.jpg" alt="Dental image 2">
        </div>
    </div>

    <!-- Map Section -->
    <div class="map-section">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3856.8873506821527!2d120.95667741444122!3d14.75539507859217!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b2ab33c7aeab%3A0x4c5a0b7c7d7e586e!2sMarilao%2C%20Bulacan%2C%20Philippines!5e0!3m2!1sen!2sph!4v1605078834172!5m2!1sen!2sph"
            width="600" 
            height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div>

    <!-- Contact and Hours Section -->
    <div class="contact-hours-section">
        <!-- Clinic Hours -->
        <div class="clinic-hours">
            <h3>Clinic hours</h3>
            <p><strong>Monday, Saturday:</strong><br>1:00 pm to 3:00 pm</p>
            <p><strong>Closed on Sunday</strong></p>
        </div>

        <!-- Clinic Info -->
        <div class="clinic-info">
            <h3>Our Clinic</h3>
            <p>0447 Santiago road St.<br>Lambakin, Marilao Bulacan</p>
            <p>(123) 456-7890<br>sherryl@gmail.com</p>

           

            <!-- Social Media Icons -->
            <div class="social-icons">
                <a href="https://www.facebook.com/sherry.antonio.7"><img src="facebook.png" alt="Facebook"></a>
            </div>
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
       color: #333;
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
        justify-content: space-between;
        align-items: center;
        z-index: 100;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        flex-wrap: wrap;
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

   /* About Us section */
   .about-section {
        padding: 50px;
        max-width: 1200px;
        margin: auto;
        display: flex;
        align-items: flex-start;
        gap: 20px;
        margin-top: 80px;
        flex-direction: row;
   }

   .about-text {
        flex: 2;
        text-align: justify;
        line-height: 1.6;
   }

   .about-text h2 {
        font-size: 32px;
        color: #00abf0;
        margin-bottom: 20px;
        font-weight: bold;
        text-align: left;
   }

   .about-text p {
        font-size: 18px;
        margin: 15px 0;
   }

   .about-image-left,
   .about-image-right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
   }

   .about-image-left img,
   .about-image-right img {
        width: 100%;
        max-width: 300px;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        margin-top: 20px;
   }

   /* Contact and Hours Section */
   .contact-hours-section {
        background-color: #00abf0;
        padding: 10px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        text-align: center;
        color: white;
        margin-top: 20px;
   }

   .clinic-hours,
   .clinic-info {
        font-size: 18px;
        line-height: 1.6;
   }

   .clinic-hours h3,
   .clinic-info h3 {
        font-size: 24px;
        color: blue;
        margin-bottom: 10px;
        font-weight: bold;
   }

   /* Social Media Icons */
   .social-icons {
        display: flex;
        gap: 15px;
        margin-top: 20px;
   }

   .social-icons a img {
        width: 30px;
        height: 30px;
        filter: grayscale(100%);
        transition: filter 0.3s;
   }

   .social-icons a img:hover {
        filter: grayscale(0%);
   }

   /* Map styling */
   .map-section {
        display: flex;
        justify-content: center;
        margin-top: 20px;
   }
   
   /* Responsive styles */
   @media (max-width: 768px) {
        .header {
            padding: 15px 5%;
        }

        .header-title .title-line1 {
            font-size: 24px;
        }

        .header-title .title-line2 {
            font-size: 28px;
        }

        .nav-links a {
            font-size: 16px;
            margin-left: 15px;
        }

        .about-section {
            padding: 20px;
            flex-direction: column;
        }

        .about-image-left img,
        .about-image-right img {
            max-width: 100%;
        }

        .contact-hours-section {
            flex-direction: column;
            padding: 20px;
            gap: 15px;
        }

        .contact-hours-section .clinic-hours,
        .contact-hours-section .clinic-info {
            text-align: center;
            font-size: 16px;
        }
   }

   @media (max-width: 480px) {
        .header {
            padding: 20px 2%;
        }

        .header-title .title-line1 {
            font-size: 20px;
        }

        .header-title .title-line2 {
            font-size: 24px;
        }

        .nav-links a {
            font-size: 14px;
            margin-left: 10px;
        }

        .about-text h2 {
            font-size: 22px;
        }

        .about-text p {
            font-size: 16px;
        }

        .clinic-hours h3,
        .clinic-info h3 {
            font-size: 18px;
        }
   }

   /* Hamburger Menu */
   .hamburger-menu {
        display: none;
        flex-direction: column;
        cursor: pointer;
        gap: 5px;
   }

   .hamburger-menu div {
        width: 25px;
        height: 3px;
        background-color: white;
        transition: transform 0.3s ease;
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

        .nav-links a {
            margin-left: 0;
            padding: 10px 0;
        }
   }
</style>
</body>
</html>
