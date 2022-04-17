<?php
if (isset($_POST['submit'])){
    
    $res_name=$_POST['res_name'];
    $description=$_POST['description'];
    $close_open=$_POST['close_open'];
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $tel=$_POST['tel'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $passwordcheck=$_POST['passwordcheck'];
    $imgContent=$_FILES['picture'];

    require_once 'connect.php';
    require_once 'inc_functions.php';

    if (invalidUsername($username) !== false) {

        header("location: ../main/regist.php?error=invaliduid");
        exit();
    }
    if (passwordmatch($password, $passwordcheck) !== false) {

        header("location: ../main/regist.php?error=passworddontmatch");
        exit();
    }
    if (usernameExists($conn, $username) !== false) {

        header("location: ../main/regist.php?error=usernametaken");
        exit();
    }

    res_createUser($conn, $res_name, $description, $close_open, $fname, $lname, $tel, $username, $password, $imgContent);
}
else {
    header("location: ../main/regist.php");
}

?>