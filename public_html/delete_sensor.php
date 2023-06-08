<?php 
    session_start();
    if (!($_SESSION["grade"] === "Admin") || empty($_POST))
    {
        header('Location: ./connection.php');
        exit();
    }
    //Include config file for db connection
    require_once("../config/config.php");
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
        <title>Suppression du Capteur</title>
    </head>
    <body>
    <section class="background">
        <div class="circle one"></div>
        <div class="circle two"></div>
        <div class="circle three"></div>
        <div class="circle four"></div>
        <div class="circle five"></div>
        <div class="circle sixe"></div>
    </section>
    <section class="AD">


        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('js-message').style.display = 'none';
        });
        </script>
        
        <div id="js-message" style="display: block;">
            <center> <h1> Veuillez activer JavaScript afin de permettre au site de fonctionner correctement. </h1> </center>
        </div>

        <?php 

            //Database connection
            try {
                $id_bd = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
            } 
            catch(Exception $e) {
                die("DATABASE CONNECTION ERROR : <br>" . $e);
            }
            //Saving the sensor identifier to be overwritten in this variable
            //Verify user input with mysli_real_escape_string function to prevent sql injections
            //This variable will be sent in the next form post to remember which sensor to delete if the choice is yes
            $id_sensor = mysqli_real_escape_string($id_bd, array_key_first($_POST));
            
        ?>

        <form method='post' action="">

            <center> 
                <h2> Voulez vous vraiment supprimer ce capteur ? Cette action sera irréversible ! <br> Toutes les mesures associées a ce capteur seront supprimées également ! </h2>
            </center>

            <label for="oui">Oui</label>
            <input type="radio" name="confirm" value="yes" id="oui">

            <label for="non">Non</label>
            <input type="radio" name="confirm" value="no" id="non">
            
            <input type="hidden" name="delete" value="<?php echo $id_sensor;?>">

            <input type="submit" value="Valider">
        </form>



        <?php 

            if (isset($_POST['confirm'])) {
                
                if ($_POST['confirm'] === "yes") {

                    //Record the query that will delete this sensor from the database in the variable $query
                    $query = "DELETE FROM sensor WHERE ID_sensor = " . $_POST['delete']; 
                
                    try {
                        mysqli_query($id_bd, $query);
                    } catch (Exception $e) {
                        echo " ERREUR :  " . $e;
                        die("ERREUR REQUETE SQL CAPTEUR NON SUPPRIMÉ : <br>" . $e);
                    }

                    echo '
                        <center> <h1> CAPTEUR SUPPRIMÉ AVEC SUCCES </h1> </center>
                        <script>
                            setTimeout(function() {
                                window.location.href = "./admin.php";
                            }, 1500); 
                        </script>';
                }
                elseif ($_POST['confirm'] === "no") {
                    echo '<script> window.location.href = "./admin.php"; </script>';
                }
            }      
            ?>
        </section>
    </body>
</html>


