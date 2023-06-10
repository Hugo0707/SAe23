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
    require_once("../config/config.php");
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
                    <th> Delete </th>
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
        <li><a href="#" class="footer_text" >© Copyright 2023 All rights reserved</a></li>
        <li><a href="#" target="_blank"><img class="img_footer" src="./Images/HTML5.png" alt="HTML 5 Validation"></a></li>
        <li><a href="#" target="_blank"><img class="img_footer" src="./Images/CSS3.png" alt="CSS 3 Validation"></a></li>
    </ul>
    </footer>
</body>
</html>
