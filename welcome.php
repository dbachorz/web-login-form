<?php
    session_start();
    if(!isset($_SESSION['successful_register'])){
        header('Location: index.php');
        exit();
    } else {
        unset($_SESSION['successful_register']);
    }

    if (isset($_SESSION['remembered_login'])) unset($_SESSION['remembered_login']);
    if (isset($_SESSION['remembered_email'])) unset($_SESSION['remembered_email']);
    if (isset($_SESSION['remembered_pass1'])) unset($_SESSION['remembered_pass1']);
    if (isset($_SESSION['remembered_pass2'])) unset($_SESSION['remembered_pass2']);
    if (isset($_SESSION['remembered_tac'])) unset($_SESSION['remembered_tac']);

    if (isset($_SESSION['e_login'])) unset($_SESSION['e_login']);
    if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
    if (isset($_SESSION['e_password'])) unset($_SESSION['e_password']);
    if (isset($_SESSION['e_terms'])) unset($_SESSION['e_terms']);
    if (isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);

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


