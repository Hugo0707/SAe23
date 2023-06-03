<?php 
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS for the page-->
    <link rel="stylesheet" href="../Style/style.css">
    <link rel="icon" href="../Images/IOT_Logo.png" type="image/gif">
    <title>Sensors</title>
</head>
<?php

/////////////////////////////////////////////////////////////////////////
///////////////////////////SCRIPT SENSORS.PHP////////////////////////////
/////////////////////////////////////////////////////////////////////////

//Identifiants BD
$user = "admin";    
$pass = 'sae23';         //Entrer mdp de l'utilisateur, si aucun mdp pour l'utilisateur laisser vide
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
    <header>
    <nav class="nav">
            <span class="title">SAE 23</span>
            <ul class="pages">
                <li><a class="effect-underline" href="../Index.html">Home</a></li>
                <li><a class="effect-underline" href="Sensors.php">Sensors</a></li>
                <li><a class="effect-underline" href="Contact.html">Contact</a></li>
                <li><a class="effect-underline" href="Legal_Information.html">Legal Notice</a></li>
            </ul>
            <span class="main_btn"><a href="Account.php"> Log In</a></span>
            <img class="burger" src="MenuBurger.png" alt="menu burger">
        </nav>  
    </header>
    <section class="background">
        <div class="circle one"></div>
        <div class="circle two"></div>
        <div class="circle three"></div>
        <div class="circle four"></div>
        <div class="circle five"></div>
        <div class="circle sixe"></div>
    </section>
    <section class="main">
    
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
    <footer>
        <ul>
            <li><a href="https://www.iut-blagnac.fr/fr/departement-rt" target="_blank" class="footer_text">IUT de Blagnac Département R&T</a></li>
            <li><a href="#" class="footer_text" >© Copyright 2023 All rights reserved</a></li>
            <li><a href="../NotAvailable/UnderConstruction.html" target="_blank"><img class="img_footer" src="../Images/HTML5.png" alt="HTML 5 Validation"></a></li>
            <li><a href="../NotAvailable/UnderConstruction.html" target="_blank"><img class="img_footer" src="../Images/CSS3.png" alt="CSS 3 Validation"></a></li>
        </ul>
    </footer>
</body>
</html>