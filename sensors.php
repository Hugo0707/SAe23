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

        //Identifiants BD
        $user = "admin";    
        $pass = '';         //Entrer mdp de l'utilisateur, si aucun mdp pour l'utilisateur laisser vide
        $bd = "sae23";      //Nom de la base de données à utiliser

        //Connexion à la base de données
        try {
            $id_bd = mysqli_connect("localhost", $user, $pass, $bd);
        } 
        catch(Exception) {
            die("DATABASE CONNECTION ERROR");
        }

        //Récuperation des mesures
        try {
            $result = mysqli_query($id_bd, "SELECT * FROM `vue_sensor_page`");

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
            <table>
            
                <tr>

                    <th> Batiment </th>
                    <th> Mesure </th>
                    <th> Date </th>
                    <th> Heure </th>

                </tr>

                <?php
                    // Script pour afficher les valeurs récuperées dans leur colonnes respectives depuis le tableau measures
                    for ($i=0; $i < count($measures) ; $i++) 
                    { 
                        echo "<tr>";
                        for ($j=0; $j < 4; $j++) { 
                            echo "<td>" . $measures[$i][$j] . "</td>";
                        }
                        echo "</tr>";
                    }
                ?>

            </table>


        </section>

    </body>

</html>
