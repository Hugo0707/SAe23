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
    <title>Add Building</title>
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
           die("ERROR DATA RECOVERY FAILED : <br>" . $e);
        }

        //Placing values in the buildings table
        $buildings = fetchResults($result);
    ?>
    

    <form action="./add_building.php" method="POST">

        <h1> Add Building </h1>

        <label for="Name_building"> Building name :  </label>
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
                    echo "<center> <h1> You've already added all the available buildings ! </h1> </center>
                    <script>
                        setTimeout(function() {
                            window.location.href = './admin.php';
                        }, 1500); 
                    </script>";
                }
                
            ?>
        <br><br>
        <label for="Login_manager"> Manager login  : </label>
        <input type="text" name="Login_manager">
        <br><br>
        <label for="Email_manager"> Manager's email :  </label>
        <input type="text" name="Email_manager">
        <br><br>
        <label for="Password_manager"> Manager's password : </label>
        <input type="password" name="Password_manager">
        <br><br>

        <input type="submit" value="ADD">
        

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
                die("SQL REQUEST ERROR THE BUILDING HAS NOT BEEN ADDED ! : <br>" . $e);
            }
            
            //Redirect to admin page
            echo '<center> <h4> BUILDING SUCCESSFULLY ADDED ! </h4> </center>
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
       
    
    ?>
    </section>
</body>
</html>