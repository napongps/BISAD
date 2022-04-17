<?php

function invalidUsername($username)
{
    $result;
    if (!preg_match("/^[ก-๙a-zA-Z0-9]{1,30}$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function passwordmatch($password, $passwordcheck)
{
    $result;
    if ($password !== $passwordcheck) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function usernameExists($conn, $username)
{
    $cus_user = false;
    $res_user = false;
    $sql = "SELECT * FROM customer WHERE username = ?; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/regist.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultCus = mysqli_stmt_get_result($stmt);

    $sql = "SELECT * FROM restaurant WHERE username = ?; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/regist.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultRes = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultCus)) {
        $cus_user = true;
    } else if ($row = mysqli_fetch_assoc($resultRes)) {
        $res_user = true;
    }

    if ($res_user || $cus_user) {
        return $row;
    } else {
        $result = false;
    }
    return $result;

    mysqli_stmt_close($stmt);
}

function cus_createUser($conn, $fname, $lname, $tel, $address, $username, $password, $imgContent)
{
    if (is_uploaded_file($imgContent['tmp_name'])) {

        if ($imgContent['size'] > 2000000) {
            header("location: ../main/regist.php?error=picturetoobig");
            exit();
        } else {
            $file = $imgContent['tmp_name'];
            $image = file_get_contents($file);

            // Upload files and store in database
            $sql = "INSERT INTO customer (firstname,lastname,tel,address,username,password,picture) VALUES (?,?,?,?,?,?,?); ";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../main/regist.php?error=stmtfailed");
                exit();
            }

            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

            mysqli_stmt_bind_param($stmt, "ssssssb", $fname, $lname, $tel, $address, $username, $hashedpassword, $image);
            mysqli_stmt_send_long_data($stmt, 6, $image);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header("location: ../main/login.php?success");
            exit();
        }
    } else {
        header("location: ../main/regist.php?error=nopicture");
        exit();
    }
}

function res_createUser($conn, $res_name, $description, $close_open, $fname, $lname, $tel, $username, $password, $imgContent)
{
    if (is_uploaded_file($imgContent['tmp_name'])) {
        if ($imgContent['size'] > 2000000) {
            header("location: ../main/regist.php?error=picturetoobig");
            exit();
        } else {


            $file = $imgContent['tmp_name'];
            $image = file_get_contents($file);

            // Upload files and store in database
            $sql = "INSERT INTO restaurant (res_name,description,open,username,password,firstname,lastname,tel,picture) VALUES (?,?,?,?,?,?,?,?,?); ";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../main/regist.php?error=stmtfailed");
                exit();
            }

            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

            mysqli_stmt_bind_param($stmt, "ssssssssb", $res_name, $description, $close_open, $username, $hashedpassword, $fname, $lname, $tel, $image);
            mysqli_stmt_send_long_data($stmt, 8, $image);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header("location: ../main/login.php?success");
            exit();
        }
    } else {
        header("location: ../main/regist.php?error=nopicture");
        exit();
    }
}

function loginUser($conn, $username, $password)
{

    $usernameExist = usernameExists($conn, $username);

    if ($usernameExist === false) {
        header("location: ../main/login.php?error=nousername");
        exit();
    }

    $passwordindb = $usernameExist['password'];
    $checkpassword = password_verify($password, $passwordindb);

    if ($checkpassword === false) {
        header("location: ../main/login.php?error=wrongpassword");
        exit();
    } else if ($checkpassword === true) {
        if (array_key_exists('cus_id', $usernameExist)) {
            session_start();
            $_SESSION['cus_id'] = $usernameExist['cus_id'];
            $_SESSION['username'] = $usernameExist['username'];
            header('location: ../main/cus_main.php');
            exit();
        } else if (array_key_exists('res_id', $usernameExist)) {
            session_start();
            $_SESSION['res_id'] = $usernameExist['res_id'];
            $_SESSION['username'] = $usernameExist['username'];
            header('location: ../main/restaurant.php');
            exit();
        }
    }
}

//menu

function add_menu($conn, $menu_name, $menu_description, $menu_option, $menu_option_price, $menu_price, $menu_picture, $res_id)
{
    if ($menu_picture == NULL) {
        $image = NULL;
    } else {
        $image = file_get_contents($menu_picture);
    }

    $sql = "INSERT INTO menu (name,description,optional,optional_price,price,picture,restaurant_res_id) VALUES (?,?,?,?,?,?,?); ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/restaurant.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssbs", $menu_name, $menu_description, $menu_option, $menu_option_price, $menu_price, $image, $res_id);
    mysqli_stmt_send_long_data($stmt, 5, $image);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../main/restaurant.php?addedmenu");
    exit();
}

function update_menu($conn, $menu_id, $menu_name, $menu_description, $menu_picture, $menu_option, $menu_option_price, $menu_price)
{
    if ($menu_picture == NULL) {
        $image = NULL;
    } else {
        $image = $menu_picture;
    }

    $sql = "UPDATE menu SET name=?, description=?, optional=?,optional_price=?, price=?, picture=? WHERE menu_id = ?; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/restaurant.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssbs", $menu_name, $menu_description, $menu_option, $menu_option_price, $menu_price, $image, $menu_id);
    mysqli_stmt_send_long_data($stmt, 5, $image);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../main/restaurant.php?updatedmenu");
    exit();
}

