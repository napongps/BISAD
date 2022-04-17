<?php
    if(isset($_POST['first_confirm'])){

        $cart_id=$_POST['cart_id'];
        $address=$_POST['address'];
        $total_price=$_POST['total_price'];
        $shipping_cost=$_POST['shipping_cost'];
        if($_POST['selected_payment_method']!=''){
            $selected_payment_method=$_POST['selected_payment_method'];
        }else{
            header("location: ../main/order_detail.php?error=noselectedmethod&current_cart=$cart_id");
            exit();
        }

        require_once 'connect.php';
        require_once 'inc_functions.php';

        if (!checkconfirmedcart($conn,$cart_id)){
        insert_order_detail($conn,$address,$shipping_cost,$total_price,$selected_payment_method,$cart_id);
        update_confirm1($conn,$cart_id);

        header("location: ../main/delivery_status.php");
        exit();
        }
        header("location: ../main/order_detail.php?error=confirmedorder&current_cart=$cart_id");
        exit();

    }else {
        header("location: ../main/cus_main.php");
        exit();
    }
