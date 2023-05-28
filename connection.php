<?php 
    session_start();
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
    
    <form action="./login.php" method="post">

        <label for="login"> Login : </label>
        <input type="text" id="login" name="login">
        <br><br>
        <label for="passwd"> Password : </label>
        <input type="password" name="passwd">

        <input type="submit" value="Send">

    </form>



</body>
</html>