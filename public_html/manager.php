<?php 
    session_start();

    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Manager"))
    {
        echo " <center> <h1> Connecté en tant que Manager </h1> </center>";
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
    <link rel="stylesheet" href="../Style/style.css">
    <link rel="icon" href="../Images/IOT_Logo.png" type="image/gif">
    <title>Sensors</title>
</head>
<body>
    <div id="js-message" style="display: block;">
        <center> <h1> Veuillez activer JavaScript afin de permettre au site de fonctionner correctement. </h1> </center>
    </div>
    <header>
    <nav class="nav">
            <span class="title">SAE 23</span>
            <ul class="pages">
                <li><a class="effect-underline" href="../Index.html">Home</a></li>
                <li><a class="effect-underline" href="Sensors.php">Sensors</a></li>
                <li><a class="effect-underline" href="Contact.html">Contact</a></li>
                <li><a class="effect-underline" href="Legal_Information.html">Legal Notice</a></li>
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

        <?php

            if (isset($_GET["logout"])) {   
                session_destroy();
                echo '<script> window.location.href = "./connection.php"; </script>';
            }
            
            //Connexion à la base de données
            try {
                $id_bd = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
            } 
            catch(Exception) {
                die("DATABASE CONNECTION ERROR PLEASE CONTACT THE ADMINISTRATOR");
            }
        
            //Récuperation des mesures
            try {
                $result_measures = mysqli_query($id_bd, "SELECT Type_sensor, Building, Room, Value, Date, Time FROM view_sensor_page WHERE Building = '" . $_SESSION['building'] . "';");
                $result_buildings = mysqli_query($id_bd, "SELECT Name_Building AS Building FROM `building`");
                $result_sensors = mysqli_query($id_bd, "SELECT DISTINCT Type_Sensor FROM `view_sensor_page`");
                $result_rooms = mysqli_query($id_bd, "SELECT DISTINCT Room FROM `view_sensor_page`");
            } 
            catch(Exception) {
               die("ERROR DATA RECOVERY FAILED PLEASE CONTACT THE ADMINISTRATOR : ");
            }
            
            //Placement des valeurs dans le tableau measures
            $measures = fetchResults($result_measures);
            $buildings = fetchResults($result_buildings);
            $sensors = fetchResults($result_sensors);
            $rooms = fetchResults($result_rooms);
        ?>
        
        <table>

    <?php

        if (!empty($measures)) {
            
            echo "
                <!-- Tableau pour afficher les valeurs recuperées depuis la base de données dans un tableau en HTML -->

                <form action='' method='GET'>
                    <!-- Formulaire permettant de recueillir les filtres choisis par l'utilisateur -->
                    <select name='Building'>
                        
                        <option value='' selected></option>";

                    for ($i=0; $i <count($sensors) ; $i++) { 
                        echo "<option value='" . $buildings[$i]['Building'] . "'>" . $buildings[$i]['Building'] . "</option>";
                    }

              echo "</select>
            
                    <select name='Type_sensor'>
                        <option value='' selected></option>";
                        
                        for ($i=0; $i <count($sensors) ; $i++) { 
                            echo "<option value='" . $sensors[$i]['Type_sensor'] . "'>" . $sensors[$i]['Type_sensor'] . "</option>";
                        }

              echo "</select>
                
                    <select name='Room'>
                    <option value='' selected></option>
                    ";
                    
                        for ($i=0; $i <count($rooms) ; $i++) { 
                            echo "<option value='" . $rooms[$i]['Room'] . "'>" . $rooms[$i]['Room'] . "</option>";
                        }

                    
              echo "</select>
                    <input type='date' name='Date' id='date_input'>
            
                    <input type='submit' value='Appliquer'>
            
                </form>

                <tr>

                <th> Capteur </th>
                <th> Batiment </th>
                <th> Salle </th>
                <th> Mesure </th>
                <th> Date </th>
                <th> Heure </th>
            
                </tr>
            ";

            //Script qui permet de supprimer les choix par defaut vides du formulaire, et si un filtre sur la date est demandé il permet de la mettre au bon format
            foreach ($_GET as $key => $value) 
            {
                if (isset($value) && $value ==="") 
                {
                    unset($_GET[$key]);
                }
                if ($key == "Date" && !empty($value)) //Changement du format de la date Si une date est renseignée
                {
                    $_GET[$key] = date("d/m/Y", strtotime($value));
                }
            }

            // Script pour afficher les valeurs récupérées dans leur colonnes respectives depuis le tableau measures
            for ($i = 0; $i < count($measures); $i++) 
            {

                // Vérifie si il n'y a aucun filtre avec empty()
                if (empty($_GET)) 
                {
                    echo "<tr>";
                    for ($j = 0; $j < 6; $j++) {
                        echo "<td>" . $measures[$i][$j] . "</td>";
                    }
                    echo "</tr>";
                }
                else 
                {
                    // Script permettant de verifier si il les filtres renseignés et les mesures correspondent
                    $match = true;
                    foreach ($_GET as $key => $value) {
                        if ($value != $measures[$i][$key]) {
                            $match = false;
                            break; 
                        }
                    }
                
                    // Si tous les filtres renseignés correspondent avec la mesure, la mesure est affichée
                    if ($match) {
                        echo "<tr>";
                        for ($j = 0; $j < 6; $j++) {
                            echo "<td>" . $measures[$i][$j] . "</td>";
                        }
                        echo "</tr>";
                    }
                }
            }
        }
        else {
            echo "<center> <h2> Aucune valeur enregistrée pour le moment ! <h2> </center>";
        }
    ?>

</table>
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