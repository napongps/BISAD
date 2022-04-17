<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <?php
    include_once '../navbar_footer/navbar.php';
    require_once '../include/connect.php';
    $sql = "SELECT * FROM customer WHERE cus_id=$cus_id";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);
    ?>
    <div class='container mt-5'>
        <h3>ชื่อร้านค้า</h3>
        <hr>
        <div class="wrapper d-flex justify-content-center">
            <form action='../include/first_confirm.php' method='post'>
                <div class="form-inline">
                    <label for="address">ที่อยู่</label>
                    <textarea type="text" name="address" class="form-control m-3" cols="50"><?php echo $row['address']; ?></textarea>
                </div>
                <hr>
                <h4>สรุปคำสั่งซื้อ</h4>
                <?php
                $URI = $_SERVER['REQUEST_URI'];
                $URI = str_replace("error", "not", $URI);
                $cart_id = $_REQUEST['current_cart'];
                $sql = "SELECT * FROM cart_menu cm INNER JOIN menu m ON cm.menu_menu_id = m.menu_id WHERE cm.cart_cart_id=$cart_id ";
                $query = mysqli_query($conn, $sql);
                $total_price = 0;
                while ($row = mysqli_fetch_assoc($query)) {

                ?>
                    <div class="card mb-3" style="max-width: 540px; max-height:200px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src='data:image/jpeg;base64,<?php echo base64_encode($row['picture']); ?>' class="card-img">
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                    <?php
                                    // $URI = $_SERVER['REQUEST_URI'];
                                    $total_option_price = 0;
                                    if ($row['selected_option'] !== "") {
                                        $merge_option = array_combine(unserialize($row['optional']), unserialize($row['optional_price']));
                                        $option = unserialize($row['selected_option']);
                                        if ($option !== false) {
                                            foreach ($option as $i => $selected_option) {
                                                // print_r($merge_option);
                                                if ($merge_option[$selected_option] != '') {
                                                    $total_option_price += $merge_option[$selected_option];
                                                }
                                    ?>
                                                <small class="text-muted"><?php echo $selected_option . "</small><br>";
                                                                        }
                                                                    }
                                                                } ?>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <div class="warpper">
                                    <div class='row d-flex justify-content-center plus'><a <?php echo "href='../include/cart_plus_minus.php?menu_id=" . $row['menu_menu_id'] . "&cart_id=" . $row['cart_cart_id'] . "&selected_option=" . $row['selected_option'] . "&update=plus&" . $str_query . "&URI=" . $URI . "'"; ?> style='font-size:4px' class='btn btn-secondary text-white'><i class='fa fa-plus' style='font-size:12px;'></i></a></div>
                                    <div class='row d-flex justify-content-center'>
                                        <h class='qnt'><?php echo $row['amount']; ?></h>
                                    </div>
                                    <?php
                                    if ($row['amount'] <= 0) {
                                        $minus_goto = "delete_in_cart.php";
                                    } else {
                                        $minus_goto = "cart_plus_minus.php";
                                    }
                                    ?>
                                    <div class='row d-flex justify-content-center minus'><a <?php echo "href='../include/" . $minus_goto . "?menu_id=" . $row['menu_menu_id'] . "&cart_id=" . $row['cart_cart_id'] . "&selected_option=" . $row['selected_option'] . "&update=minus&" . $str_query . "&URI=" . $URI . "'"; ?>style='font-size:4px' class='btn btn-secondary text-white'><i class='fa fa-minus' style='font-size:12px;'></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    $total_price += ($row['price'] * $row['amount']) + ($total_option_price * $row['amount']);
                }

                ?>
                <input type='hidden' name='total_price' id='total_price' value='<?php echo $total_price; ?>'>
                <h4>ราคาอาหารทั้งหมด <?php echo $total_price; ?> บาท</h4>
                <hr>
                <h4>วิธีการชำระเงิน</h4>
                <div class="dropdown d-flex justify-content-center">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="payment_method" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        รูปแบบการชำระเงิน
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <input type='hidden' id='selected_payment_method' name='selected_payment_method' value=''>
                        <li><a class="dropdown-item payment">เงินสด</a></li>
                        <li><a class="dropdown-item payment">ชำระออนไลน์</a></li>
                    </div>
                </div>
                <hr>
                <h4>ค่าจัดส่ง 0 บาท</h4>
                <input type='hidden' name='shipping_cost' id='shipping_cost' value='0'>
                <h4>ราคาทั้งหมด <?php echo $total_price; ?> บาท</h4>
                <input type='hidden' name='cart_id' id='cart_id' value='<?php echo $cart_id; ?>'>
                <button type="submit" name="first_confirm" id="first_confirm" class="btn btn-success btn-block">ยืนยันคำสั่งซื้อ</button>
            </form>

        </div>
    </div>
    <script>
        document.querySelectorAll(".payment")[0].addEventListener("click", function() {
            document.getElementById('payment_method').innerText = document.querySelectorAll(".payment")[0].innerText;
            document.getElementById('selected_payment_method').value = document.querySelectorAll(".payment")[0].innerText;
        });
        document.querySelectorAll(".payment")[1].addEventListener("click", function() {
            document.getElementById('payment_method').innerText = document.querySelectorAll(".payment")[1].innerText;
            document.getElementById('selected_payment_method').value = document.querySelectorAll(".payment")[1].innerText;
        });
    </script>
    <?php

    if (isset($_GET['cart'])) {
        echo '<script type="text/javascript">window.onload = cart();</script>';
    }
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'noselectedmethod') {
            echo '<script type="text/javascript">alert("please select payment method")</script>';
        }
        if ($_GET['error'] == 'confirmedorder') {
            echo '<script type="text/javascript">alert("Order has been confirmed")</script>';
        }
    }

    include_once '../navbar_footer/footer.php';
    ?>