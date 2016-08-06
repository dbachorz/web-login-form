<?php
    require_once('config/secrets.php');
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

        if (!isset($_POST['terms_and_cond'])) {
            $correct_validation = false;
            $_SESSION['e_terms'] = 'You must accept terms and conditions';
        }
        echo "secret key ".$RECAPTCHA_SECRET_KEY."<br/>";
        echo "site key ".$RECAPTCHA_SITE_KEY."<br/>";
        $check_captcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$RECAPTCHA_SECRET_KEY."&response=".$_POST['g-recaptcha-response']);
        $captcha_response = json_decode($check_captcha);

        if (!$captcha_response->success) {
            $correct_validation = false;
            $_SESSION['e_bot'] = 'Prove you\'re human!';
        }

        $_SESSION['remembered_login'] = $login;
        $_SESSION['remembered_email'] = $email;
        $_SESSION['remembered_pass1'] = $password;
        $_SESSION['remembered_pass2'] = $repeat_password;
        if(isset($_POST['terms_and_cond'])) {
            $_SESSION['remembered_tac'] = true;
        }

        require_once("connect.php");

        mysqli_report(MYSQLI_REPORT_STRICT);
        try {
            $connection = new mysqli($host, $db_user, $db_password, $db_name);

            if ($connection->connect_errno != 0) {
                throw new Exception(mysqli_connect_errno());
            } else {

                $result = $connection->query("SELECT id FROM uzytkownicy WHERE email='$email'");

                if(!$result) throw new Exception($connection->error);

                if ($result->num_rows > 0) {
                    $correct_validation = false;
                    $_SESSION['e_email'] = 'Email already exists';
                }

                $result = $connection->query("SELECT id FROM uzytkownicy WHERE user='$login'");

                if(!$result) throw new Exception($connection->error);

                if ($result->num_rows > 0) {
                    $correct_validation = false;
                    $_SESSION['e_login'] = 'Login already exists';
                }

                if ($correct_validation) {

                    if($connection->query("INSERT INTO uzytkownicy VALUES (NULL, '$login', '$hashed_password', '$email', 100, 100, 100, 14)")){
                        $_SESSION['successful_register'] = true;
                        header("Location: welcome.php");
                    } else {
                        throw new Exception($connection->error);
                    }

                    exit();
                }

                $connection->close();
            }
        } catch (Exception $e) {
            echo '<span class="error">Error connecting to server</span>';
            echo '<br/>dev info: '.$e;
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
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
    <form method="post">
        Login <br/> <input type="text" value="<?php
            if(isset($_SESSION['remembered_login'])){
                echo $_SESSION['remembered_login'];
                unset($_SESSION['remembered_login']);
            }
        ?>" name="login" /> <br/>
        <?php
            if (isset($_SESSION['e_login'])) {
                echo '<div class="error">'.$_SESSION['e_login'].'</div>';
                unset($_SESSION['e_login']);
            }
        ?>
        e-mail <br/> <input type="text" value="<?php
        if(isset($_SESSION['remembered_email'])){
            echo $_SESSION['remembered_email'];
            unset($_SESSION['remembered_email']);
        }
        ?>" name="email" /> <br/>
        <?php
        if (isset($_SESSION['e_email'])) {
            echo '<div class="error">'.$_SESSION['e_email'].'</div>';
            unset($_SESSION['e_email']);
        }
        ?>
        Password <br/> <input type="password" value="<?php
        if(isset($_SESSION['remembered_pass1'])){
            echo $_SESSION['remembered_pass1'];
            unset($_SESSION['remembered_pass1']);
        }
        ?>" name="password" /> <br/>
        <?php
        if (isset($_SESSION['e_password'])) {
            echo '<div class="error">'.$_SESSION['e_password'].'</div>';
            unset($_SESSION['e_password']);
        }
        ?>
        Repeat password <br/> <input type="password" value="<?php
        if(isset($_SESSION['remembered_pass2'])){
            echo $_SESSION['remembered_pass2'];
            unset($_SESSION['remembered_pass2']);
        }
        ?>" name="repeat_password" /> <br/>
        <label>
            <input type="checkbox" value="<?php
            if(isset($_SESSION['remembered_tac'])){
                echo checked;
                unset($_SESSION['remembered_tac']);
            }
            ?>" name="terms_and_cond" /> I accept the terms and conditions
        </label><br/>
        <?php
        if (isset($_SESSION['e_terms'])) {
            echo '<div class="error">'.$_SESSION['e_terms'].'</div>';
            unset($_SESSION['e_terms']);
        }
        ?>

        <div class="g-recaptcha" data-sitekey="<?php
            require_once('config/secrets.php');
            echo $RECAPTCHA_SITE_KEY;
        ?>"></div>
        <?php
        if (isset($_SESSION['e_bot'])) {
            echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
            unset($_SESSION['e_bot']);
        }
        ?>

        <br/><input type="submit" value="Register" />
    </form>
</body>
</html>
