<?php
/**
 * Created by PhpStorm.
 * User: Damian
 * Date: 27.02.2016
 * Time: 12:48
 */
    session_start();
    session_unset();
    header('Location: index.php');
?>