<?php 
    session_start();
    
    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Admin"))
    {
        echo "Connecté en tant qu'Administrateur";
    }
    else {
        echo '<script> window.location.href = "./connection.php"; </script>';
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
        <title>Admin Page</title>
    </head>

    <div id="js-message" style="display: block;">
        <center> <h1> Veuillez activer JavaScript afin de permettre au site de fonctionner correctement. </h1> </center>
    </div>

    <body>

        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <br>
            <input type="submit" name="logout" value="Logout">
        </form>


        <h3> Capteurs Crées : </h3>

        <table>

            <tr>
                <th> Type</th>
                <th> Room </th>
                <th> Building </th>
            </tr>

    
        
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
                    die("DATABASE CONNECTION ERROR");
                }
            
                //Récuperation des capteurs
                try {
                    $result = mysqli_query($id_bd, "SELECT * FROM `view_sensor_admin`");
                
                } catch (Exception) {
                   die("ERROR DATA RECOVERY FAILED");
                }
            
                //Placement du resultat dans un tableau
                for ($i=0; $i < mysqli_num_rows($result); $i++) { 
                    $sensors[$i] = mysqli_fetch_array($result);
                }

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
            ?>

        </table>
        <a href="./add_sensor.php"> Ajouter un Capteur </a>



        <h3> Batiments Crées : </h3>

        <table>

            <tr>
                <th> Name </th>
                <th> Manager </th>
                <th> Email </th>
            </tr>

            <?php 


                $query = "SELECT ID_building AS id,
                 Name_Building AS Name,
                 Login_manager AS Manager,
                 Email_Manager AS Email
                 FROM `building`";
            
                //Récuperation des Batiments
                try {
                    $result = mysqli_query($id_bd, $query);
                
                } catch (Exception) {
                   die("ERROR DATA RECOVERY FAILED");
                }
            
                //Placement du resultat dans un tableau
                for ($i=0; $i < mysqli_num_rows($result); $i++) { 
                    $buildings[$i] = mysqli_fetch_array($result);
                }

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

            ?>

        </table>

        <a href="./add_building.php"> Ajouter un Batiment </a>


    </body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('js-message').style.display = 'none';
    });
</script>