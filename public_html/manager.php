<?php 
    session_start();

    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Manager"))
    {
        echo "  <h2 class='info'> Connected as Manager </h2> ";
    }
    else {
        echo '<script> window.location.href = "./login.php"; </script>';
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
        <title>Manager</title>
    </head>
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
    <section class="mainManager">
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

            //Logout button
            if (isset($_GET["logout"])) {   
                session_destroy();
                echo '<script> window.location.href = "./connection.php"; </script>';
            }
            
            //Database connection
            try {
                $id_bd = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
            } 
            catch(Exception) {
                die("DATABASE CONNECTION ERROR PLEASE CONTACT THE ADMINISTRATOR");
            }
        
            //Recovery of measurements, buildings and rooms
            try {
                $result_measures = mysqli_query($id_bd, "SELECT Type_sensor, Building, Room, Value, Date, Time FROM view_sensor_page WHERE Building = '" . $_SESSION['building'] . "';");
                $result_sensors = mysqli_query($id_bd, "SELECT DISTINCT Type_Sensor FROM `view_sensor_page` WHERE Building = '" . $_SESSION['building'] . "';");
                $result_rooms = mysqli_query($id_bd, "SELECT DISTINCT Room FROM `view_sensor_page` WHERE Building = '" . $_SESSION['building'] . "';");
            } 
            catch(Exception) {
                mysqli_close($id_bd);
                die("ERROR DATA RECOVERY FAILED PLEASE CONTACT THE ADMINISTRATOR : ");
            }
            
            //Placing values in the measures table
            $measures = fetchResults($result_measures);
            $sensors = fetchResults($result_sensors);
            $rooms = fetchResults($result_rooms);
        ?>
        <script>

            document.addEventListener('DOMContentLoaded', function() {
                var advancedOptions = document.getElementById('advanced-options');
                var optionsContainer = document.getElementById('options-container');
                var dateInput = document.getElementById('date_input');

                //Retrieves the current "display" style of the dateInput field
                var dateInputDisplayStyle = getComputedStyle(dateInput).display; 

                advancedOptions.addEventListener('click', function(e) {
                    e.preventDefault();
                    optionsContainer.style.display = optionsContainer.style.display === 'none' ? 'block' : 'none';

                    //Checks whether the dateInput field is hidden or displayed according to its "display" style
                    if (getComputedStyle(dateInput).display === 'none') {
                        dateInput.style.display = dateInputDisplayStyle; //Restores the previous "display" style
                    } else {
                        dateInputDisplayStyle = getComputedStyle(dateInput).display; //Saves the new "display" style
                        dateInput.style.display = 'none';
                    }
                });

                var startTimeInput = document.getElementById('start_time');
                var endTimeInput = document.getElementById('end_time');

                var Form = document.getElementById('filter-form');

                Form.addEventListener('submit', function(event) {
                  var startTime = startTimeInput.value;
                  var endTime = endTimeInput.value;
                
                  if (!(startTime === '' && endTime === '') && (startTime >= endTime) )
                    {
                        event.preventDefault(); //Prevents form from being sent
                        alert('The start time must be less than the end time !');
                    }
                });

        
            });

        </script>
        <table>
            <?php

                //Empty the dateInput field if start_date or end_date is filled in
                if (!empty($_GET['start_date']) || !empty($_GET['end_date'])) {
                    $_GET['Date'] = ''; //Empty the Date field in GET parameters
                }

                if (!empty($measures)) {
                    
                    echo "
                        <h1>Filters</h1>
                        <!-- Table to display values retrieved from the database in an HTML table -->

                        <form action='' id='filter-form' method='GET'>
                            <!-- Form for collecting user-selected filters -->

                            <h2>&bull; Sensors selection</h2>
                            <select name='Type_sensor'>
                                <option value='' selected></option>";
                                
                            for ($i=0; $i <count($sensors) ; $i++) { 
                                echo "<option value='" . $sensors[$i]['Type_sensor'] . "'>" . $sensors[$i]['Type_sensor'] . "</option>";
                            }

                    echo "</select>

                            <h2>&bull; Rooms selection</h2>
                            <select name='Room'>
                            <option value='' selected></option>
                            ";
                            
                                for ($i=0; $i <count($rooms) ; $i++) { 
                                    echo "<option value='" . $rooms[$i]['Room'] . "'>" . $rooms[$i]['Room'] . "</option>";
                                }

                            
                    echo "</select>
                            <h2>&bull; Dates selection</h2>
                            <input type='date' name='Date' id='date_input'>
                            
                            <a href='#' id='advanced-options'> Options avancées </a>
                            <div id='options-container' style='display: none;'>
                                <label for='start_time'>Heure de début :</label>
                                <input type='time' name='start_time' id='start_time'>

                                <label for='end_time'>Heure de fin :</label>
                                <input type='time' name='end_time' id='end_time'>

                                <label for='start_date'>Date de début :</label>
                                <input type='date' name='start_date' id='start_date'>

                                <label for='end_date'>Date de fin :</label>
                                <input type='date' name='end_date' id='end_date'>
                            </div>

                            <br>
                            <input type='submit' value='Submit'>
                        
                    
                        </form>

                        <tr>

                        <th> Sensor </th>
                        <th> Building </th>
                        <th> Room </th>
                        <th> Measure </th>
                        <th> Date </th>
                        <th> Time </th>
                    
                        </tr>
                    ";

                    //Script that deletes the form's empty default choices, and if a date filter is requested, it sets the date to the correct format.
                    foreach ($_GET as $key => $value) 
                    {
                        if (isset($value) && $value ==="") 
                        {
                            unset($_GET[$key]);
                        }

                        if ($key == "Date" && !empty($value)) //Change date format If a date is entered
                        {
                            
                        }

                        switch ($key) {
                            case 'Date':
                                if (!empty($value)) {
                                    $_GET[$key] = date("d/m/Y", strtotime($value));
                                }
                                break;

                            case 'start_date':
                                if (!empty($value)) {
                                    $_GET[$key] = date("d/m/Y", strtotime($value));
                                }
                                break;

                            case 'end_date':
                                if (!empty($value)) {
                                    $_GET[$key] = date("d/m/Y", strtotime($value));
                                }
                                break;

                            default:
                                break;
                        }

                    }

                    //Script to display the values retrieved from the measures table in their respective columns
                    //Loop to display measures taking new conditions into account
                    for ($i = 0; $i < count($measures); $i++) {
                        if (empty($_GET)) {
                            //Display without filter if no field is selected
                            echo "<tr>";
                            for ($j = 0; $j < 6; $j++) {
                                echo "<td>" . $measures[$i][$j] . "</td>";
                            }
                            echo "</tr>";
                        } else {
                            //Check all the filters
                            $match = true;
                            foreach ($_GET as $key => $value) {
                                if ($key === "start_time" || $key === "end_time" || $key === "start_date" || $key === "end_date") {
                                    continue; //Ignore time and date fields
                                }
                            
                                if ($value !== $measures[$i][$key]) {
                                    $match = false;
                                    break;
                                }
                            }
                        
                            if ($match) {
                                //Filter measurements by selected times and dates
                                $measure_time = strtotime($measures[$i]['Time']);
                                //Convert date to Unix timestamp format for tests
                                $measure_date = fr_strtotime($measures[$i]['Date']);

                                if (
                                    (!isset($_GET['start_time']) || $measure_time >= strtotime($_GET['start_time'])) &&
                                    (!isset($_GET['end_time']) || $measure_time <= strtotime($_GET['end_time'])) &&
                                    (!isset($_GET['start_date']) || $measure_date >= fr_strtotime($_GET['start_date'])) &&
                                    (!isset($_GET['end_date']) || $measure_date <= fr_strtotime($_GET['end_date']))
                                ) {
                                    echo "<tr>";
                                    for ($j = 0; $j < 6; $j++) {
                                        echo "<td>" . $measures[$i][$j] . "</td>";
                                    }
                                    echo "</tr>";
                                }
                            }
                        }
                    }    
                }
                else {
                    echo "<center> <h2> No value recorded for the moment ! <h2> </center>";
                }
                mysqli_close($id_bd);
            ?>

        </table>
        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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