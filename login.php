<?php

    session_start();

    if(!isset($_POST['login']) || !isset($_POST['password'])){
        header('Location: index.php');
        exit();
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $connection = @new mysqli($host, $db_user, $db_password, $db_name);
        if ($connection->connect_errno != 0) {
            throw new Exception($connection->error);
        } else {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $login = htmlentities($login, ENT_QUOTES, "UTF-8");

            if ($query_result = $connection->query(sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
                mysqli_real_escape_string($connection, $login)))
            ) {
                $usersCount = $query_result->num_rows;
                if ($usersCount == 1) {
                    $row = $query_result->fetch_assoc();
                    if (password_verify($password, $row['pass'])) {
                        $_SESSION['logged'] = true;
                        echo "Logged in succesfuly";
                        $_SESSION['user'] = $row['user'];
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['drewno'] = $row['drewno'];
                        $_SESSION['kamien'] = $row['kamien'];
                        $_SESSION['zboze'] = $row['zboze'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['dnipremium'] = $row['dnipremium'];
                        unset($_SESSION['error']);
                        $query_result->free();
                        header('Location: game.php');
                    } else {
                        $_SESSION['error'] = '<span style="color: red;">Wrong username or password</span>';
                        header('Location: index.php');
                    }
                } else {
                    $_SESSION['error'] = '<span style="color: red;">Wrong username or password</span>';
                    header('Location: index.php');
                }
            } else {
                throw new Exception($connection->error);
            }
            $connection->close();
        }
    } catch(Exception $e) {
        $_SESSION['error'] = '<span class="error">Error connecting to database</span><br/>';
        $_SESSION['dev_info_error']= '<b>dev info: </b>'.$e;
        header('Location: index.php');
    }
?>

<html>
<head>
    <link rel="stylesheet" href="app.css">
</head>

</html>
