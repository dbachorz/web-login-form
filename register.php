<?php
    session_start();

    if(isset($_POST['email'])) {

    }
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1"/>
    <link rel="stylesheet" href="app.css">
    <title>logging system- pure PHP</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
    <form method="post">
        Login <br/> <input type="text" name="login" /> <br/>

        e-mail <br/> <input type="text" name="email" /> <br/>

        Password <br/> <input type="password" name="password" /> <br/>

        Repeat password <br/> <input type="password" name="repeatPassword" /> <br/><br/>

        <label>
            <input type="checkbox" name="termsAndCond" /> I accept the terms and conditions
        </label><br/>

        <div class="g-recaptcha" data-sitekey="6LcG3SYTAAAAAHiO06YjcAhcu0qAVq3XdrTXzdNB"></div>

        <br/><input type="submit" value="Register" />
    </form>
</body>
</html>


