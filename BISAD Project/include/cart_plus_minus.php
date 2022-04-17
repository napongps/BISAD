<?php

if (isset($_GET['menu_id'])) {

    $menu_id = $_GET['menu_id'];
    $cart_id = $_GET['cart_id'];
    $selected_option = $_GET['selected_option'];
    $update=$_GET['update'];
    $URI=$_GET['URI'];

    require_once 'connect.php';
    require_once 'inc_functions.php';

    if($update == 'plus'){
        plus_in_cart($conn, $menu_id, $cart_id, $selected_option);
    }else if ($update == 'minus'){
        minus_in_cart($conn, $menu_id, $cart_id, $selected_option);
    }

    // echo parse_url($URI, PHP_URL_QUERY);
    // exit();

    if (str_contains($URI,'cart=updated') || str_contains($URI,'cart=deleted')) {
        $x=NULL;
    }else{
        if(parse_url($URI, PHP_URL_QUERY)==""){
            $x='?cart=updated';
        }else{
            $x='&cart=updated';
        }
        
    }
        header("location: ..".$URI."".$x."&current_cart=".$cart_id."");
        exit();
        
} else {
    header('locatin:../main/cus_main.php');
    exit();
}
