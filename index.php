<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santiago-Amancio Dental Clinic</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

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

    <!-- Main content section -->
    <div class="container">
        <div class="tagline">
            "Crafting Beautiful Smiles with Care, Precision, and Compassion—Your Journey to Optimal Dental Health Begins Here!"
        </div>
        
        <div class="form-btn">
            <a href="form.php" class="btn btn-primary book-btn">Book An Appointment</a>
        </div>
    
        <div class="logo-container">
            <img src="pictures/logo.jpg" alt="Santiago-Amancio Dental Clinic Logo">
        </div>
    </div>
    
    <script>
        window.onload = function() {
            const container = document.querySelector('.container');
            const tagline = document.querySelector('.tagline');
            setTimeout(() => {
                tagline.style.opacity = 1;
                tagline.style.animation = 'fadeIn 0.5s forwards';
            }, 500);
            container.style.opacity = 1;
            container.style.animation = 'fadeInUp 0.5s forwards';
        }
    </script>
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
        padding: 25px 5%;
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

    .title-line1, .title-line2 {
        margin: 0; /* Para walang dagdag na espasyo */
        line-height: 1; /* Bawasan ang default line spacing */
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
    transition: all 0.3s ease;
}

/* By default, hide nav-links in mobile view */
.nav-links {
    display: none;
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

   /* Show nav-links when hamburger is clicked */
.nav-links.active {
    display: flex;
    flex-direction: column;
    position: absolute;
    top: 100%;
    right: 0;
    background-color: #00abf0; /* Matches header background */
    width: 100%; /* Full-width dropdown */
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 101;
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


.nav-links {
    display: flex;
    align-items: center;
    justify-content: flex-end; /* Ensure links are on the right */
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
    .container {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        padding: 60px;
        gap: 40px;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.5s forwards;
    }

    /* Logo styling */
    .logo-container {
        margin-top: 20px;
        flex: 1 1 300px;
    }

    .logo-container img {
        width: 100%;
        height: auto;
        border-radius: 20%;
        max-width: 500px;
    }

    .clinic-name {
        font-size: 50px;
        font-weight: 700;
        letter-spacing: 2px;
        color: blue;
        text-shadow: 2px 2px 4px white;
    }

    .clinic-subtitle {
        font-size: 60px;
        font-weight: 600;
        margin-top: -10px;
        color: blue;
        text-shadow: 2px 2px 4px white;
    }

   /* Tagline styling */
.tagline {
    font-size: 22px;
    font-style: italic;
    color: black;
    max-width: 500px;
    line-height: 1.5;
    text-align: left;
    background-color: rgba(240, 248, 255, 0.9); /* Less transparent background */
    padding: 20px; /* Increased padding for better spacing */
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    border: 2px solid #0033cc;
    flex: 1 1 300px;
    animation: fadeIn 0.5s forwards;
    text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3); /* Added text shadow for visibility */
}

    /* Button styling */
    .form-btn {
        font-family: 'Times New Roman', Times, serif;
        position: absolute;
        bottom: 200px;
        width: 100%;
        text-align: left;
        padding-left: 150px;
    }

    .book-btn {
        background-color: #00abf0;
        color: white;
        padding: 10px 20px;
        font-weight: bold;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .book-btn:hover {
        background-color: blue;
    }
    /* Hamburger menu styling */
.hamburger-menu {
    display: none; /* Hide by default on larger screens */
    flex-direction: column;
    gap: 5px;
    cursor: pointer;
}

.hamburger-menu div {
    width: 25px;
    height: 3px;
    background-color: white;
    border-radius: 5px;
    transition: all 0.3s ease;
}

/* Display hamburger menu on small screens */
@media (max-width: 768px) {
    .hamburger-menu {
        display: flex; /* Show on small screens */
    }
}

/* Hamburger icon open state (optional: if you want animation) */
.hamburger-menu.active div:nth-child(1) {
    transform: rotate(45deg);
    position: relative;
    top: 8px;
}

.hamburger-menu.active div:nth-child(2) {
    opacity: 0;
}

.hamburger-menu.active div:nth-child(3) {
    transform: rotate(-45deg);
    position: relative;
    top: -8px;
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

    /* Responsive styles */
    @media (max-width: 768px) {
        .header {
            padding: 20px 5%;
        }

        .header-title .title-line1 {
            font-size: 24px;
        }

        .header-title .title-line2 {
            font-size: 35px;
        }

        .nav-links a {
            font-size: 16px;
            margin-left: 15px;
        }

        .container {
            padding: 30px;
            flex-direction: column;
            gap: 20px;
        }

        .logo-container img {
            max-width: 350px;
        }

        .tagline {
            font-size: 18px;
        }

        .form-btn {
            padding-left: 0;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .header {
            padding: 15px 5%;
        }

        .header-title .title-line1 {
            font-size: 20px;
        }

        .header-title .title-line2 {
            font-size: 30px;
        }

        .nav-links a {
            font-size: 14px;
            margin-left: 10px;
        }

        .logo-container img {
            max-width: 300px;
        }

        .tagline {
            font-size: 16px;
        }
    }
    /* Responsive styles */
@media (max-width: 768px) {
    /* Tagline adjustments for smaller screens */
    .tagline {
        font-size: 18px; /* Smaller font size */
        max-width: 100%; /* Full width for smaller screens */
        padding: 10px; /* Reduced padding */
        text-align: center; /* Center-align the text */
    }

    /* Form button adjustments for smaller screens */
    .form-btn {
        position: relative;
        bottom: auto; /* Remove bottom positioning */
        text-align: center; /* Center align the button */
        padding-left: 0; /* Remove padding */
    }

    .book-btn {
        width: 80%; /* Make the button smaller */
        padding: 12px; /* Adjust padding */
    }
}

@media (max-width: 480px) {
    /* Further adjustments for very small screens */
    .tagline {
        font-size: 16px; /* Even smaller font size */
        padding: 8px; /* Reduce padding even more */
    }

    .form-btn {
        padding-left: 0; /* Ensure no left padding */
        padding-top: 20px; /* Add some space at the top */
    }

    .book-btn {
        width: 90%; /* Slightly wider button */
        padding: 14px; /* Increase button padding for touch */
    }
}

</style>

</body>
</html>
