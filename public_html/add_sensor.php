<?php 
    session_start();
    if (!($_SESSION["grade"] === "Admin"))
    {
        header('Location: ./connection.php');
        exit();
    }
    //Inclure le fichier config pour la connexion à la bd
    require_once("../config/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de Capteur</title>
</head>
<body>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('js-message').style.display = 'none';
        });
        </script>

        <div id="js-message" style="display: block;">
            <center> <h1> Veuillez activer JavaScript afin de permettre au site de fonctionner correctement. </h1> </center>
        </div>
    </script>

    <?php 
    
        //Connexion à la base de données
        try {
            $id_bd = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
        } 
        catch(Exception $e) {
            die("DATABASE CONNECTION ERROR : <br>" . $e);
        }
    
        //Récuperation des capteurs
        try {
            $result = mysqli_query($id_bd, "SELECT ID_building, Name_building FROM `building`");
        
        } catch (Exception $e) {
           die("ERROR DATA RECOVERY FAILED : <br>" . $e);
        }

        //Placement des valeurs dans le tableau buildings
        $buildings = fetchResults($result);

        if (empty($buildings)) {
            echo '<center> <h1> Vous devez d\'abord créer un batiment avant cela ! </h1> </center>
                    <script>
                        setTimeout(function() {
                            window.location.href = "./admin.php";
                        }, 1500); 
                    </script>';
        }

        
    ?>

    <form action="" method="$_GET">

        <h1> Ajout de Capteur </h1>

        <label for="Type_sensor"> Type du Capteur:  </label>
        <select name="Type_sensor">
            <option value="temperature" <?php if( isset($_GET['Type_sensor']) && ($_GET['Type_sensor'] === 'temperature')) echo 'selected'; ?>> Temperature </option>
            <option value="humidity" <?php if( isset($_GET['Type_sensor']) && ($_GET['Type_sensor'] === 'humidity')) echo 'selected'; ?>> Humidité </option>
            <option value="activity" <?php if( isset($_GET['Type_sensor']) && ($_GET['Type_sensor'] === 'activity')) echo 'selected'; ?>> Activité </option>
            <option value="co2" <?php if( isset($_GET['Type_sensor']) && ($_GET['Type_sensor'] === 'co2')) echo 'selected'; ?>> Co2 </option>
            <option value="illumination" <?php if( isset($_GET['Type_sensor']) && ($_GET['Type_sensor'] === 'illumination')) echo 'selected'; ?>> Luminosité </option>
            <option value="pressure" <?php if( isset($_GET['Type_sensor']) && ($_GET['Type_sensor'] === 'pressure')) echo 'selected'; ?>> Pression </option>

        </select>
        <br><br>

        <label for="ID_building"> Batiment : </label>
        <select name="ID_building">
            
            <?php 
                for ($i = 0; $i < count($buildings); $i++) {
                    //$selected est la variable qui va determiner le choix de batiment precedent et l'appliquer
                    $selected = (isset($_GET['ID_building']) && (explode('-', $_GET['ID_building'])[1] === $buildings[$i]['Name_building'])) ? 'selected' : '';
                    echo "<option value='" . $buildings[$i]['ID_building'] . '-' . $buildings[$i]['Name_building'] . "' " . $selected . ">" . $buildings[$i]['Name_building'] . "</option>";
                }
            ?>

        </select>
        <br><br>
        
        <input type="submit" value="Suivant">
        <br><br>

    </form>

            
    <?php 

        if (!empty($_GET['ID_building'])) {
            
            echo "<form action='' method='POST'> <label for='Room_sensor'> Salle : </label> <select name='Room_sensor'>";

                //Permet d'afficher uniquement les salles associées au batiment choisi dans le formulaire précedent 
                for ($i=0; $i < count($buildings); $i++) { 
                    //La fonction explode nous permet la séparation de l'id du batiment ainsi que du nom avec le quel nous allons faire la condition
                    if ($buildings[$i]['Name_building'] == explode('-', $_GET['ID_building'])[1]) {

                        foreach ($building_rooms[$buildings[$i]['Name_building']] as $key => $room) {

                            echo "<option value ='" . $building_rooms[$buildings[$i]['Name_building']][$key] . "'> " . $building_rooms[$buildings[$i]['Name_building']][$key] . "</option>";
                        }
                    }
                }
                
            echo "
            </select><br><br>
            <input type='submit' value='Ajouter le Capteur'>";
            echo " <input type='hidden' name='Type_sensor' value='" . $_GET['Type_sensor'] . "'>";
            echo " <input type='hidden' name='ID_building' value='" . explode('-', $_GET['ID_building'])[0] . "'>";
            echo "</form>"; 
            
        }

    ?>
    
    <?php 

        if ((!empty($_POST['Type_sensor']) && !empty($_POST['Room_sensor']) && !empty($_POST['ID_building']))) { 

            //Connexion à la base de données
            try {
                $id_bd = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
            } 
            catch(Exception $e) {
                die("DATABASE CONNECTION ERROR : <br>" . $e);
            }

            //Recuperations des valeurs données par le gestionnaire 
            $Type_sensor = mysqli_real_escape_string($id_bd, $_POST['Type_sensor']);
            $Room_sensor = mysqli_real_escape_string($id_bd, $_POST['Room_sensor']);
            $ID_building = mysqli_real_escape_string($id_bd, $_POST['ID_building']);


            $query = "INSERT INTO sensor (Type_sensor, Room_sensor, ID_building) 
                VALUES ('$Type_sensor', '$Room_sensor', '$ID_building');";

            try {
                mysqli_query($id_bd, $query);
            } catch (Exception $e) {
                die("ERREUR REQUETE SQL LE CAPTEUR N'A PAS ÉTÉ AJOUTÉ ! : <br>" . $e);
            }

            echo '<center> <h4> CAPTEUR AJOUTÉ AVEC SUCCES ! </h4> </center>
                <script>
                    setTimeout(function() {
                        window.location.href = "./admin.php";
                    }, 1500); 
                </script>';

        }
        elseif ($_SERVER['REQUEST_METHOD'] ==="POST") {
            echo '
            <script>
                alert("Tous les champs sont obligatoires !")
            </script>';
        }
       
    
    ?>

</body>
</html>