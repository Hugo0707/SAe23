<?php 
    session_start();
    
    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Admin"))
    {
        echo "<h2> Connecté en tant qu'Administrateur </h2>";
    }
    else {
        echo '<script> window.location.href = "./connection.php"; </script>';
    }
    //Config import for database connection
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('js-message').style.display = 'none';
        });
    </script>

    <body>

        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <br>
            <input type="submit" name="logout" value="Logout">
        </form>


        <h3> Capteurs Crées : </h3>

        <table>
        
            <?php
                if (isset($_GET["logout"])) {   
                    session_destroy();
                    echo '<script> window.location.href = "./connection.php"; </script>';
                }
            
                //Database connection
                try {
                    $id_bd = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
                } 
                catch(Exception $e) {
                    die("DATABASE CONNECTION ERROR : <br>" . $e);
                }
            
                //Sensor recovery
                try {
                    $result = mysqli_query($id_bd, "SELECT * FROM `view_sensor_admin`");
                
                } catch (Exception $e) {
                   die("ERROR DATA RECOVERY FAILED : <br>" . $e);
                }
            
                //Placing the result in a table
                $sensors = fetchResults($result);

                if (!empty($sensors)) 
                {
                    
                    echo'
                    <tr>
                        <th> Type</th>
                        <th> Room </th>
                        <th> Building </th>
                    </tr>';

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

                }
                else 
                {
                    echo"<h4> Aucun Capteur </h4>";
                }
    
            ?>

        </table>
        <a href="./add_sensor.php"> Ajouter un Capteur </a>



        <h3> Batiments Crées : </h3>

        <table>

            <?php 


                $query = "SELECT ID_building AS id,
                 Name_Building AS Name,
                 Login_manager AS Manager,
                 Email_Manager AS Email
                 FROM `building`";
            
                //Buildings recovery
                try {
                    $result = mysqli_query($id_bd, $query);
                
                } catch (Exception $e) {
                   die("ERROR DATA RECOVERY FAILED : . $e");
                }
            
                //Placing the result in a table
                $buildings = fetchResults($result);

                if (!empty($buildings)) {

                    echo'
                    <tr>
                        <th> Name </th>
                        <th> Manager </th>
                        <th> Email </th>
                    </tr>
                    ';
    
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
                }
                else 
                {
                    echo"<h4> Aucun Batiment </h4>";
                }

            ?>

        </table>

        <a href="./add_building.php"> Ajouter un Batiment </a>


    </body>
</html>
