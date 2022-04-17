<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant</title>

    <link rel="stylesheet" href="restaurant.css">

    <!-- Bootstrap 4.0 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <?php
    include_once '../navbar_footer/navbar.php';
    ?>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

<body>
    <div class="container">
        <div class="wrapper">
            <div class="order-box">
                <a href="#" onclick="ShowOrder()">
                    <div class="card">
                        <div class="row">
                            <div class="col-1">
                                <img src="pic/order.png" class="card-img-left">
                            </div>
                            <div class="col-10">
                                <h3 class="card-title">ออเดอร์วันนี้</h3>
                            </div>
                            <div class="col-1">
                                <img src="pic/next.png">
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <ul class="button-list">
                <li class="button-box li m-5" onclick="ShowMenulist()">
                    <a href="#">
                        <div class="card zoom">
                            <img src="pic/menu.png" class="card-img-top">
                            <p>จัดการรายการอาหาร</p>
                        </div>
                    </a>
                </li>
                <li class="button-box li m-5" onclick="ShowEditInform()">
                    <a href="#">
                        <div class="card zoom">
                            <img src="pic/cafe.png" class="card-img-top">
                            <p>แก้ไขข้อมูลร้าน</p>
                        </div>
                    </a>
                </li>
                <li class="button-box li m-5" onclick="ShowOrderHistory()">
                    <a href="#">
                        <div class="card zoom">
                            <img src="pic/history.png" class="card-img-top">
                            <p>ประวัติการสั่งซื้อ</p>
                        </div>
                    </a>
                </li>
            </ul>

            <div class="menu-list" id="menu-list">
                <h3>รายการอาหาร</h3>
                <div class="row">
                    <?php
                    require_once '../include/connect.php';
                    $sql = "SELECT * FROM menu WHERE restaurant_res_id ='" . $res_id . "'";
                    $query = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<div class='col-4 mb-3'>";
                        echo "<div class='card pt-4'>";
                        echo    "<div class='row'>";
                        echo       "<div class='col'>";
                        echo            "<img class='card-img-top' src='data:image/jpeg;base64," . base64_encode($row['picture']) . "' style='width: 120px; height: 120px;'>";
                        echo        "</div>";
                        echo        "<div class='col'>";
                        echo            "<div class='card-body'>";
                        echo                "<p class='card-title'>" . $row['name'] . "</p>";
                        echo                "<p class='card-title'><span style='color:green;'>" . $row['price'] . "</span> บาท</p>";
                        echo                "<form style='display: inline; margin-left:4px;' action='' method='POST' enctype='multipart/form-data'>";
                        echo                    "<a class='btn btn-outline-primary btn-sm' href='restaurant.php?id=" . $row['menu_id'] . "' onclick='ShowEditMenu()'>แก้ไข</a>";
                        echo                "</form>";
                        echo                "<form style='display: inline; margin-left:4px;' action='../include/delete_menu.php' method='POST' enctype='multipart/form-data'>";
                        echo                    "<input type='hidden' name='menu_id' value='" . $row['menu_id'] . "' />";
                        echo                    "<button type='submit' name='delete_menu'class='btn btn-outline-danger btn-sm'>ลบ</button>";
                        echo                "</form>";
                        echo            "</div>";
                        echo        "</div>";
                        echo    "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>

                    <div class="button-box">
                        <button type="button" class="btn btn-outline-primary btn-block" onclick="ShowAddMenu()">เพิ่ม</button>
                    </div>
                </div>
            </div>

            <div class="edit-inform" id="edit-inform">
                <form class="form" action='../include/edit_shop.php' method='post' enctype='multipart/form-data'>
                    <?php
                    $sql = "SELECT * FROM restaurant WHERE res_id =$res_id";
                    $query = mysqli_query($conn, $sql);
                    $shop = mysqli_fetch_assoc($query);

                    $res_name = $shop['res_name'];
                    $description = $shop['description'];
                    $open = $shop['open'];
                    $tel = $shop['tel'];
                    $picture = base64_encode($shop['picture']);
                    ?>

                    <div class="img-box">
                        <img id='output_shoppic' src="data:image/jpeg;base64,<?php echo $picture; ?>">
                    </div>

                    <label for="res_name">ชื่อร้าน</label>
                    <input class="form-control" id="res_name" name='res_name' type="text" placeholder="ชื่อร้าน" value="<?php echo $res_name; ?>">

                    <label for="res_name">รูปภาพ</label>
                    <input class="form-control" id="picture" name='res_picture' type="file" onchange="shop_pic(event)">
                    <script>
                        function shop_pic(event) {
                            var preview = document.getElementById("output_shoppic");
                            if (event.target.files.length > 0) {
                                var src = URL.createObjectURL(event.target.files[0]);
                                preview.src = src;
                                preview.style.display = "block";
                            } else if (event.target.files.length == 0) {
                                preview.style.display = "none";
                            }
                        }
                    </script>

                    <label for="description">คำอธิบาย</label>
                    <textarea class="form-control" id="description" name='res_description' rows="3" placeholder="คำอธิบาย"><?php echo $description; ?></textarea>

                    <label for="description">เบอร์โทรศัพท์</label>
                    <input class="form-control" id="tel" type='text' name='res_tel' placeholder="เบอร์โทรศัพท์" value='<?php echo $tel; ?>'>

                    <div class="row px-3 p-3">
                        <div class="col-sm-2">
                            <label class="text-grey mt-1 mb-3">เวลาเปิด-ปิด</label>
                        </div>
                        <div class="col-sm-2">
                            <input class="ml-1" type="text" name="res_open" value="<?php echo $open ?>">
                        </div>
                        <!-- <div class="col-sm-10 list">
                            <div class="mob">
                                <label class="text-grey mr-1">เปิด</label>
                                <input class="ml-1" type="time" name="from">
                            </div>
                            <div class="mob mb-2">
                                <label class="text-grey mr-4">ปิด</label>
                                <input class="ml-1" type="time" name="to">
                            </div>
                            <div class="mt-1 cancel fa fa-times text-danger"></div>
                        </div> -->
                    </div>

                    <div class="row">
                        <div class="col">
                            <button type="submit" name='cancel' id='cancel' class="btn btn-outline-danger btn-block">ยกเลิก</button>
                        </div>

                        <div class="col">
                            <button type="submit" name='edit_shop' id='edit_shop' class="btn btn-outline-primary btn-block">บันทึก</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="order-history" id="order-history">
                <h3>ประวัติการสั่งซื้อ</h3>
                <div class="card pt-4">
                    <div class="row">
                        <div class="col">
                            <p class="card-title">ชื่อผู้สั่งซื้อ</p>
                        </div>
                        <div class="col">
                            <p class="card-title">ราคารวม</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="card-title">สถานะ โสด</p>
                        </div>
                    </div>
                </div>

                <div class="card pt-4">
                    <div class="row">
                        <div class="col">
                            <p class="card-title">ชื่อผู้สั่งซื้อ</p>
                        </div>
                        <div class="col">
                            <p class="card-title">ราคารวม</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="card-title">สถานะ โสด</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="add-box" id="add-box">
                <form class="form" id='add_form' action='../include/add_menu.php' method='post' enctype='multipart/form-data'>
                    <h3>เพิ่มรายการอาหาร</h3>
                    <div class='m-3'>
                        <img id="add_output" src="" width="200px" height="200px" style='display:none;' />
                    </div>
                    <label for="add_menu_name">ชื่อเมนู</label>
                    <input class="form-control" id="add_menu_name" name='add_menu_name' type="text" placeholder="ชื่อเมนู" required />

                    <label for="add_menu_picture">รูปภาพเมนู</label><br>
                    <small class='form-text text-muted' name='menu_picture'>เฉพาะ jpeg png jpg เท่านั้น</small>
                    <input type="file" class="form-control" id="add_menu_picture" name='add_menu_picture' accept="image/jpeg, image/png, image/jpg" onchange="add_showpic(event)" />

                    <script>
                        function add_showpic(event) {
                            var preview = document.getElementById("add_output");
                            if (event.target.files.length > 0) {
                                var src = URL.createObjectURL(event.target.files[0]);
                                preview.src = src;
                                preview.style.display = "block";
                            } else if (event.target.files.length == 0) {
                                preview.style.display = "none";
                            }
                        }
                    </script>

                    <label for="add_menu_description">คำอธิบาย</label>
                    <input class="form-control" id="add_menu_description" name='add_menu_description' type="text" placeholder="คำอธิบาย" />

                    <label for="add_menu_price">ราคา</label>
                    <input class="form-control" id="add_menu_price" name='add_menu_price' type="number" placeholder="ราคา" required />

                    <button type="button" name='add_more_optional' id='add_more_optional' class="btn btn-outline-primary btn-lg btn-sm" onclick='add_moreoption()'>เพิ่มตัวเลือก</button>
                    <script type="text/javascript">
                        var i = 1;

                        function add_moreoption() {
                            let last = document.getElementById('add_more_optional');
                            let div_row = document.createElement('div');
                            div_row.setAttribute('class', 'form-row');

                            let div_group_name = document.createElement('div');
                            div_group_name.setAttribute('class', 'form-group col-10');

                            let div_group_price = document.createElement('div');
                            div_group_price.setAttribute('class', 'form-group col-2')

                            let label_name = document.createElement('label');
                            label_name.setAttribute('for', 'add_menu_option');
                            label_name.innerText = `ตัวเลือกที่ ${i}`;

                            let label_price = document.createElement('label');
                            label_price.setAttribute('for', 'add_menu_option_price');
                            label_price.innerText = `ราคา`;

                            i += 1;
                            let input = document.createElement('input');
                            input.setAttribute('class', 'form-control');
                            input.setAttribute('name', 'add_menu_option[]');
                            input.setAttribute('type', 'text');
                            input.setAttribute('placeholder', 'ตัวเลือก');
                            let price = document.createElement('input');
                            price.setAttribute('class', 'form-control');
                            price.setAttribute('name', 'add_menu_option_price[]');
                            price.setAttribute('type', 'number');
                            price.setAttribute('placeholder', 'ราคา');

                            div_group_name.appendChild(label_name);
                            div_group_name.appendChild(input);
                            div_group_price.appendChild(label_price);
                            div_group_price.appendChild(price);
                            div_row.appendChild(div_group_name);
                            div_row.appendChild(div_group_price);


                            last.insertAdjacentElement("beforebegin", div_row);

                        }
                    </script>
                    <div class="button-box m-3">
                        <button type="submit" name='cancel' id='cancel' class="btn btn-outline-danger">ยกเลิก</button>
                        <button type="submit" name='add_menu' id='add_menu' class="btn btn-outline-success">บันทึก</button>
                    </div>
                </form>
            </div>
            <?php
            if (isset($_GET['id'])) {
                $sql = 'SELECT * FROM menu WHERE menu_id="' . $_GET['id'] . '"';
                $query = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($query);

                $menu_name = $row['name'];
                $menu_description = $row['description'];

                if ($row['optional'] == NULL) {
                    $menu_option = [];
                    $menu_option_price = [];
                } else {
                    $menu_option = unserialize($row['optional']);
                    $menu_option_price = unserialize($row['optional_price']);
                    // print_r($menu_option);
                    // print_r($menu_option_price);
                    $merge_option = array_combine($menu_option, $menu_option_price);
                }

                $menu_price = $row['price'];
                $menu_picture = base64_encode($row['picture']);
            } else {
                $menu_name = "";
                $menu_description = "";
                $menu_option = [];
                $menu_price = "";
                $menu_picture = "";
            }
            ?>
            <div class="work-box" id="work-box">
                <form class="form" id='edit_form' action='../include/edit_menu.php' method='post' enctype='multipart/form-data'>
                    <h3>แก้ไขรายการอาหาร</h3>
                    <input type="hidden" name="menu_id" value="<?php echo $row['menu_id'] ?>" />
                    <div class='m-3'>
                        <img id="edit_output" src="data:image/jpeg;base64,<?php echo $menu_picture; ?>" width="200px" height="200px" style='display:block;' />
                    </div>
                    <label for="edit_menu_name">ชื่อเมนู</label>
                    <input class="form-control" id="edit_menu_name" name='edit_menu_name' type="text" placeholder="ชื่อเมนู" value='<?php echo $menu_name; ?>' required />

                    <label for="edit_menu_picture">รูปภาพเมนู</label><br>
                    <small class='form-text text-muted' name='edit_menu_picture'>เฉพาะ jpeg png jpg เท่านั้น</small>
                    <input type="file" class="form-control" id="edit_menu_picture" name='edit_menu_picture' accept="image/jpeg, image/png, image/jpg" onchange="edit_showpic(event)" />

                    <script>
                        function edit_showpic(event) {
                            var preview = document.getElementById("edit_output");
                            if (event.target.files.length > 0) {
                                var src = URL.createObjectURL(event.target.files[0]);
                                preview.src = src;
                                preview.style.display = "block";
                            } else if (event.target.files.length == 0) {
                                preview.style.display = "none";
                            }
                        }
                    </script>

                    <label for="edit_menu_description">คำอธิบาย</label>
                    <input class="form-control" id="edit_menu_description" name='edit_menu_description' type="text" placeholder="คำอธิบาย" value='<?php echo $menu_description; ?>' />

                    <label for="edit_menu_price">ราคา</label>
                    <input class="form-control" id="edit_menu_price" name='edit_menu_price' type="number" placeholder="ราคา" value='<?php echo $menu_price; ?>' required />
                    <?php
                    $i = 0;
                    if (isset($merge_option)) {
                        foreach ($merge_option as $name => $price) {
                            if ($name != '') {
                    ?>
                                <div class="form-row">
                                    <div class="form-group col-md-10">
                                        <label for='edit_menu_option'>ตัวเลือกที่ <?php echo $i + 1; ?></label>
                                        <input class='form-control' name='edit_menu_option[]' type='text' placeholder='ตัวเลือก' value='<?php echo $name; ?>'>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="edit_menu_option_price">ราคา</label>
                                        <input class='form-control' name='edit_menu_option_price[]' type='number' placeholder='ราคา' value='<?php echo $price; ?>'>
                                    </div>
                                </div>
                    <?php
                            }
                            $i += 1;
                        };
                    }
                    ?>

                    <!-- <label for='edit_menu_option'>ตัวเลือกที่ $i+1</label>
                    <input class='form-control' name='edit_menu_option[]' type='text' placeholder="ตัวเลือก"> -->
                    <button type="button" name='edit_more_optional' id='edit_more_optional' class="btn btn-outline-primary btn-lg btn-sm" onclick='edit_moreoption()'>เพิ่มตัวเลือก</button>
                    <script type="text/javascript">
                        if (<?php echo sizeof($menu_option); ?> == 0) {
                            var j = 1;
                        } else {
                            var j = <?php echo sizeof($menu_option) + 1; ?>;
                        }

                        function edit_moreoption() {

                            let last = document.getElementById('edit_more_optional');
                            let div_row = document.createElement('div');
                            div_row.setAttribute('class', 'form-row');

                            let div_group_name = document.createElement('div');
                            div_group_name.setAttribute('class', 'form-group col-10');

                            let div_group_price = document.createElement('div');
                            div_group_price.setAttribute('class', 'form-group col-2')

                            let label_name = document.createElement('label');
                            label_name.setAttribute('for', 'edit_menu_option');
                            label_name.innerText = `ตัวเลือกที่ ${j}`;

                            let label_price = document.createElement('label');
                            label_price.setAttribute('for', 'edit_menu_option_price');
                            label_price.innerText = `ราคา`;

                            j += 1;
                            let input = document.createElement('input');
                            input.setAttribute('class', 'form-control');
                            input.setAttribute('name', 'edit_menu_option[]');
                            input.setAttribute('type', 'text');
                            input.setAttribute('placeholder', 'ตัวเลือก');
                            let price = document.createElement('input');
                            price.setAttribute('class', 'form-control');
                            price.setAttribute('name', 'edit_menu_option_price[]');
                            price.setAttribute('type', 'number');
                            price.setAttribute('placeholder', 'ราคา');

                            div_group_name.appendChild(label_name);
                            div_group_name.appendChild(input);
                            div_group_price.appendChild(label_price);
                            div_group_price.appendChild(price);
                            div_row.appendChild(div_group_name);
                            div_row.appendChild(div_group_price);


                            last.insertAdjacentElement("beforebegin", div_row);

                        }
                    </script>
                    <div class="button-box m-3">
                        <button type="submit" name='cancel' id='cancel' class="btn btn-outline-danger">ยกเลิก</button>
                        <button type="submit" name='edit_menu' id='edit_menu' class="btn btn-outline-success">บันทึก</button>
                    </div>
                </form>
            </div>
            <div class="order" id="order">
                <p>ออเดอร์วันนี้</p>
                <?php
                $today=date("Y-m-d");
                echo $today;
                $sql = "SELECT * FROM cart_menu cm JOIN cart c on cm.cart_cart_id=c.cart_id JOIN menu m on cm.menu_menu_id=m.menu_id JOIN customer cus on cus.cus_id=c.customer_cus_id WHERE m.restaurant_res_id=$res_id AND confirm_status1='$today' GROUP BY cm.cart_cart_id ORDER BY cm.cart_cart_id;";
                $query = mysqli_query($conn, $sql);
                $cart_price = 0;
                while ($row = mysqli_fetch_assoc($query)) {
                    $total_price = 0;
                    $total_option_price = 0;
                    if ($row['selected_option'] !== "") {
                        $merge_option = array_combine(unserialize($row['optional']), unserialize($row['optional_price']));
                        $option = unserialize($row['selected_option']);
                        foreach ($option as $i => $selected_option) {
                            if ($merge_option[$selected_option] != '') {
                                $total_option_price += $merge_option[$selected_option];
                            }
                        }
                    }
                    $total_price += ($row['price'] * $row['amount']) + ($total_option_price * $row['amount']);

                ?>

                    <div class="card pt-3">
                        <div class="row">
                            <div class="col">
                                <p class="card-title"><?php echo $row['username'];?></p>
                            </div>
                            <!-- <div class="col">
                                <p class="card-title"><?php //echo $total_price; ?></p>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#ModalCenter">
                                    แสดงรายละเอียดคำสั่งซื้อ
                                </button>
                            </div>
                        </div>
                    </div>


                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLongTitle">ชื่อผู้สั่งซื้อ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="menu-list border pb-2">
                            <h5 class="card-title">รายการอาหาร</h5>
                            <div class="row">
                                <div class="col">
                                    จำนวน
                                </div>
                                <div class="col">
                                    ชื่อเมนู
                                </div>
                                <div class="col">
                                    ราคา
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    จำนวน
                                </div>
                                <div class="col">
                                    ชื่อเมนู
                                </div>
                                <div class="col">
                                    ราคา
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    จำนวน
                                </div>
                                <div class="col">
                                    ชื่อเมนู
                                </div>
                                <div class="col">
                                    ราคา
                                </div>
                            </div>
                        </div>
                        <div class="payment border pb-2">
                            <h5 class="card-title">วิธีชำระเงิน</h5>
                            เงินสด
                        </div>
                        <div class="total border pb-2">
                            <h5 class="card-title">ยอดรวม</h5>
                            xxx
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-block">ปฏิเสธ</button>
                    <button type="button" class="btn btn-outline-primary btn-block">ยอมรับ</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function ShowMenulist() {
            document.getElementById("menu-list").style = "display: block;";
            document.getElementById("edit-inform").style = "display: none;";
            document.getElementById("order-history").style = "display: none;";
            document.getElementById("order").style = "display: none;";
        }

        function ShowEditInform() {
            document.getElementById("edit-inform").style = "display: block;";
            document.getElementById("menu-list").style = "display: none;";
            document.getElementById("order-history").style = "display: none;";
            document.getElementById("work-box").style = "display: none;";
            document.getElementById("order").style = "display: none;";
        }

        function ShowOrderHistory() {
            document.getElementById("order-history").style = "display: block;";
            document.getElementById("menu-list").style = "display: none;";
            document.getElementById("edit-inform").style = "display: none;";
            document.getElementById("work-box").style = "display: none;"
            document.getElementById("order").style = "display: none;";
        }

        function ShowAddMenu() {
            document.getElementById("add-box").style = "display: block;";
            document.getElementById("work-box").style = "display: none;";
        }

        function ShowEditMenu() {

            document.getElementById("work-box").style = "display: block;";
            document.getElementById("add-box").style = "display: none;";
        }

        function ShowOrder() {
            document.getElementById("order").style = "display: block;";
            document.getElementById("edit-inform").style = "display: none;";
            document.getElementById("menu-list").style = "display: none;";
            document.getElementById("order-history").style = "display: none;";
            document.getElementById("work-box").style = "display: none;";
        }
    </script>
    <?php
    if (isset($_GET['id'])) {
        echo '<script type="text/javascript">window.onload = ShowMenulist();window.onload = ShowEditMenu();</script>';
    }
    ?>
    <?php
    if (isset($_GET["deletedmenu"])) {
        echo '<script type="text/javascript">window.onload = ShowMenulist();</script>';
    }
    if (isset($_GET["updatedmenu"])) {
        echo '<script type="text/javascript">window.onload = ShowMenulist();</script>';
    }
    if (isset($_GET["addedmenu"])) {
        echo '<script type="text/javascript">window.onload = ShowMenulist();</script>';
    }
    if (isset($_GET["error"])) {
        if ($_GET['error'] == 'pricemustbenumber') {
            echo '<script type="text/javascript">window.onload = ShowMenulist();window.onload = ShowAddMenu();</script>';
            echo '<script type="text/javascript">alert("Price must be only number");</script>';
        }
        if ($_GET['error'] == 'negativeprice') {
            echo '<script type="text/javascript">window.onload = ShowMenulist();window.onload = ShowAddMenu();</script>';
            echo '<script type="text/javascript">alert("Price cannot be negative");</script>';
        }

        if ($_GET['error'] == 'forgotoptionprice') {
            echo '<script type="text/javascript">window.onload = ShowMenulist();window.onload = ShowAddMenu();</script>';
            echo '<script type="text/javascript">alert("Insert 0 if there is no price");</script>';
        }
    }
    ?>
    <?php
    include_once '../navbar_footer/footer.php';
    ?>