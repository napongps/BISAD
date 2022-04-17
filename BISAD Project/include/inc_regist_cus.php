<?php
if (isset($_POST['submit'])) {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $tel = $_POST['tel'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordcheck = $_POST['passwordcheck'];
    $imgContent=$_FILES['picture'];

    require_once 'connect.php';
    require_once 'inc_functions.php';
    

    if (invalidUsername($username) !== false) {

        header("location: ../main/index.php?error=invaliduid");
        exit();
    }
    if (passwordmatch($password, $passwordcheck) !== false) {

        header("location: ../main/index.php?error=passworddontmatch");
        exit();
    }
    if (usernameExists($conn, $username) !== false) {

        header("location: ../main/index.php?error=usernametaken");
        exit();
    }   

    cus_createUser($conn, $fname, $lname, $tel, $address, $username, $password, $imgContent);
} else {
    header("location: ../main/index.php");
    exit();
}
?>