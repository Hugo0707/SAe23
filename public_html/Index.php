<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS for the page-->
    <link rel="stylesheet" href="./Style/style.css">
    <link rel="icon" href="./Images/IOT_Logo.png" type="image/gif">
    <title>Home</title>
</head>
<body>
    <header>
        <nav class="nav">
            <span class="title">SAE 23</span>
            <ul class="pages">
                <li><a class="effect-underline" href="./index.php">Home</a></li>
                <li><a class="effect-underline" href="./sensors.php">Sensors</a></li>
                <li><a class="effect-underline" href="./contact.php">Contact</a></li>
                <li><a class="effect-underline" href="./legal_Information.php">Legal Notice</a></li>
                <li><a class="effect-underline" href="./ourwork.php">Our work</a></li>
            </ul>
            <?php 
            if (isset($_SESSION['grade'])) {
                if ($_SESSION['grade'] === 'Admin' ) {
                    echo "<span class='main_btn'><a href='./connection.php'>Admin</a></span>";
                }
                elseif ($_SESSION['grade'] === 'Manager') {
                    echo "<span class='main_btn'><a href='./connection.php'>Manager</a></span>";
                }}
                else {
                    echo "<span class='main_btn'><a href='./connection.php'>Log In</a></span>";
                }
            
            ?>
        </nav> 
    </header>
    <section class="background">
        <div class="circle one"></div>
        <div class="circle two"></div>
        <div class="circle three"></div>
        <div class="circle four"></div>
        <div class="circle five"></div>
        <div class="circle sixe"></div>
    </section>
    <section class="main">
    <!-- If No JS -->    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('js-message').style.display = 'none';
        });
        </script>

        <div id="js-message" style="display: block;">
            <center> <h1> Please enable JavaScript to allow the site to function properly. </h1> </center>
        </div>
    </script>
        <ul class="home">
            <li>
                <ul class="text">
                    <li><h1>Who we are</h1></li>
                    <li>
                        <p>We are 4 students in the first year of a Bachelor's degree in Networks and Telecommunications at the IUT in Blagnac. SAE 23 is one of our biggest projects of this first year.</p>
                    </li>
                    <li><h1>A bit of context</h1></li>
                    <li>
                        <p>We carried out this project with the aim of improving working conditions in a company. To do this, we had to find a way of facilitating day-to-day work, by creating a dynamic web site enabling direct consultation of the values returned by various sensors located around the IUT. This site also enables the administration of the various managers and sensors.</p>
                    </li>
                    <li><h1>How it works</h1></li>
                    <li>
                        <p>Our site works in several stages, the first is the recovery of data sent by the several sensors. To achieve this, we have set up a bash script that gathers the data and exports it in the right format to the database.
                        Then we use php scripts to integrate the data into our site. We have also set up filters to improve the reading of this data.
                        As mentioned above, our site also enables the administration of sensors and building managers. To enable this, we have set up a login and password system to allow access to these options. To find out more, please visit the "Our work" page, where we describe our work in detail.
                        </p>
                    </li>
                </ul>
            </li>
            <li><img src="./Images/IOT.png" alt="IOT Diagram"></li>
        </ul>
    </section>
    <footer>
        <ul>
            <li><a href="https://www.iut-blagnac.fr/fr/departement-rt" target="_blank" class="footer_text">IUT of Blagnac R&T Department</a></li>
            <li><a href="./legal_Information.php" class="footer_text" >© Copyright 2023 All rights reserved</a></li>
            <li><a href="https://www.linkedin.com/in/gabin-lopez-168bb525b" target="_blank" class="footer_text" >Lopez</a></li>
            <li><a href="https://www.linkedin.com/in/hugo-calmels-50a51727b" target="_blank" class="footer_text" >Calmels</a></li>
            <li><a href="https://www.linkedin.com/in/yassir-boulouiha-gnaoui-9b226027b/" target="_blank" class="footer_text" >Boulouiha</a></li>
            <li><a href="https://www.linkedin.com/in/baptiste-alteirac" target="_blank" class="footer_text" >Alteirac</a></li>
        </ul>
    </footer>
</body>
</html>