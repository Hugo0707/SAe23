<?php 
    session_start();

    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Manager"))
    {
        echo "  <h2> Connecté en tant que Manager </h2> ";
    }
    else {
        echo '<script> window.location.href = "./login.php"; </script>';
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
        <title>Manager Page</title>
    </head>
    <body>

        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <br>
            <input type="submit" name="logout" value="Logout">
        </form>

        <?php

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
                
                  if (startTime >= endTime) {
                    event.preventDefault(); //Prevents form from being sent
                    alert('L\'heure de début doit être inférieure à l\'heure de fin !');
                  }
                });

        
            });

        </script>

<section>

<table>

    <?php

        //Empty the dateInput field if start_date or end_date is filled in
        if (!empty($_GET['start_date']) || !empty($_GET['end_date'])) {
            $_GET['Date'] = ''; //Empty the Date field in GET parameters
        }

        if (!empty($measures)) {
            
            echo "
                <!-- Table to display values retrieved from the database in an HTML table -->

                <form action='' id='filter-form' method='GET'>
                    <!-- Form for collecting user-selected filters -->
            
                    <select name='Type_sensor'>
                        <option value='' selected></option>";
                        
                    for ($i=0; $i <count($sensors) ; $i++) { 
                        echo "<option value='" . $sensors[$i]['Type_sensor'] . "'>" . $sensors[$i]['Type_sensor'] . "</option>";
                    }

              echo "</select>
                
                    <select name='Room'>
                    <option value='' selected></option>
                    ";
                    
                        for ($i=0; $i <count($rooms) ; $i++) { 
                            echo "<option value='" . $rooms[$i]['Room'] . "'>" . $rooms[$i]['Room'] . "</option>";
                        }

                    
              echo "</select>
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
                    <input type='submit' value='Appliquer'>
                
            
                </form>

                <tr>

                <th> Capteur </th>
                <th> Batiment </th>
                <th> Salle </th>
                <th> Mesure </th>
                <th> Date </th>
                <th> Heure </th>
            
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
            echo "<center> <h2> Aucune valeur enregistrée pour le moment ! <h2> </center>";
        }
    ?>

</table>

</section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('js-message').style.display = 'none';
            });
        </script>

        <div id="js-message" style="display: block;">
            <center> <h1> Veuillez activer JavaScript afin de permettre au site de fonctionner correctement. </h1> </center>
        </div>

    </body>
</html>