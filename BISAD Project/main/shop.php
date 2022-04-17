<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href="../navbar_footer/style.css">
    <script src='script.js'></script>
    <link rel='stylesheet' href="style.css">

    <?php
    include_once '../navbar_footer/navbar.php';
    ?>

    <?php
    include('../include/connect.php');
    $res_id = $_GET['res_id'];
    $sql = "SELECT * FROM restaurant WHERE res_id = '$res_id'; ";
    $query = mysqli_query($conn, $sql);
    $res = mysqli_fetch_array($query);
    ?>
    <div class='container py-5'>
        <h1><?php echo $res['res_name']; ?></h1>
        <h4><?php echo $res['open']; ?></h4>
        <h5><?php echo $res['description']; ?></h5>
    </div>

    <div class="container">
        <hr>
        <form>
            <div class="input-group btn-group">
                <div class="form-outline">
                    <input type="text" class="form-control" placeholder="Search" name="search" id='search'>
                </div>
            </div>
        </form>
        <div class="row" id='box'>
            <?php
            $sql = "SELECT * FROM menu WHERE restaurant_res_id = '$res_id' ORDER BY menu_id;";
            $query = mysqli_query($conn, $sql);

            while ($menu = mysqli_fetch_assoc($query)) {
                if ($menu['optional'] !== NULL) {
                    $option = "href='shop.php?res_id=" . $res_id . "&menu_id=" . $menu['menu_id'] . "&menu_option=yes'";
                } else {
                    $option = "href='../include/cart.php?menu_id=" . $menu['menu_id'] . "&cus_id=" . $cus_id . "&res_id=" . $res_id . "'";
                }
                echo "<div class='col-4 my-3'>";
                echo "<a " . $option . ">";
                echo "<div class='card menu zoom'>";
                echo "<div class='row'>";
                echo "<div class='col'>";
                echo "<img class='card-img-top img-center' src='data:image/jpeg;base64," . base64_encode($menu['picture']) . "' width='200px' height='150px'>";
                echo "</div>";
                echo "<div class='col'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $menu['name'] . "</h5>";
                echo "<p class='card-text'>" . $menu['description'] . "</p>";
                echo "<p class='card-text' style='color:red; '>" . $menu['price'] . " บาท" . "</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</a>";
                echo "</div>";
                echo "<script>console.log('Debug Objects: " . json_encode($menu) . "' );</script>";
            }
            ?>
        </div>
        <?php
        if (isset($_GET['menu_option'])) {
            $menu_id = $_GET['menu_id'];
        ?>

            <div class='option-modal' id='popup'>
                <div class='modal-content'>
                    <span class='close' onclick='closepopup()' align='right'>&times;</span>
                    <div>
                        <h3>ตัวเลือก</h3>
                        <hr>
                        <form action='../include/cart.php' method='post'>
                            <?php

                            $sql = "SELECT * FROM menu WHERE menu_id =$menu_id";
                            $query = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($query);
                            $menu_option = unserialize($row['optional']);
                            $menu_option_price = unserialize($row['optional_price']);
                            $merge_option = array_combine($menu_option, $menu_option_price);
                            if (isset($merge_option)) {
                                foreach ($merge_option as $name => $price) {
                                    if ($price==''){
                                        $price=0;
                                    }
                                    if ($name != '') {
                                        echo "<div class='form-row'>";
                                        echo "<div class='form-group col-8 pl-5'";
                                        echo "<div class='form-check'>";
                                        echo "<input class='form-check-input' type='checkbox' id='selected_option' name='selected_option[]'value='" . $name . "'>";
                                        echo "<label class='form-check-label' for='" . $name . "'>" . $name . "</label>";
                                        echo "</div>";
                                        echo "<div class='form-group col-4'>+" . $price . " บาท</div>";
                                        echo "</div>";
                                    }
                                }
                            }

                            echo "<input type='hidden' name='menu_id' id='menu_id' value='" . $menu_id . "'>";
                            echo "<input type='hidden' name='cus_id' id='cus_id' value='" . $cus_id . "'>";
                            echo "<input type='hidden' name='res_id' id='res_id' value='" . $res_id . "'>";
                            ?><br>
                            <hr>
                            <button type="submit" name='menu_option' id='menu_option' class="btn btn-outline-success">ตกลง</button>
                        </form>
                    </div>
                </div>
            </div>

        <?php
        }
        ?>
    </div>
    <script>
        const search = document.getElementById('search');
        const col = document.getElementsByClassName('col-6');
        const title = document.getElementsByClassName('card-title');
        console.log('title', title[0]);

        search.addEventListener('input', async (e) => {
            console.log(e.target.value.toLowerCase())
            const txt = e.target.value.toLowerCase();
            for (let i = 0; i < title.length; i++) {
                if (title[i].innerText.toLowerCase().includes(txt)) {
                    col[i].style.display = 'block';
                } else {
                    col[i].style.display = "none";
                }
            }
        })
        var popup = document.getElementById('popup');

        function closepopup() {
            popup.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == popup) {
                popup.style.display = "none";
            }
        }
    </script>
    
    <?php

    // if (isset($_GET['cart'])) {
    //     echo '<script type="text/javascript">window.onload = cart();</script>';
    // }

    include_once '../navbar_footer/footer.php';
    ?>