<?php

    session_start();

    require_once "connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno != 0) {
        echo "Error:".$connection->connect_errno;
    }else{
        $login = $_POST['login'];
        $password = $_POST['password'];

        echo "Connection succeeded";

        $sql = "SELECT * FROM game_users WHERE user='$login' AND pass='$password'";

        if($result = @$connection->query($sql)){
            $usersCount = $result->num_rows;
            if($usersCount == 1){
                echo "Logged in succesfuly";
                $row = $result->fetch_assoc();
                $_SESSION['user'] = $row['user'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['user'] = $row['user'];
                $_SESSION['drewno'] = $row['drewno'];
                $_SESSION['kamien'] = $row['kamien'];
                $_SESSION['zboze'] = $row['zboze'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['dnipremium'] = $row['dnipremium'];
                $result->free();
                header('Location: game.php');
            }else{
                echo "wrong username or password";
            }
        }else{
            echo "Cannot establish database connection";
        }
        $connection->close();
    }
?>