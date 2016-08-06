<?php
    session_start();

    if (isset($_POST['email'])) {
        $correct_validation = true;

        $login = $_POST['login'];
        if ((strlen($login) < 3) || (strlen($login) > 20)) {
            $correct_validation = false;
            $_SESSION['e_login'] = 'login has to have length in between 3 and 20';
        }

        if (!ctype_alnum($login)) {
            $correct_validation = false;
            $_SESSION['e_login'] = 'login has to include alphanumeric symbols';
        }

        $email = $_POST['email'];
        $safe_email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ((!filter_var($email, FILTER_VALIDATE_EMAIL)) || ($email != $safe_email)) {
            $correct_validation = false;
            $_SESSION['e_email'] = 'type in correct email address';
        }

        $password = $_POST['password'];
        $repeat_password = $_POST['repeat_password'];

        if ((strlen($password) < 3) || (strlen($password) > 20)) {
            $correct_validation = false;
            $_SESSION['e_password'] = 'password has to have length in between 3 and 20';
        }

        if ($password !== $repeat_password) {
            $correct_validation = false;
            $_SESSION['e_password'] = 'password aren\'t identical';
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if (!!$correct_validation) {
            echo "correct validation";
            exit();
        }
    }
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge,chrome=1"/>
    <link rel="stylesheet" href="app.css">
    <title>logging system- pure PHP</title>
<!--    <script src='https://www.google.com/recaptcha/api.js'></script>-->
</head>

<body>
    <form method="post">
        Login <br/> <input type="text" name="login" /> <br/>
        <?php
            if (isset($_SESSION['e_login'])) {
                echo '<div class="error">'.$_SESSION['e_login'].'</div>';
                unset($_SESSION['e_login']);
            }
        ?>
        e-mail <br/> <input type="text" name="email" /> <br/>
        <?php
        if (isset($_SESSION['e_email'])) {
            echo '<div class="error">'.$_SESSION['e_email'].'</div>';
            unset($_SESSION['e_email']);
        }
        ?>
        Password <br/> <input type="password" name="password" /> <br/>
        <?php
        if (isset($_SESSION['e_password'])) {
            echo '<div class="error">'.$_SESSION['e_password'].'</div>';
            unset($_SESSION['e_password']);
        }
        ?>
        Repeat password <br/> <input type="password" name="repeat_password" /> <br/>
        <label>
            <input type="checkbox" name="termsAndCond" /> I accept the terms and conditions
        </label><br/>

<!--        <div class="g-recaptcha" data-sitekey="6LcG3SYTAAAAAHiO06YjcAhcu0qAVq3XdrTXzdNB"></div>-->

        <br/><input type="submit" value="Register" />
    </form>
</body>
</html>


