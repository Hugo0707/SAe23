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

        </table>
        
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
        
            //Récuperation des logins
            try {
                $result = mysqli_query($id_bd, "SELECT * FROM `view_sensor`");
            
            } catch (Exception) {
               die("ERROR DATA RECOVERY FAILED");
            }
        
            //Placement du resultat dans un tableau
            for ($i=0; $i < mysqli_num_rows($result); $i++) { 
                $sensors[$i] = mysqli_fetch_array($result);
            }
            
            echo "<form method=post action='./delete_sensor.php'>";
            echo "<ul>";
            for ($i = 0; $i < count($sensors); $i++)
            {
                echo "<li>";
                for ($j = 1; $j < 4; $j++) {
                    echo  $sensors[$i][$j];
                }
                echo "<input type='submit' value='Delete' name=" . $sensors[$i][0] . "' > <li>";
            }
            echo "<ul>";
            echo "</form>";
        ?>


    </body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('js-message').style.display = 'none';
    });
</script>