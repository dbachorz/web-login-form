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
        $password = htmlentities($password, ENT_QUOTES, "UTF-8");

        if($result = @$connection->query(sprintf("SELECT * FROM game_users WHERE user='%s' AND pass='%s'",
            mysqli_real_escape_string($connection, $login),
            mysqli_real_escape_string($connection, $password)))){
            $usersCount = $result->num_rows;
            if($usersCount == 1){
                $_SESSION['logged'] = true;
                echo "Logged in succesfuly";
                $row = $result->fetch_assoc();
                $_SESSION['user'] = $row['user'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['drewno'] = $row['drewno'];
                $_SESSION['kamien'] = $row['kamien'];
                $_SESSION['zboze'] = $row['zboze'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['dnipremium'] = $row['dnipremium'];
                unset($_SESSION['error']);
                $result->free();
                header('Location: game.php');
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