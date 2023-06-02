<?php 
    session_start();

    if ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Admin")) 
    {
        echo '<script> window.location.href = "./admin.php"; </script>';
    }
    elseif ((isset($_SESSION["login"])) && ($_SESSION["grade"] === "Manager")) {
        echo '<script> window.location.href = "./manager.php"; </script>';
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection</title>
</head>
<body>

    <div id="js-message" style="display: block;">
        <center> <h1> Veuillez activer JavaScript pour profiter pleinement de notre site. </h1> </center>
    </div>
    
    <form action="./login.php" method="post">

        <label for="login"> Login : </label>
        <input type="text" id="login" name="login">
        <br><br>
        <label for="passwd"> Password : </label>
        <input type="password" name="passwd">
        <br><br>

        <input type="submit" value="Send">

    </form>



</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('js-message').style.display = 'none';
    });
</script>