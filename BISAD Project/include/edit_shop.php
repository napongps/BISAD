<?php

if (isset($_POST['edit_shop'])) {
    session_start();
    $res_id = $_SESSION['res_id'];

    require_once 'connect.php';
    require_once 'inc_functions.php';

    $sql = "SELECT * FROM restaurant WHERE res_id='$res_id'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);

    $res_name = $_POST['res_name'];
    $res_description = $_POST['res_description'];
    $res_tel = $_POST['res_tel'];
    $res_open = $_POST['res_open'];
    echo $res_name;
    echo $res_description;
    echo $res_tel;
    echo  $res_open;

    if (is_uploaded_file($_FILES['res_picture']['tmp_name'])) {
        $res_picture = file_get_contents($_FILES['res_picture']['tmp_name']);
    } else {
        $res_picture = $row['picture'];
    }

    update_shop($conn,$res_id, $res_name, $res_description, $res_tel, $res_open, $res_picture);
}
else {
    header("location: ../main/restaurant.php");
    exit();
}
