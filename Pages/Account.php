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
    <link rel="stylesheet" href="../Style/style.css">
    <link rel="icon" href="../Images/IOT_Logo.png" type="image/gif">
    <title>Account</title>
</head>
<body>
    <div id="js-message" style="display: block;">
        <center> <h1> Veuillez activer JavaScript pour profiter pleinement de notre site. </h1> </center>
    </div>
    <header>
        <nav class="nav">
            <span class="title">SAE 23</span>
            <ul class="pages">
                <li><a class="effect-underline" href="../Index.html">Home</a></li>
                <li><a class="effect-underline" href="Sensors.html">Sensors</a></li>
                <li><a class="effect-underline" href="Contact.html">Contact</a></li>
                <li><a class="effect-underline" href="Legal_Information.html">Legal Notice</a></li>
            </ul>
            <span class="main_btn"><a href="Account.html">Not connected</a></span>
            <img class="burger" src="MenuBurger.png" alt="menu burger">
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
        <div>
        <h1 class="TitleAccount">Log In</h1>
        <form name="LogIn" action="./login.php" method="post">
            <label for="login">Your login :</label>
            <input type="text" id="login" name="login" required>
            <label for="passwd">Your password:</label>
            <input type="password" id="password" name="passwd" required>
            <input type="submit" value="Send">
        </form>
        </div>
    </section>
    <footer>
      <ul>
          <li><a href="https://www.iut-blagnac.fr/fr/departement-rt" target="_blank" class="footer_text">IUT de Blagnac Département R&T</a></li>
          <li><a href="#" class="footer_text" >© Copyright 2023 All rights reserved</a></li>
          <li><a href="../NotAvailable/UnderConstruction.html" target="_blank"><img class="img_footer" src="../Images/HTML5.png" alt="HTML 5 Validation"></a></li>
          <li><a href="../NotAvailable/UnderConstruction.html" target="_blank"><img class="img_footer" src="../Images/CSS3.png" alt="CSS 3 Validation"></a></li>
      </ul>
    </footer>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('js-message').style.display = 'none';
    });
</script>
</body>
</html>