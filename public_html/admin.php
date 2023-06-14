<?php 
    session_start();
    
    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Admin"))
    {
        echo "<h2 class='info'> Connected as Admin </h2>";
    }
    else {
        echo '<script> window.location.href = "./connection.php"; </script>';
    }
    //Config import for database connection
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
        <title>Admin</title>
    </head>
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
    <body>
    <header>
        <nav class="nav">
            <span class="title">SAE 23</span>
            <ul class="pages">
                <li><a class="effect-underline" href="./index.php">Home</a></li>
                <li><a class="effect-underline" href="./sensors.php">Sensors</a></li>
                <li><a class="effect-underline" href="./contact.php">Contact</a></li>
                <li><a class="effect-underline" href="./legal_Information.php">Legal Notice</a></li>
                <li><a class="effect-underline" href="./ourwork.php">Our work</a></li>
            </ul>
            <?php 
            if (isset($_SESSION['grade'])) {
                if ($_SESSION['grade'] === 'Admin' ) {
                    echo "<span class='main_btn'><a href='./connection.php'>Admin</a></span>";
                }
                elseif ($_SESSION['grade'] === 'Manager') {
                    echo "<span class='main_btn'><a href='./connection.php'>Manager</a></span>";
                }
            }
            else {
                echo "<span class='main_btn'><a href='./connection.php'>Log In</a></span>";
            }
        ?>
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
    <section class="mainAdmin">
    <h2> Created Sensors : </h2>
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
                $result_buildings = mysqli_query($id_bd, "SELECT Name_Building AS Building FROM `building`");
                $result_sensors = mysqli_query($id_bd, "SELECT DISTINCT Type FROM `view_sensor_admin`");
                $result_rooms = mysqli_query($id_bd, "SELECT DISTINCT Room FROM `view_sensor_admin`");
            } catch (Exception $e) {
                mysqli_close($id_bd);
                die("ERROR DATA RECOVERY FAILED : <br>" . $e);
            }
            
            //Placing the result in a table
            $sensors = fetchResults($result);
            $buildings = fetchResults($result_buildings);
            $distinct_sensors = fetchResults($result_sensors);
            $rooms = fetchResults($result_rooms);


            if (!empty($sensors)) 
            {
                
                echo "
                <!-- Table to display sensors retrieved from the database in an HTML table -->
                <form action='' method='GET'>
                    <!-- Form for collecting user-selected filters -->
                    <h4>&bull; Buildings selection</h4>
                    <select name='Building'>
                        <option value='' selected></option>";
                //Displays only buildings in the sensors
                for ($i=0; $i <count($buildings) ; $i++) { 
                    echo "<option value='" . $buildings[$i]['Building'] . "'>" . $buildings[$i]['Building'] . "</option>";
                }
                echo "</select>
                <h4>&bull; Sensors selection</h4>
                <select name='Type'>
                    <option value='' selected></option>";
                for ($i=0; $i <count($distinct_sensors) ; $i++) { 
                    echo "<option value='" . $distinct_sensors[$i]['Type'] . "'>" . $distinct_sensors[$i]['Type'] . "</option>";
                }
                echo "</select>
                <h4>&bull; Rooms selection</h4>
                <select name='Room'>
                    <option value='' selected></option>";
                for ($i=0; $i <count($rooms) ; $i++) { 
                    echo "<option value='" . $rooms[$i]['Room'] . "'>" . $rooms[$i]['Room'] . "</option>";
                 }
                echo "</select>
                <input id='submit' type='submit' value='Submit'>
                </form> 
                <tr>
                    <th> Type</th>
                    <th> Room </th>
                    <th> Building </th>
                    <th> Delete </th>
                </tr>";

                //Script that deletes the form's empty default choices
                foreach ($_GET as $key => $value) {
                    if (isset($value) && $value ==="") {
                        unset($_GET[$key]);
                    }
                }
                //Script to display the values retrieved in their respective columns from the sensors table
                for ($i = 0; $i < count($sensors); $i++) {
                    //Checks if there are no filters with empty()
                    if (empty($_GET)) {

                        echo "<form method='post' action='./delete_sensor.php'>";
                        echo "<tr>";
                        for ($j = 1; $j < 4; $j++) {
                            echo  "<td>". $sensors[$i][$j] . "</td>";
                        }
                        echo "<td> <input type='submit' value='delete' name='" . $sensors[$i][0] . "'> </td> </tr>";
                        echo "</form>";
                    }
                    else {
                        //Script to check whether filters and sensors match
                        $match = true;
                        foreach ($_GET as $key => $value) {
                            if ($value != $sensors[$i][$key]) {
                                $match = false;
                                break; 
                            }
                        }
                        //If all the filters entered match the measurement, the measurement is displayed
                        if ($match) {
                            echo "<form method='post' action='./delete_sensor.php'>";
                            echo "<tr>";
                            for ($j = 1; $j < 4; $j++) {
                                echo  "<td>". $sensors[$i][$j] . "</td>";
                            }
                            echo "<td> <input type='submit' value='delete' name='" . $sensors[$i][0] . "'> </td> </tr>";
                            echo "</form>";
                        }
                    }
                }
            }
            else 
                {
                echo"<h4> No Sensor </h4>";
            }
    
        ?>

    </table>
    <a class="main_btn add" href="./add_sensor.php"> Add a sensor </a>
    <h2> Created buildings : </h2>
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
                    mysqli_close($id_bd);
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
                        <th> Delete </th>
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
                    echo"<h4> No building </h4>";
                }

                mysqli_close($id_bd);

            ?>

    </table>
    <a class="main_btn add" href="./add_building.php"> Add a building </a>
    <form id="Logout" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="submit" name="logout" value="Log out">
    </form>
    </section>
    <footer>
        <ul>
            <li><a href="https://www.iut-blagnac.fr/fr/departement-rt" target="_blank" class="footer_text">IUT of Blagnac R&T Department</a></li>
            <li><a href="./legal_Information.php" class="footer_text" >© Copyright 2023 All rights reserved</a></li>
            <li><a href="https://www.linkedin.com/in/gabin-lopez-168bb525b" target="_blank" class="footer_text" >Lopez</a></li>
            <li><a href="https://www.linkedin.com/in/hugo-calmels-50a51727b" target="_blank" class="footer_text" >Calmels</a></li>
            <li><a href="https://www.linkedin.com/in/yassir-boulouiha-gnaoui-9b226027b/" target="_blank" class="footer_text" >Boulouiha</a></li>
            <li><a href="https://www.linkedin.com/in/baptiste-alteirac" target="_blank" class="footer_text" >Alteirac</a></li>
        </ul>
    </footer>
</body>
</html>
