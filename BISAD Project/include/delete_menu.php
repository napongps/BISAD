<?php
if(isset($_POST['delete_menu'])){
    $menu_id = $_POST['menu_id'];

    require_once 'connect.php';
    require_once 'inc_functions.php';

    delete_menu($conn, $menu_id);

}else{
    header("location: ../main/restaurant.php");
    exit();
}
