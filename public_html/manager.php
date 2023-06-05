<?php 
    session_start();

    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Manager"))
    {
        echo "  <h2> Connecté en tant que Manager </h2> ";
    }
    else {
        echo '<script> window.location.href = "./login.php"; </script>';
    }

    //Importation de la config pour la connexion à la bd
    require_once("../config/config.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manager Page</title>
    </head>
    <body>

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

<section>

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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('js-message').style.display = 'none';
            });
        </script>

        <div id="js-message" style="display: block;">
            <center> <h1> Veuillez activer JavaScript afin de permettre au site de fonctionner correctement. </h1> </center>
        </div>

    </body>
</html>