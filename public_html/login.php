<?php
    session_start();
    if (empty($_POST["login"]) || empty($_POST["passwd"])) 
    {
        header('Location: ./connection.php');
        exit();
    }
    require_once("../config/config.php");
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
    <title>Connection in progress...</title>
</head>
<body>
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
        <?php       
            
            //Database connection
            try {
                $id_bd = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
            } 
            catch(Exception) {
                die("DATABASE CONNECTION ERROR PLEASE CONTACT THE ADMINISTRATOR");
            }
        
            //Recovering logins
            try {
                $result = mysqli_query($id_bd, "SELECT * FROM `view_login`");
            
            } catch (Exception) {
               die("ERROR DATA RECOVERY FAILED PLEASE CONTACT THE ADMINISTRATOR");
            }
        
            //Placement of login and mdp in the credentials table
            $credentials = fetchResults($result);
        
            $login = $_POST["login"];
            $passwd = $_POST["passwd"];
        
            $known = false;
            for ($i=0; $i < count($credentials) ; $i++) { 
                if (password_verify($passwd, $credentials[$i][1]) && $login == $credentials[$i][0] ) {
                    $known=true;
                    $_SESSION["login"] = $credentials[$i][0];
                    $_SESSION["grade"] = $credentials[$i][2];
                    echo "<center> <h1> Connexion réussie ! </h1>";
                    echo "Vous êtes : " . $credentials[$i][2] . "</center>" ;

                    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Admin"))
                    {
                        echo '<script> window.location.href = "./admin.php"; </script>';
                    }
                    elseif ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Manager")) {
                        $_SESSION['building'] = $credentials[$i]['Building'];
                        echo '<script> window.location.href = "./manager.php"; </script>';
                    }
                     
                }
            }
            if (!$known) {
                echo '<center> <h1> Login or Password Incorrect ! </h1> </center>';
                echo '
                <script>
                    setTimeout(function() {
                        window.location.href = "./connection.php";
                    }, 1500); 
                </script>';
            }
        
        ?>

    </section>
    <footer>
        <ul>
            <li><a href="https://www.iut-blagnac.fr/fr/departement-rt" target="_blank" class="footer_text">IUT of Blagnac R&T Department</a></li>
            <li><a href="#" class="footer_text" >© Copyright 2023 All rights reserved</a></li>
            <li><a href="#" target="_blank"><img class="img_footer" src="./Images/HTML5.png" alt="HTML 5 Validation"></a></li>
            <li><a href="#" target="_blank"><img class="img_footer" src="./Images/CSS3.png" alt="CSS 3 Validation"></a></li>
        </ul>
    </footer>
</body>
</html>