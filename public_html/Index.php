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
                <li><a class="effect-underline" href="./Index.php">Home</a></li>
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
        <ul class="home">
            <li>
                <ul class="text">
                    <li><h1>Who we are</h1></li>
                    <li>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                    </li>
                    <li><h1>A bit of context</h1></li>
                    <li>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                    </li>
                    <li><h1>How it works</h1></li>
                    <li>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                    </li>
                </ul>
            </li>
            <li><img src="./Images/IOT.png" alt="IOT Diagram"></li>
        </ul>
    </section>
    <footer>
        <ul>
            <li><a href="https://www.iut-blagnac.fr/fr/departement-rt" target="_blank" class="footer_text">IUT de Blagnac Département R&T</a></li>
            <li><a href="#" class="footer_text" >© Copyright 2023 All rights reserved</a></li>
            <li><a href="#" target="_blank"><img class="img_footer" src="./Images/HTML5.png" alt="HTML 5 Validation"></a></li>
            <li><a href="#" target="_blank"><img class="img_footer" src="./Images/CSS3.png" alt="CSS 3 Validation"></a></li>
        </ul>
    </footer>
</body>
</html>