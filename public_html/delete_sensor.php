<?php 
    session_start();
    if (!($_SESSION["grade"] === "Admin") || empty($_POST))
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
        <title>Sensor removal</title>
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
            //Saving the sensor identifier to be overwritten in this variable
            //Verify user input with mysli_real_escape_string function to prevent sql injections
            //This variable will be sent in the next form post to remember which sensor to delete if the choice is yes
            $id_sensor = mysqli_real_escape_string($id_bd, array_key_first($_POST));
            
        ?>

        <form method='post' action="">

            <center> 
                <h2> Do you really want to remove this sensor ? This action is irreversible ! <br> All measurements associated with this sensor will also be deleted ! </h2>
            </center>

            <label for="oui">Yes</label>
            <input type="radio" name="confirm" value="yes" id="oui">

            <label for="non">No</label>
            <input type="radio" name="confirm" value="no" id="non">
            
            <input type="hidden" name="delete" value="<?php echo $id_sensor;?>">

            <input type="submit" value="Submit">
        </form>



        <?php 

            if (isset($_POST['confirm'])) {
                
                if ($_POST['confirm'] === "yes") {

                    //Record the query that will delete this sensor from the database in the variable $query
                    $query = "DELETE FROM sensor WHERE ID_sensor = " . $_POST['delete']; 
                
                    try {
                        mysqli_query($id_bd, $query);
                    } catch (Exception $e) {
                        echo " ERROR :  " . $e;
                        die("SQL REQUEST ERROR SENSOR NOT DELETED : <br>" . $e);
                    }

                    echo '
                        <center> <h1> SENSOR SUCCESSFULLY REMOVED </h1> </center>
                        <script>
                            setTimeout(function() {
                                window.location.href = "./admin.php";
                            }, 1500); 
                        </script>';
                }
                elseif ($_POST['confirm'] === "no") {
                    echo '<script> window.location.href = "./admin.php"; </script>';
                }
            }      
            ?>
        </section>
    </body>
</html>


