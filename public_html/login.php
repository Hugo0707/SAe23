<?php
    session_start();
    if (empty($_POST["login"]) || empty($_POST["passwd"])) 
    {
        header('Location: ../connection.php');
        exit();
    }
    require_once("../config/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion en cours...</title>
</head>
<body>

    <section>

        <?php       
            
            //Connexion à la base de données
            try {
                $id_bd = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
            } 
            catch(Exception) {
                die("DATABASE CONNECTION ERROR PLEASE CONTACT THE ADMINISTRATOR");
            }
        
            //Récuperation des logins
            try {
                $result = mysqli_query($id_bd, "SELECT * FROM `view_login`");
            
            } catch (Exception) {
               die("ERROR DATA RECOVERY FAILED PLEASE CONTACT THE ADMINISTRATOR");
            }
        
            //Placement des login et mdp dans le tableau credentials
            $credentials = fetchResults($result);
        
            $login = $_POST["login"];
            $passwd = $_POST["passwd"];
        
            $known = false;
            for ($i=0; $i < count($credentials) ; $i++) { 
                if (password_verify($passwd, $credentials[$i][1]) && $login == $credentials[$i][0] ) {
                    $known=true;
                    $_SESSION["login"] = $credentials[$i][0];
                    $_SESSION["grade"] = $credentials[$i][2];
                    echo "<center> <h1> Connexion réussie ! </h1>";
                    echo "Vous êtes : " . $credentials[$i][2] . "</center>" ;

                    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Admin"))
                    {
                        echo '<script> window.location.href = "./admin.php"; </script>';
                    }
                    elseif ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Manager")) {
                        $_SESSION['building'] = $credentials[$i]['Building'];
                        echo '<script> window.location.href = "./manager.php"; </script>';
                    }
                     
                }
            }
            if (!$known) {
                echo '<center> <h1> Login ou Mot de Passe Incorrect ! </h1> </center>';
                echo '
                <script>
                    setTimeout(function() {
                        window.location.href = "./connection.php";
                    }, 1500); 
                </script>';
            }
        
        ?>

    </section>


    <div id="js-message" style="display: block;">
        <center> <h1> Veuillez activer JavaScript afin de permettre au site de fonctionner correctement. </h1> </center>
    </div>
</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('js-message').style.display = 'none';
    });
</script>