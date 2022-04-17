<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .signup-box {
            border-style: groove;
            border-radius: 20px;
            height: 20%;
            width: 20%;
            position: absolute;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            font-size: 56px;
        }

        .fa-check-circle {
            color: rgb(50, 205, 50);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
    <?php
    include_once '../navbar_footer/navbar.php';
    
    ?>
</head>

<body>
    <div class="container p-5" style='margin:auto;' id='container'>
        <h1>เข้าสู่ระบบ</h1>
        <div class="form-check">
            <p style="color: gray;">โปรดเข้าสู่ระบบก่อนเข้าใช้งาน</p>
        </div>
        <br>
        <form action="../include/inc_login.php" method="POST">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for='username'>Username</label>
                <div class="col-sm-9">
                    <input type="text" id="username" name="username" class="form-control" placeholder="ใส่Usernameของคุณ" required />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for='password'>Password</label>
                <div class="col-sm-9">
                    <input type="password" id="password" name="password" class="form-control" placeholder="ใส่Passwordของคุณ" required />
                </div>
            </div>
            <button type="submit" name='submit' id='submit' class="btn btn-primary">เข้าสู่ระบบ</button>
        </form>
    </div>
</body>

</html>
<?php
if (isset($_GET["success"])) {
    echo '<script type="text/javascript">alert("ลงทะเบียนสำเร็จ");</script>';
    // echo "<div class='signup-box' align='center'>";
    // echo "<i class='fa fa-check-circle fa-10x'>";
    // echo "<p style='font-size:22px; color:black; margin-top:12px;'>ลงทะเบียนสำเร็จ</p>";
    // echo "<button type='submit' name='finish' id='finish' class='btn btn-success' onclick='finish()'>ตกลง</button></i></div>";
}
if (isset($_GET["error"])) {
    if ($_GET["error"] == "nousername") {
        echo '<script type="text/javascript">alert("Username doesn\'t exist");</script>';
    } else if ($_GET["error"] == "wrongpassword") {
        echo '<script type="text/javascript">alert("Incorrect password");</script>';
    }
}
?>
<script>
    function finish() {
        window.location = "login.php";
    }
</script>