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
            die("DATABASE CONNECTION ERROR");
        }

        //Récuperation des mesures
        try {
            $result = mysqli_query($id_bd, "SELECT * FROM `view_sensor_page`");

        } catch (Exception) {
           die("ERROR DATA RECOVERY FAILED");
        }
        
        //Placement des valeurs dans le tableau measures
        for ($i=0; $i < mysqli_num_rows($result); $i++) { 
            $measures[$i] = mysqli_fetch_array($result);
        }
            
    ?>

    <body>
    
        <section>

            <!-- Tableau pour afficher les valeurs recuperées depuis la base de données dans un tableau en HTML -->

            <form action="" method="GET">
                <!-- Formulaire permettant de recueillir les filtres choisis par l'utilisateur -->
                <select name="ID_building" id="building">
                    <option value="" selected></option>
                    <option value="1"> Batiment R&T </option>
                    <option value="2"> Batiment INFO </option>
                </select>

                <select name="Type_sensor" id="building">
                    <option value="" selected></option>
                    <option value="Temperature"> Temperature </option>
                    <option value="Co2"> Co2 </option>
                </select>

                <input type="date" name="Date" id="date_input">

                <input type="submit" value="Appliquer">

            </form>

            <table>
            
                <tr>

                    <th> Capteur </th>
                    <th> Batiment </th>
                    <th> Mesure </th>
                    <th> Date </th>
                    <th> Heure </th>

                </tr>

                <?php

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

                        // Vérifie si le tableau $_GET est vide
                        if (empty($_GET)) 
                        {
                            echo "<tr>";
                            for ($j = 1; $j < 6; $j++) {
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
                                for ($j = 1; $j < 6; $j++) {
                                    echo "<td>" . $measures[$i][$j] . "</td>";
                                }
                                echo "</tr>";
                            }
                        }
                    }
                ?>

            </table>

        </section>

    </body>

</html>

