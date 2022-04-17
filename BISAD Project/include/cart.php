<?php
if (isset($_GET['menu_id']) && isset($_GET['cus_id'])) {

    $menu_id = $_GET['menu_id'];
    $cus_id = $_GET['cus_id'];
    $res_id = $_GET['res_id'];
    $selected_option="";

    require_once 'connect.php';
    require_once 'inc_functions.php';
    

    if (checkNullCart($conn, $cus_id) !== false) {
        putMenu($conn,$cus_id,$menu_id,$res_id,$selected_option);
        exit();
    } else {
        createCart($conn, $cus_id);
        putMenu($conn,$cus_id,$menu_id,$res_id,$selected_option);
        exit();
    }
}else if (isset($_POST['menu_option'])){

    $menu_id = $_POST['menu_id'];
    $cus_id = $_POST['cus_id'];
    $res_id = $_POST['res_id'];
    
    if (isset($_POST['selected_option'])){
        $selected_option=serialize($_POST['selected_option']);
    }else {
        $selected_option="";
    }

    require_once 'connect.php';
    require_once 'inc_functions.php';

    if (checkNullCart($conn, $cus_id) !== false) {
        putMenu($conn,$cus_id,$menu_id,$res_id,$selected_option);
        exit();
    } else {
        createCart($conn, $cus_id);
        putMenu($conn,$cus_id,$menu_id,$res_id,$selected_option);
        exit();
    }
}
 else {
    header('locatin:../main/cus_main.php');
    exit();
}
