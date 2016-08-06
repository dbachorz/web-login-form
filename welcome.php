<?php
    session_start();
    if(!isset($_SESSION['successful_register'])){
        header('Location: index.php');
        exit();
    } else {
        unset($_SESSION['successful_register']);
    }
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1"/>
    <link rel="stylesheet" href="app.css">
    <title>logging system- pure PHP</title>
</head>

<body>

    Thank you for registering. Now you can move on and log in in this service!
    <a href="index.php">Login!</a>
    <br/><br/>

</body>
</html>