function delete_menu($conn, $menu_id)
{
    $sql = "DELETE FROM menu WHERE menu_id=$menu_id;";
    mysqli_query($conn, $sql);

    header("location: ../main/restaurant.php?deletedmenu");
    exit();
}

function update_shop($conn, $res_id, $res_name, $res_description, $res_tel, $res_open, $res_picture)
{
    if ($res_picture == NULL) {
        $image = NULL;
    } else {
        $image = $res_picture;
    }

    $sql = "UPDATE restaurant SET res_name=?, description=?, open=?, tel=?, picture=? WHERE res_id = ?; ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/restaurant.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssbs", $res_name, $res_description, $res_open, $res_tel, $image, $res_id);
    mysqli_stmt_send_long_data($stmt, 4, $image);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../main/restaurant.php?updatedshop");
    exit();
}

function  checkNullCart($conn, $cus_id)
{
    $sql = "SELECT * FROM cart WHERE customer_cus_id=? AND confirm_status1 IS NULL";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/cus_main.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $cus_id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        return false;
    }
    mysqli_stmt_close($stmt);
}

function createCart($conn, $cus_id)
{
    $sql = "INSERT INTO cart (customer_cus_id) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/shop.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $cus_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function samemenu($conn, $cart_id, $menu_id, $selected_option)
{

    $sql = "SELECT * FROM cart_menu WHERE menu_menu_id=? AND cart_cart_id=? AND selected_option=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/cus_main.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $menu_id, $cart_id, $selected_option);

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);
}


function putMenu($conn, $cus_id, $menu_id, $res_id, $selected_option)
{
    $cart_id = checkNullCart($conn, $cus_id)['cart_id'];

    if (samemenu($conn, $cart_id, $menu_id, $selected_option) !== false) {
        $amount = samemenu($conn, $cart_id, $menu_id, $selected_option)['amount'] + 1;

        $sql = "UPDATE cart_menu SET amount=? WHERE menu_menu_id=? AND cart_cart_id=? AND selected_option=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../main/cus_main.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "iiis", $amount, $menu_id, $cart_id, $selected_option);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("location: ../main/shop.php?res_id=$res_id&cart=added");
        exit();
    } else {
        $sql = "INSERT INTO cart_menu (menu_menu_id,cart_cart_id,selected_option) VALUES (?,?,?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../main/cus_main.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "iis", $menu_id, $cart_id, $selected_option);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("location: ../main/shop.php?res_id=$res_id&cart=added");
        exit();
    }
}


function delete_in_cart($conn, $menu_id, $cart_id, $selected_option)
{

    $sql = "DELETE FROM cart_menu WHERE menu_menu_id=$menu_id AND cart_cart_id=$cart_id AND selected_option='$selected_option'";
    mysqli_query($conn, $sql);
}

function  plus_in_cart($conn, $menu_id, $cart_id, $selected_option)
{

    $sql = "SELECT * FROM cart_menu WHERE menu_menu_id=$menu_id AND cart_cart_id=$cart_id AND selected_option='$selected_option' ";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);
    $updated_amount = $row['amount'] + 1;

    $sql = "UPDATE cart_menu SET amount=$updated_amount WHERE menu_menu_id=$menu_id AND cart_cart_id=$cart_id AND selected_option='$selected_option'";
    mysqli_query($conn, $sql);
}


function minus_in_cart($conn, $menu_id, $cart_id, $selected_option)
{

    $sql = "SELECT * FROM cart_menu WHERE menu_menu_id=$menu_id AND cart_cart_id=$cart_id AND selected_option='$selected_option' ";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);
    $updated_amount = $row['amount'] - 1;

    $sql = "UPDATE cart_menu SET amount=$updated_amount WHERE menu_menu_id=$menu_id AND cart_cart_id=$cart_id AND selected_option='$selected_option'";
    mysqli_query($conn, $sql);
}

function checkconfirmedcart($conn, $cart_id)
{

    $sql = "SELECT * FROM cart WHERE cart_id=$cart_id";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);
    if ($row['confirm_status2'] !== NULL) {
        $status = 'second_confirmed';
        return $status;
    } else if ($row['confirm_status1'] !== NULL) {
        $status = 'first_confirmed';
        return $status;
    }
    return false;
}

function insert_order_detail($conn, $address, $shipping_cost, $total_price, $selected_payment_method, $cart_id)
{
    $sql = "INSERT INTO order_detail (address,shipping_cost,total_cost,payment_method,cart_cart_id) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../main/cus_main.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $address, $shipping_cost, $total_price, $selected_payment_method, $cart_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function update_confirm1($conn, $cart_id)
{

    $sql = "UPDATE cart SET confirm_status1=NOW() WHERE cart_id=$cart_id";
    mysqli_query($conn, $sql);
}
