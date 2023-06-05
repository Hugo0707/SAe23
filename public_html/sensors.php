<?php 
    session_start();
    require_once("../config/config.php");
?>
<!DOCTYPE html>

<html>

    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>

    <?php

        /////////////////////////////////////////////////////////////////////////
        ///////////////////////////SCRIPT SENSORS.PHP////////////////////////////
        /////////////////////////////////////////////////////////////////////////


        //Connexion à la base de données
        try {
            $id_bd = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
        } 
        catch(Exception) {
            die("DATABASE CONNECTION ERROR : PLEASE CONTACT THE ADMINISTRATOR");
        }

        //Récuperation des mesures des batiments et des types de capteurs
        try {
            $result_measures = mysqli_query($id_bd, "SELECT * FROM `view_sensor_page`");
            $result_buildings = mysqli_query($id_bd, "SELECT Name_Building AS Building FROM `building`");
            $result_sensors = mysqli_query($id_bd, "SELECT DISTINCT Type_Sensor FROM `view_sensor_page`");
            $result_rooms = mysqli_query($id_bd, "SELECT DISTINCT Room FROM `view_sensor_page`");
        } 
        catch(Exception) {
           die("ERROR DATA RECOVERY FAILED : PLEASE CONTACT THE ADMINISTRATOR");
        }

        //Placement des valeurs dans leur tableau respectif
        $measures = fetchResults($result_measures);
        $buildings = fetchResults($result_buildings);
        $sensors = fetchResults($result_sensors);
        $rooms = fetchResults($result_rooms);

            
    ?>

    <body>
    
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
                                for ($j = 1; $j < 7; $j++) {
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
                                    for ($j = 1; $j < 7; $j++) {
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

    </body>

</html>

