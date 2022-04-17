<?php
session_start();
if (isset($_POST['cancel'])) {
    header("location: ../main/restaurant.php");
    exit();
} else if (isset($_POST['add_menu'])) {

    $res_id = $_SESSION['res_id'];
    $menu_name = $_POST['add_menu_name'];

    if (isset($_POST['add_menu_description'])) {
        $menu_description = $_POST['add_menu_description'];
    } else {
        $menu_description = NULL;
    }

    if (is_uploaded_file($_FILES['add_menu_picture']['tmp_name'])) {
        $menu_picture = $_FILES['add_menu_picture']['tmp_name'];
    } else {
        $menu_picture = NULL;
    }

    if (isset($_POST['add_menu_option'])) {
        $menu_option = serialize($_POST['add_menu_option']);
        if (isset($_POST['add_menu_option_price'])){
            if (empty($_POST['add_menu_option_price'])) {
                $menu_option_price = serialize(array_fill(0,sizeof($_POST['add_menu_option']),0));
            } else {
                $menu_option_price = serialize($_POST['add_menu_option_price']);
            }
        
        }else {
            header("location: ../main/restaurant.php?error=forgotoptionprice");
            exit();
        }
    } else {
        $menu_option_price = NULL;
        $menu_option = NULL;
    }

    $menu_price = $_POST['add_menu_price'];
    if (!is_numeric($menu_price)){
        
        header("location: ../main/restaurant.php?error=pricemustbenumber");
        exit();
        
    }else{
        if((int)$menu_price < 0){
            header("location: ../main/restaurant.php?error=negativeprice");
            exit();
        }
    }

    require_once 'connect.php';
    require_once 'inc_functions.php';

    add_menu($conn,$menu_name,$menu_description,$menu_option,$menu_option_price,$menu_price,$menu_picture,$res_id);

} else {
    header("location: ../main/restaurant.php");
    exit();
}
