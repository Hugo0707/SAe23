<?php 
session_start();
require_once("../config/config.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS for the page-->
    <link rel="stylesheet" href="./Style/style.css">
    <link rel="icon" href="./Images/IOT_Logo.png" type="image/gif">
</head>
<?php
/////////////////////////////////////////////////////////////////////
///////////////////////////SCRIPT SENSORS.PHP////////////////////////
/////////////////////////////////////////////////////////////////////
//Database connection
try {
    $id_bd = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
} 
catch(Exception) {
    die("DATABASE CONNECTION ERROR : PLEASE CONTACT THE ADMINISTRATOR");
}

//Collecting measurements from buildings and sensor types
try {
    $result_measures = mysqli_query($id_bd, "SELECT * FROM `view_sensor_page`");
    $result_buildings = mysqli_query($id_bd, "SELECT Name_Building AS Building FROM `building`");
    $result_sensors = mysqli_query($id_bd, "SELECT DISTINCT Type_Sensor FROM `view_sensor_page`");
    $result_rooms = mysqli_query($id_bd, "SELECT DISTINCT Room FROM `view_sensor_page`");
} 
catch(Exception) {
    die("ERROR DATA RECOVERY FAILED : PLEASE CONTACT THE ADMINISTRATOR");
}

//Placing values in their respective tables
$measures = fetchResults($result_measures);
$buildings = fetchResults($result_buildings);
$sensors = fetchResults($result_sensors);
$rooms = fetchResults($result_rooms);
?>
<body>
    <header>
        <nav class="nav">
            <span class="title">SAE 23</span>
            <ul class="pages">
                <li><a class="effect-underline" href="./Index.php">Home</a></li>
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
                }}
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
    <section class="mainSensors">
        <table>
            <?php
            if (!empty($measures)) {
                echo "
                <!-- Table to display values retrieved from the database in an HTML table -->
                <form action='' method='GET'>
                    <!-- Form for collecting user-selected filters -->
                    <h1>Filters</h1>
                    <h2>&bull; Buildings selection</h2>
                    <select name='Building'>
                        <option value='' selected></option>";
                //Displays only buildings in the measurements
                for ($i=0; $i <count($sensors) ; $i++) { 
                    echo "<option value='" . $buildings[$i]['Building'] . "'>" . $buildings[$i]['Building'] . "</option>";
                }
                echo "</select>
                <h2>&bull; Sensors selection</h2>
                <select name='Type_sensor'>
                    <option value='' selected></option>";
                for ($i=0; $i <count($sensors) ; $i++) { 
                    echo "<option value='" . $sensors[$i]['Type_sensor'] . "'>" . $sensors[$i]['Type_sensor'] . "</option>";
                }
                echo "</select>
                <h2>&bull; Rooms selection</h2>
                <select name='Room'>
                    <option value='' selected></option>";
                for ($i=0; $i <count($rooms) ; $i++) { 
                    echo "<option value='" . $rooms[$i]['Room'] . "'>" . $rooms[$i]['Room'] . "</option>";
                 }
                echo "</select>
                <h2>&bull; Dates selection</h2>
                <input type='date' name='Date' id='date_input'>
                <input type='submit' value='Submit'>
                </form>
                <tr>
                    <th> Capteur </th>
                    <th> Batiment </th>
                    <th> Salle </th>
                    <th> Mesure </th>
                    <th> Date </th>
                    <th> Heure </th>
                </tr>";
                //Script that deletes the form's empty default choices, and if a date filter is requested, it sets the date to the correct format (french format)
                foreach ($_GET as $key => $value) {
                    if (isset($value) && $value ==="") {
                        unset($_GET[$key]);
                    }
                    if ($key == "Date" && !empty($value)) //Change date format If a date is entered
                    {
                        $_GET[$key] = date("d/m/Y", strtotime($value));
                    }
                }
                //Script to display the values retrieved in their respective columns from the measures table
                for ($i = 0; $i < count($measures); $i++) {
                    //Checks if there are no filters with empty()
                    if (empty($_GET)) {
                        echo "<tr>";
                        for ($j = 1; $j < 7; $j++) {
                            echo "<td>" . $measures[$i][$j] . "</td>";
                        }
                        echo "</tr>";
                    }
                    else {
                        //Script to check whether filters and measurements match
                        $match = true;
                        foreach ($_GET as $key => $value) {
                            if ($value != $measures[$i][$key]) {
                                $match = false;
                                break; 
                            }
                        }
                        //If all the filters entered match the measurement, the measurement is displayed
                        if ($match) {
                            echo "<tr>";
                            for ($j = 1; $j < 7; $j++) {
                                echo "<td>" . $measures[$i][$j] . "</td>";
                            }
                            echo "</tr>";
                        }
                    }
                }
            }
            else {
                echo "<center> <h2> No value recorded at the moment ! <h2> </center>";
            }
            ?>
        </table>
    </section>
    <footer>
        <ul>
            <li><a href="https://www.iut-blagnac.fr/fr/departement-rt" target="_blank" class="footer_text">IUT de Blagnac Département R&T</a></li>
            <li><a href="#" class="footer_text" >© Copyright 2023 All rights reserved</a></li>
            <li><a href="#" target="_blank"><img class="img_footer" src="./Images/HTML5.png" alt="HTML 5 Validation"></a></li>
            <li><a href="#" target="_blank"><img class="img_footer" src="./Images/CSS3.png" alt="CSS 3 Validation"></a></li>
        </ul>
    </footer>
</body>
</html>


