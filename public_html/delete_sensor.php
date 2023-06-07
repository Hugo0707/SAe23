<?php 
    session_start();
    if (!($_SESSION["grade"] === "Admin"))
    {
        header('Location: ../connection.php');
        exit();
    }
    //Inclure le fichier config pour la connexion a la bd
    require_once("../config/config.php");
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Suppression du Capteur</title>
    </head>

    <body>

        
        <div id="js-message" style="display: block;">
            <center> <h1> Veuillez activer JavaScript afin de permettre au site de fonctionner correctement. </h1> </center>
        </div>

        <?php 
            
            //Connexion à la base de données
            try {
                $id_bd = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
            } 
            catch(Exception) {
                die("DATABASE CONNECTION ERROR");
            }
        
            //Enregistrement de l'identifiant du capteur a surpprimer dans cette variable
            //Verification de l'entrée de l'utilisateur avec la fonction mysli_real_escape_string permettant de prévenir les injections sql
            $id_sensor = mysqli_real_escape_string($id_bd, array_key_first($_POST));

            //Enregistrement de la requete qui permettra de supprimer ce capteur de la base de données dans la variable $query
            $query = "DELETE FROM sensor WHERE ID_sensor = '$id_sensor'"; 

            try {
                mysqli_query($id_bd, $query);
            } catch (Exception) {
                die("ERREUR REQUETE SQL CAPTEUR NON SUPPRIMÉ");
            }

            echo '
                <center> <h1> CAPTEUR SUPPRIMÉ AVEC SUCCES </h1> </center>
                <script>
                    setTimeout(function() {
                        window.location.href = "./admin.php";
                    }, 1500); 
                </script>';
            
        ?>

    </body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('js-message').style.display = 'none';
    });
</script>


