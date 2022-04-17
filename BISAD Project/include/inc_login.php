<?php

if (isset($_POST['submit'])) {
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    require_once 'connect.php';
    require_once 'inc_functions.php';

    loginUser($conn, $username, $password);
} else {
    header("location: login.php");
}
