<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<link rel='stylesheet' href="../navbar_footer/style.css">
</head>
<?php
session_start();
?>

<body id='body'>
  <nav class="navbar navbar-expand-lg navbar-light bg-light position-sticky float" style='top:0; z-index:999;'>
    <a class="navbar-brand" href="#">FOOD</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <?php
          if (isset($_SESSION['cus_id'])) {
            $cus_id = $_SESSION['cus_id'];
            $home = '../main/cus_main.php';
          } else if (isset($_SESSION['res_id'])) {
            $res_id = $_SESSION['res_id'];
            $home = '../main/restaurant.php';
          } else {
            $home = '../main/cus_main.php';
          }
          ?>
          <a class="nav-link" href=<?php echo $home; ?>>Home <span class="sr-only">(current)</span></a>
        </li>
      </ul>
    </div>
    <?php

    require_once '../include/connect.php';


    if (isset($_SESSION['cus_id'])) {
      $sql = "SELECT picture FROM customer WHERE cus_id = '" . $_SESSION['cus_id'] . "'";
      $query = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($query);
      echo "<div class='btn-group'>";
      echo "<button type='button' class='btn btn-light'><i class='fa fa-shopping-basket' style='font-size:28px;' onclick='cart()'></i></button>";
      echo "<div class='collapse navbar-collapse  ' id='profile'>";
      echo  "<ul class='navbar-nav'>";
      echo    "<li class='nav-item dropdown'>";
      echo      "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
      echo        "<img src='data:image/jpeg;base64," . base64_encode($row['picture']) . "'' width='40' height='40' class='rounded-circle' />";
      echo "<p class='d-inline mx-2'>" . $_SESSION['username'] . "</p>";
      echo     "</a>";
      echo      "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='navbarDropdownMenuLink'>";
      echo        "<a class='dropdown-item' href='#'>History</a>";
      echo        "<a class='dropdown-item' href='#'>Edit Profile</a>";
      echo        "<a class='dropdown-item' href='../include/inc_logout.php'>Log Out</a>";
      echo      "</div>";
      echo    "</li>";
      echo  "</ul>";
      echo "</div>";
    } else if (isset($_SESSION['res_id'])) {
      $sql = "SELECT picture FROM restaurant WHERE res_id = '" . $_SESSION['res_id'] . "'";
      $query = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($query);
      echo "<div class='btn-group'>";
      echo "<button type='button' class='btn btn-light'><i class='fa fa-shopping-basket' style='font-size:28px' onclick='cart()'></i></button>";
      echo "<div class='collapse navbar-collapse  ' id='profile'>";
      echo  "<ul class='navbar-nav'>";
      echo    "<li class='nav-item dropdown'>";
      echo      "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
      echo        "<img src='data:image/jpeg;base64," . base64_encode($row['picture']) . "'' width='40' height='40' class='rounded-circle' />";
      echo "<p class='d-inline mx-2'>" . $_SESSION['username'] . "</p>";
      echo     "</a>";
      echo      "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='navbarDropdownMenuLink'>";
      echo        "<a class='dropdown-item' href='#'>History</a>";
      echo        "<a class='dropdown-item' href='#'>Edit Profile</a>";
      echo        "<a class='dropdown-item' href='../include/inc_logout.php'>Log Out</a>";
      echo      "</div>";
      echo    "</li>";
      echo  "</ul>";
      echo "</div>";
    } else {
      echo "<a class='nav-link' href='../main/index.php'>Register<span class='sr-only'>(current)</span></a>";
      echo "<a class='nav-link' href='../main/login.php'>Log in<span class='sr-only'>(current)</span></a>";
    }
    ?>
    </div>
  </nav>
  <div class="d-none position-fixed border-left bg-white" id='cart box' style='right:0; z-index: 5; box-shadow: -2px 0px 16px rgba(0, 0, 0, 0.2); height:100%; width:25%; overflow: auto;'>
    <div class="wrapper p-3">

      <?php
      require_once '../include/inc_functions.php';
      $nullcart = true;
      $URI = $_SERVER['REQUEST_URI'];
      $str_query = ' ';
      if (checkNullCart($conn, $cus_id) !== false) {
        $row = checkNullCart($conn, $cus_id);
        $lastcart_id = $row['cart_id'];
        $sql = "SELECT DISTINCT * FROM cart_menu cm INNER JOIN menu m ON m.menu_id=cm.menu_menu_id WHERE cart_cart_id = $lastcart_id;";
        $query = mysqli_query($conn, $sql);
        if (str_contains($_SERVER['REQUEST_URI'], 'res_id')) {
          $str_query = $_SERVER['QUERY_STRING'];
        } 
        $total_price = 0;
        while ($row = mysqli_fetch_assoc($query)) {
          echo "<a href='../include/delete_in_cart.php?menu_id=" . $row['menu_menu_id'] . "&cart_id=" . $row['cart_cart_id'] . "&selected_option=" . $row['selected_option'] . "&" . $str_query . "&URI=" . $URI . "'><span class='close'>&times;</span></a>";
          echo "<div class='row'>";

          echo "<div class='col'>";
          echo  "<img src='data:image/jpeg;base64," . base64_encode($row['picture']) . "' width='150px' height='100px'>";
          echo "</div>";
          echo "<div class='col mr-5'>";
          echo  "<h5>" . $row['name'] . "</h5>";
          $total_option_price = 0;
          if ($row['selected_option'] !== "") {
            $merge_option = array_combine(unserialize($row['optional']), unserialize($row['optional_price']));
            $option = unserialize($row['selected_option']);
            $total_option_price = 0;
            foreach ($option as $i => $selected_option) {
              if ($merge_option[$selected_option] != '') {
                $total_option_price += $merge_option[$selected_option];
              }
              echo  "<small style='color:grey;'>" . $selected_option . "</small><br>";
            }
          }
          echo  "<h6 style='color:red;'>" . ($row['price'] * $row['amount']) + ($total_option_price * $row['amount']) . " บาท</h6>";
          echo "</div>";
          echo "<div class='col-1 mr-5'>";
          echo  "<div class='row d-flex justify-content-center plus'><a href='../include/cart_plus_minus.php?menu_id=" . $row['menu_menu_id'] . "&cart_id=" . $row['cart_cart_id'] . "&selected_option=" . $row['selected_option'] . "&update=plus&URI=" . $URI . "' style='font-size:4px' class='btn btn-secondary text-white'><i class='fa fa-plus' style='font-size:12px;'></i></a></div>";
          echo  "<div class='row d-flex justify-content-center'>";
          echo    "<h class='qnt'>" . $row['amount'] . "</h>";
          echo  "</div>";
          if ($row['amount'] == 0) {
            $minus_goto = "delete_in_cart.php";
          } else {
            $minus_goto = "cart_plus_minus.php";
          }
          echo  "<div class='row d-flex justify-content-center minus'><a href='../include/" . $minus_goto . "?menu_id=" . $row['menu_menu_id'] . "&cart_id=" . $row['cart_cart_id'] . "&selected_option=" . $row['selected_option'] . "&update=minus&URI=" . $URI . "' style='font-size:4px' class='btn btn-secondary text-white'><i class='fa fa-minus' style='font-size:12px;'></i></a></div>";
          echo "</div>";
          echo "</div>";
          echo "<hr>";
          $total_price += ($row['price'] * $row['amount']) + ($total_option_price * $row['amount']);
        }
      } else {
        $nullcart = false;
        echo "<i class='fa fa-shopping-basket cart' style='font-size:102px; color:grey;'></i>";
      }
      ?>

    </div>
    <?php
    if (isset($query)) {
      if (mysqli_num_rows($query) == 0) {
        echo "<i class='fa fa-shopping-basket cart' style='font-size:102px; color:grey;'></i>";
      }
      if (mysqli_num_rows($query) > 0 && $nullcart) {
    ?>
        <div class="position-relative" style='width:100%; height: 20%;'>
          <div class="wrapper position-fixed bg-light p-3" style='bottom:0px; width:25%;'>
            <div class="row">
              <div class="col">
                <h5>รวมทั้งหมด</h5>
              </div>
              <div class="col">
                <h5 align='right'><?php echo $total_price; ?> บาท</h5>
              </div>
            </div>
            <div class="row p-3">
              <form action='../main/order_detail.php' method='post' style='width:100%;'>
                <input type='hidden' name='current_cart' id='current_cart' value='<?php echo $lastcart_id; ?>'>
                <button type="submit" name="order_detail" class="btn btn-success btn-block">ตรวจสอบรายการคำสั่งซื้อ</button>
              </form>
            </div>
          </div>
        </div>
    <?php
      }
    }
    ?>
  </div>
  
  <script>
    document.addEventListener("DOMContentLoaded", function(event) {
      var scrollpos = sessionStorage.getItem('scrollpos');
      if (scrollpos) {
        window.scrollTo(0, scrollpos);
        sessionStorage.removeItem('scrollpos');
      }
    });

    window.addEventListener("beforeunload", function(e) {
      sessionStorage.setItem('scrollpos', window.scrollY);
    });

    function cart() {
      let cart = document.getElementById('cart box');
      cart.classList.toggle('d-none');

    }
  </script>

  <?php
    if(isset($_GET['cart'])){
      echo '<script type="text/javascript">window.onload = cart();</script>';
  }
  ?>
 