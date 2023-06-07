<?php 
    session_start();
    
    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Admin"))
    {
        echo "Connecté en tant qu'Administrateur";
    }
    else {
        echo '<script> window.location.href = "./Account.php"; </script>';
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
    <title>Sensors</title>
</head>
<body>
    <!-- <div id="js-message" style="display: block;">
        <center> <h1> Veuillez activer JavaScript afin de permettre au site de fonctionner correctement. </h1> </center>
    </div> -->
    <header>
        <nav class="nav">
            <span class="title">SAE 23</span>
            <ul class="pages">
                <li><a class="effect-underline" href="../Index.html">Home</a></li>
                <li><a class="effect-underline" href="./sensors.php">Sensors</a></li>
                <li><a class="effect-underline" href="./contact.html">Contact</a></li>
                <li><a class="effect-underline" href="./legal_Information.html">Legal Notice</a></li>
            </ul>
            <span class="main_btn"><a href="Account.php">Log In</a></span>
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

    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <br>
            <input type="submit" name="logout" value="Logout">
        </form>


        <h3> Capteurs Crées : </h3>

        <table>
        
            <?php
                if (isset($_GET["logout"])) {   
                    session_destroy();
                    echo '<script> window.location.href = "./connection.php"; </script>';
                }
            
                //Connexion à la base de données
                try {
                    $id_bd = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
                } 
                catch(Exception $e) {
                    die("DATABASE CONNECTION ERROR : <br>" . $e);
                }
            
                //Récuperation des capteurs
                try {
                    $result = mysqli_query($id_bd, "SELECT * FROM `view_sensor_admin`");
                
                } catch (Exception $e) {
                   die("ERROR DATA RECOVERY FAILED : <br>" . $e);
                }
            
                //Placement du resultat dans un tableau
                $sensors = fetchResults($result);

                if (!empty($sensors)) 
                {
                    
                    echo'
                    <tr>
                        <th> Type</th>
                        <th> Room </th>
                        <th> Building </th>
                    </tr>';

                    echo "<form method='post' action='./delete_sensor.php'>";
                    for ($i = 0; $i < count($sensors); $i++)
                    {
                        echo "<tr>";
                        for ($j = 1; $j < 4; $j++) {
                            echo  "<td>". $sensors[$i][$j] . "</td>";
                        }
                        echo "<td> <input type='submit' value='delete' name='" . $sensors[$i][0] . "'> </td> </tr>";
                    }
                    echo "</form>";

                }
                else 
                {
                    echo"<h4> Aucun Capteur </h4>";
                }
    
            ?>

        </table>
        <a href="./add_sensor.php"> Ajouter un Capteur </a>



        <h3> Batiments Crées : </h3>

        <table>

            <?php 


                $query = "SELECT ID_building AS id,
                 Name_Building AS Name,
                 Login_manager AS Manager,
                 Email_Manager AS Email
                 FROM `building`";
            
                //Récuperation des Batiments
                try {
                    $result = mysqli_query($id_bd, $query);
                
                } catch (Exception $e) {
                   die("ERROR DATA RECOVERY FAILED : . $e");
                }
            
                //Placement du resultat dans un tableau
                $buildings = fetchResults($result);

                if (!empty($buildings)) {

                    echo'
                    <tr>
                        <th> Name </th>
                        <th> Manager </th>
                        <th> Email </th>
                    </tr>
                    ';
    
                    echo "<form method=post action='./delete_building.php'>";
                    for ($i = 0; $i < count($buildings); $i++)
                    {
                        echo "<tr>";
                        for ($j = 1; $j < 4; $j++) {
                            echo  "<td>". $buildings[$i][$j] . "</td>";
                        }
                        echo "<td> <input type='submit' value='Delete' name='" . $buildings[$i][0] . "'> </td> </tr>";
                    }
                    echo "</form>";
                }
                else 
                {
                    echo"<h4> Aucun Batiment </h4>";
                }

            ?>

        </table>

        <a href="./add_building.php"> Ajouter un Batiment </a>
    </section>
    <footer>
        <ul>
            <li><a href="https://www.iut-blagnac.fr/fr/departement-rt" target="_blank" class="footer_text">IUT de Blagnac Département R&T</a></li>
            <li><a href="#" class="footer_text" >© Copyright 2023 All rights reserved</a></li>
            <li><a href="../NotAvailable/UnderConstruction.html" target="_blank"><img class="img_footer" src="../Images/HTML5.png" alt="HTML 5 Validation"></a></li>
            <li><a href="../NotAvailable/UnderConstruction.html" target="_blank"><img class="img_footer" src="../Images/CSS3.png" alt="CSS 3 Validation"></a></li>
        </ul>
    </footer>
</body>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('js-message').style.display = 'none';
        });
</script>
</html>