<?php 
    session_start();

    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Manager"))
    {
        echo " <center> <h1> Connecté en tant que Manager </h1> </center>";
    }
    else {
        echo '<script> window.location.href = "./login.php"; </script>';
    }
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
            
            
            ?>

        <div id="js-message" style="display: block;">
            <center> <h1> Veuillez activer JavaScript afin de permettre au site de fonctionner correctement. </h1> </center>
        </div>

    </body>
</html>