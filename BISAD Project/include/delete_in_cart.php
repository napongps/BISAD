<?php

if (isset($_GET['menu_id'])) {

    $menu_id = $_GET['menu_id'];
    $cart_id = $_GET['cart_id'];
    $selected_option = $_GET['selected_option'];
    $URI=$_GET['URI'];

    require_once 'connect.php';
    require_once 'inc_functions.php';

    delete_in_cart($conn, $menu_id, $cart_id, $selected_option);


    if (str_contains($URI,'cart=deleted') || str_contains($URI,'cart=updated')) {
        $URI= str_replace("cart=updated","cart=deleted",$URI);
        $x=NULL;
    }else{
        if(parse_url($URI, PHP_URL_QUERY)==""){
            $x='?cart=deleted';
        }else{
            $x='&cart=deleted';
        }
        
    }
        header("location: ..".$URI."".$x."&current_cart=".$cart_id."");
        exit();
} else {
    header('locatin:../main/cus_main.php');
    exit();
}
