<?php
    
    if (empty($_POST["login"]) || empty($_POST["passwd"])) 
    {
        header('Location: ./connection.php');
        exit();
    }
    else 
    {
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <section>

        <?php       
            //Identifiants BD
            $user = "root";    
            $pass = '';          //Entrer mdp de l'utilisateur, si aucun mdp pour l'utilisateur laisser vide
            $bd = "sae23";      //Nom de la base de données à utiliser
            //Connexion à la base de données
            try {
                $id_bd = mysqli_connect("localhost", $user, $pass, $bd);
            } 
            catch(Exception) {
                die("DATABASE CONNECTION ERROR");
            }
        
            //Récuperation des logins
            try {
                $result = mysqli_query($id_bd, "SELECT * FROM `view_login`");
            
            } catch (Exception) {
               die("ERROR DATA RECOVERY FAILED");
            }
        
            //Placement des login et mdp dans le tableau credentials
            for ($i=0; $i < mysqli_num_rows($result); $i++) { 
                $credentials[$i] = mysqli_fetch_array($result);
            }
        
            //print_r($_POST);
            //echo "<br> <br>";
            //print($credentials[0][1]);
            //die("Fin");
            $login = $_POST["login"];
            $passwd = $_POST["passwd"];
        
            $known = false;
            for ($i=0; $i < count($_POST) ; $i++) { 
                if (password_verify($passwd, $credentials[$i][1]) && $login == $credentials[$i][0] ) {
                    $known=true;
                    echo "<center> <h1> Connexion réussie ! </h1>";
                    echo "Vous êtes : " . $credentials[$i][2] . "</center>" ; 
                }
            }
            if (!$known) {
                echo "Mot de passe ou login incorrect !";
            }
        
        ?>

    </section>

</body>
</html>
