<?php 
    session_start();
    
    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Admin"))
    {
        echo "Connecté en tant qu'Administrateur";
    }
    else {
        echo '<script> window.location.href = "./connection.php"; </script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Page</title>
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