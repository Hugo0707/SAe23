<?php 
    session_start();

    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Manager"))
    {
        echo " <center> <h1> Connecté en tant que Manager </h1> </center>";
    }
    else {
        echo '<script> window.location.href = "./login.php"; </script>';
    }
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
            
        
        ?>

    </body>
</html>