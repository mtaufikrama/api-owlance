<?php 
require_once("../vendor/autoload.php");
require_once("../src/jwt.php");
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
?>

<!DOCTYPE html>
<html>

<head>
    <title>jwtest</title>
</head>

<body>
    <?php
      
        if(isset($_POST['button1'])) { 
        	$token = getLoginToken("asd","qwe","asdqwe");
            echo $token;
        } 
        if(isset($_POST['button2'])) { 
            $verif = checkValid("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1aWQiOiJhc2QiLCJ1bmFtZSI6InF3ZSIsInBhc3N3b3JkIjoiYXNkcXdlIiwiaXNzIjoiaHR0cDovL2xvY2FsaG9zdCIsImV4cCI6MTYwMTI2NTU4Mn0.7e4U8M8Tb_O1g0KMfU-Du1iue3YiDIvjT6WrykztyaA");
        } 
    ?>

    <form method="post">
        <input type="submit" name="button1" value="Button1" />

        <input type="submit" name="button2" value="Button2" />
    </form>
</body>

</html>