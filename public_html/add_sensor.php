<?php 
    session_start();
    if (!($_SESSION["grade"] === "Admin"))
    {
        header('Location: ./connection.php');
        exit();
    }
    //Include config file for db connection
    require_once("./config/config.php");
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
    <title>Add sensor</title>
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
    <!-- If No JS -->    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('js-message').style.display = 'none';
        });
        </script>

        <div id="js-message" style="display: block;">
            <center> <h1> Please enable JavaScript to allow the site to function properly. </h1> </center>
        </div>
    </script>

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
            mysqli_close($id_bd);
           die("ERROR DATA RECOVERY FAILED : <br>" . $e);
        }

        //Placing values in the buildings table
        $buildings = fetchResults($result);

        if (empty($buildings)) {
            echo '<center> <h1> You have to create a building first! </h1> </center>
                    <script>
                        setTimeout(function() {
                            window.location.href = "./admin.php";
                        }, 1500); 
                    </script>';
        }

        
    ?>

    <form action="" method="$_GET">

        <h1> Add sensor </h1>

        <label for="Type_sensor"> Sensor type :  </label>
        <select name="Type_sensor">
            <!-- Save the previous choice -->
            <option value="temperature" <?php if( isset($_GET['Type_sensor']) && ($_GET['Type_sensor'] === 'temperature')) echo 'selected'; ?>> Temperature </option>
            <option value="humidity" <?php if( isset($_GET['Type_sensor']) && ($_GET['Type_sensor'] === 'humidity')) echo 'selected'; ?>> Humidity </option>
            <option value="activity" <?php if( isset($_GET['Type_sensor']) && ($_GET['Type_sensor'] === 'activity')) echo 'selected'; ?>> Activity </option>
            <option value="co2" <?php if( isset($_GET['Type_sensor']) && ($_GET['Type_sensor'] === 'co2')) echo 'selected'; ?>> Co2 </option>
            <option value="illumination" <?php if( isset($_GET['Type_sensor']) && ($_GET['Type_sensor'] === 'illumination')) echo 'selected'; ?>> Illumination </option>
            <option value="pressure" <?php if( isset($_GET['Type_sensor']) && ($_GET['Type_sensor'] === 'pressure')) echo 'selected'; ?>> Pressure </option>

        </select>
        <br><br>

        <label for="ID_building"> Building : </label>
        <select name="ID_building">
            
            <?php 
                for ($i = 0; $i < count($buildings); $i++) {
                    //$selected is the variable that determines and applies the previous building choice
                    $selected = (isset($_GET['ID_building']) && (explode('-', $_GET['ID_building'])[1] === $buildings[$i]['Name_building'])) ? 'selected' : '';
                    echo "<option value='" . $buildings[$i]['ID_building'] . '-' . $buildings[$i]['Name_building'] . "' " . $selected . ">" . $buildings[$i]['Name_building'] . "</option>";
                }
            ?>

        </select>
        <br><br>
        
        <input type="submit" value="Next">
        <br><br>

    </form>

            
    <?php 

        if (!empty($_GET['ID_building'])) {
            
            echo "<form action='' method='POST'> <label for='Room_sensor'> Room : </label> <select name='Room_sensor'>";

                //Displays only the rooms associated with the building selected in the previous form.
                for ($i=0; $i < count($buildings); $i++) { 
                    //The explode function allows us to separate the building id and the name with which we'll make the condition.
                    if ($buildings[$i]['Name_building'] == explode('-', $_GET['ID_building'])[1]) {

                        foreach ($building_rooms[$buildings[$i]['Name_building']] as $key => $room) {

                            echo "<option value ='" . $building_rooms[$buildings[$i]['Name_building']][$key] . "'> " . $building_rooms[$buildings[$i]['Name_building']][$key] . "</option>";
                        }
                    }
                }
                
            echo "
            </select><br><br>
            <input type='submit' value='Add Sensor'>";
            echo " <input type='hidden' name='Type_sensor' value='" . $_GET['Type_sensor'] . "'>";
            echo " <input type='hidden' name='ID_building' value='" . explode('-', $_GET['ID_building'])[0] . "'>";
            echo "</form>"; 
            
        }

    ?>
    
    <?php 

        if ((!empty($_POST['Type_sensor']) && !empty($_POST['Room_sensor']) && !empty($_POST['ID_building']))) { 


            //Recovering values given by the manager
            $Type_sensor = mysqli_real_escape_string($id_bd, $_POST['Type_sensor']);
            $Room_sensor = mysqli_real_escape_string($id_bd, $_POST['Room_sensor']);
            $ID_building = mysqli_real_escape_string($id_bd, $_POST['ID_building']);


            $query = "INSERT INTO sensor (Type_sensor, Room_sensor, ID_building) 
                VALUES ('$Type_sensor', '$Room_sensor', '$ID_building');";

            try {
                mysqli_query($id_bd, $query);
            } catch (Exception $e) {
                mysqli_close($id_bd);
                die("SQL REQUEST ERROR THE SENSOR HAS NOT BEEN ADDED! : <br>" . $e);
            }

            echo '<center> <h4> SENSOR SUCCESSFULLY ADDED! </h4> </center>
                <script>
                    setTimeout(function() {
                        window.location.href = "./admin.php";
                    }, 1500); 
                </script>';

        }
        elseif ($_SERVER['REQUEST_METHOD'] ==="POST") {
            echo '
            <script>
                alert("All fields are required !")
            </script>';
        }
        
        mysqli_close($id_bd);
       
    
    ?>
    </section>
</body>
</html>