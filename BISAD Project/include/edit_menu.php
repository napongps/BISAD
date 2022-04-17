<?php
if (isset($_POST['edit_menu'])) {

    $menu_id = $_POST['menu_id'];

    require_once 'connect.php';
    require_once 'inc_functions.php';

    $sql = "SELECT * FROM menu WHERE menu_id='$menu_id'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);

    $menu_name = $_POST['edit_menu_name'];

    if (isset($_POST['edit_menu_description'])) {
        $menu_description = $_POST['edit_menu_description'];
    } else {
        $menu_description = NULL;
    }

    if (is_uploaded_file($_FILES['edit_menu_picture']['tmp_name'])) {
        $menu_picture = file_get_contents($_FILES['edit_menu_picture']['tmp_name']);
    } else {
        $menu_picture = $row['picture'];
    }

    if (isset($_POST['edit_menu_option'])) {
        $menu_option = serialize($_POST['edit_menu_option']);
        if (isset($_POST['edit_menu_option_price'])) {
            if (empty($_POST['edit_menu_option_price'])) {
                $menu_option_price = serialize(array_fill(0,sizeof($_POST['edit_menu_option']),0));
            } else {
                $menu_option_price = serialize($_POST['edit_menu_option_price']);
            }
        } else {
            header("location: ../main/restaurant.php?error=forgotoptionprice");
            exit();
        }
    } else {
        $menu_option = NULL;
    }

    $menu_price = $_POST['edit_menu_price'];
    if (!is_numeric($menu_price)) {

        header("location: ../main/restaurant.php?error=pricemustbenumber");
        exit();
    } else {
        if ((int)$menu_price < 0) {
            header("location: ../main/restaurant.php?error=negativeprice");
            exit();
        }
    }

    update_menu($conn, $menu_id, $menu_name, $menu_description, $menu_picture, $menu_option, $menu_option_price, $menu_price);
} else {
    header("location: ../main/restaurant.php");
    exit();
}
