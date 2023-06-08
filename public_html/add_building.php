<?php 
    session_start();
    if (!($_SESSION["grade"] === "Admin"))
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
    <title>Ajout de Batiment</title>
</head>
<body>

    <?php 
        //Database connection
        try {
            $id_bd = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
        } 
        catch(Exception $e) {
            die("DATABASE CONNECTION ERROR : <br>" . $e);
        }
    
        //Sensor recovery
        try {
            $result = mysqli_query($id_bd, "SELECT ID_building, Name_building FROM `building`");
        
        } catch (Exception $e) {
           die("ERROR DATA RECOVERY FAILED : <br>" . $e);
        }

        //Placing values in the buildings table
        $buildings = fetchResults($result);
    ?>
    

    <form action="./add_building.php" method="POST">

        <h1> Ajout de Batiment </h1>

        <label for="Name_building"> Nom du Batiment :  </label>
        <select name="Name_building" >
            <?php 
                //Suggests only buildings that have not already been added
                $no_option = true;
                foreach ($building_rooms as $key => $array) {
                    
                    $display = true;
                    if (!empty($buildings)) {
                        for ($i=0; $i <count($buildings) ; $i++) { 

                            if ($buildings[$i]['Name_building'] == $key )
                            {
                                echo $buildings[$i]['Name_building'] . $key;
                                $display = false;
                            }
                        }
                        if ($display) {
                            echo "<option value='" . $key . "'>" . $key . "</option>";
                            $no_option = false;
                        }
                    }else {
                        //Displays all available buildings if no building has been retrieved from the database.
                        echo "<option value='" . $key . "'>" . $key . "</option>";
                        $no_option = false;
                    }
                    
                }
                echo"</select>";
                if ($no_option) {
                    //Redirect to admin page
                    echo '<center> <h1> Vous avez dejà ajouté tous les batiments disponnibles ! </h1> </center>
                    <script>
                        setTimeout(function() {
                            window.location.href = "./admin.php";
                        }, 1500); 
                    </script>';
                }
                
            ?>
        <br><br>
        <label for="Login_manager"> Login du Gestionnaire : </label>
        <input type="text" name="Login_manager">
        <br><br>
        <label for="Email_manager"> Email du Gestionnaire :  </label>
        <input type="text" name="Email_manager">
        <br><br>
        <label for="Password_manager"> Mdp du Gestionnaire : </label>
        <input type="password" name="Password_manager">
        <br><br>

        <input type="submit" value="Ajouter">
        

    </form>


    <?php 
         
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && (!empty($_POST['Name_building']) && !empty($_POST['Login_manager']) && !empty($_POST['Password_manager']))) { 

            //Recovering values given by the manager
            $Name_building = mysqli_real_escape_string($id_bd, $_POST['Name_building']);
            $Login_manager = mysqli_real_escape_string($id_bd, $_POST['Login_manager']);
            $Email_manager = mysqli_real_escape_string($id_bd, $_POST['Email_manager']);
            
            //bcrypt password encryption
            $Password_manager = password_hash($_POST['Password_manager'], PASSWORD_DEFAULT);

            //Data insertion query
            $query = "INSERT INTO building (Name_building, Login_manager, Email_manager, Password_manager) 
                VALUES ( '$Name_building', '$Login_manager', '$Email_manager', '" . $Password_manager . "')";

            //Execution of the query
            try {
                mysqli_query($id_bd, $query);
            } catch (Exception $e) {
                die("ERREUR REQUETE SQL LE BATIMENT N'A PAS ETE AJOUTÉ ! : <br>" . $e);
            }
            
            //Redirect to admin page
            echo '<center> <h4> BATIMENT AJOUTÉ AVEC SUCCES ! </h4> </center>
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