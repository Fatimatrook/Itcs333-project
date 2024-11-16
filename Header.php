<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>IT Room Booking System</title>
    <style>
        :root{
        --first-color:#243642;
        --seconed-color: #387478;
        --third-color:#629584;
        --forth-color: #E2F1E7;}

        /* About Us Section Styling */
        #about-us {
            background-color: var(--forth-color); 
            padding: 50px 20px;
            text-align: center;
            color: var(--first-color);
            font-family: 'Arial', sans-serif;}

        #about-us h2 {
            font-size: 40px;
            color: var(--first-color); 
            margin-bottom: 20px;}
        
        #about-us h2 span {
            font-size: 40px;
            color: var(--seconed-color); 
            margin-bottom: 20px;}    

        #about-us p {
            font-size: 18px;
            line-height: 1.6;
            max-width: 900px;
            margin: 0 auto 20px auto;}

        #about-us .btn {
            background-color: var(--first-color);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 20px;
            transition: 0.3s ease;}

        #about-us .btn:hover {
            background-color: var(--seconed-color);}

        /* Contact Us Section Styling */
        #contact-us {
            background-color: var(--forth-color); 
            padding: 50px 20px;
            text-align: center;
            color: var(--first-color);
            font-family: 'Arial', sans-serif;}

        #contact-us h2 {
            font-size: 40px;
            color: var(--first-color); 
            margin-bottom: 20px;}
        
        #contact-us h2 span{
            font-size: 40px;
            color: var(--seconed-color); 
            margin-bottom: 20px;}    

        #contact-us p {
            font-size: 18px;
            line-height: 1.6;
            max-width: 900px;
            margin: 0 auto 20px auto;}

        /* Contact Form Styling */
        #contact-us form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            text-align: left;}

        #contact-us .form-group {margin-bottom: 20px;}

        #contact-us label {
            font-size: 16px;
            color: #34495e;
            display: block;
            margin-bottom: 8px;}

        #contact-us textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-size: 16px;
            color: #2c3e50;
            resize: vertical; /* Allow vertical resizing of the textarea */
        }

        #contact-us button[type="submit"] {
            background-color: var(--first-color);
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        #contact-us button[type="submit"]:hover {
            background-color: var(--seconed-color);
        }

        #contact-us textarea:focus,
        #contact-us button[type="submit"]:focus {
            outline: none;
            border-color: var(--seconed-color);
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            #about-us h2, #contact-us h2 {
                font-size: 28px; 
            }

            #about-us p, #contact-us p {
                font-size: 16px;
            }

            #contact-us form {
                padding: 20px;
            }

            #contact-us button[type="submit"] {
                font-size: 14px;
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
    
    <!--Header start-->    
    <header class="header">
        
        <!-- this is for  uob logo-->
        <a href="#" class="logo"><img src="images/UOB LOGO.png" alt="uob logo"></a>
        <!-- this is for  uob logo end-->    
        <!--navbar-->
        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="login.php">Login</a>
            <a href="#about-us">About us</a>
            <a href="profile.php">Profile</a>
            <a href="#rooms">Rooms</a>
            <a href="#contact">Contact us</a>
            <a href="#reviews">Reviews</a>
        
        </nav>
        <!--navbar end-->
        <div class="icons">
            <div class="fas fa-search" id="search-btn"></div>
            <div class="fas fa-bars" id="menu-btn"></div>
        </div>

        <div class="search-form">
            <input type="search" id="search-box" placeholder="search here...">
            <label for="search-box" class="fas fa-search"></label>
        </div>
    </header>
