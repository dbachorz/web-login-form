<?php

    session_start();

    if(!isset($_POST['login']) || !isset($_POST['password'])){
        header('Location: index.php');
        exit();
    }

    require_once "connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if($connection->connect_errno != 0) {
        echo "Error:".$connection->connect_errno;
    }else{
        $login = $_POST['login'];
        $password = $_POST['password'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");

        if($query_result = @$connection->query(sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
            mysqli_real_escape_string($connection, $login)))){
            $usersCount = $query_result->num_rows;
            if($usersCount == 1){
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
                }
            }else{
                $_SESSION['error'] = '<span style="color: red;">Wrong username or password</span>';
                header('Location: index.php');
            }
        }else{
            echo "<br /><br />Cannot get query results";
        }
        $connection->close();
    }
?>