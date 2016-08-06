<?php
    session_start();
    if(isset($_SESSION['logged']) && $_SESSION['logged']){
        header('Location: game.php');
        exit();
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

    <a href="register.php">Zarejestruj się!</a>
    <br/><br/>

    <form class="login-form" action="signIn.php" method="post">
        <p>Login:</p>
        <input type="text" name="login">
        <p>Password:</p>
        <input type="password" name="password">
        <input type="submit" value="Sign in!">
    </form>

    <?php
        if(isset($_SESSION['error'])) echo $_SESSION['error'];
        if(isset($_SESSION['dev_info_error'])) echo $_SESSION['dev_info_error'];
    ?>

</body>
</html>


