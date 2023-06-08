<?php 
    session_start();

    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Admin")) 
    {
        echo '<script> window.location.href = "./admin.php"; </script>';
    }
    elseif ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Manager")) {
        echo '<script> window.location.href = "./manager.php"; </script>';
    }

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
    <title>Connection</title>
</head>
<body>
    <div id="js-message" style="display: block;">
        <center> <h1> Veuillez activer JavaScript afin de permettre au site de fonctionner correctement. </h1> </center>
    </div>
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
    <section class="mainAccount">
    <div>
        <h1 class="TitleAccount">Log In</h1>
        <form name="LogIn" action="./login.php" method="post">
            <label for="login">Your login :</label>
            <input type="text" id="login" name="login" required>
            <label for="passwd">Your password:</label>
            <input type="password" id="password" name="passwd" required>
            <input type="submit" value="Submit">
        </form>
    </div>
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
<!-- JS warning -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('js-message').style.display = 'none';
    });
</script>