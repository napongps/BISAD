<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .center {
            margin: auto;
            width: 50%;
            padding: 10px;
        }

        .centerform {
            margin: auto;
            width: 100%;
            padding: 10px;
        }

        .hidden {
            display: none;
        }

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
    <br>
    <div class="container center">
        <h1>ลงทะเบียน</h1>
        <div class="form-check">
            <p style="color: gray;">กรุณาเลือกประเภทบัญชี</p>
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" onclick="create(0)" checked>
            <label class="form-check-label" for="flexRadioDefault1">
                ผู้สั่งซื้อ
            </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" onclick="create(1)">
            <label class="form-check-label" for="flexRadioDefault2">
                ร้านค้า
            </label>
        </div>
        <br>
        <script>
            function create(pt) {
                if (pt == 0) {
                    document.getElementById("cus").className = "centerform";
                    document.getElementById("res").className = "hidden";
                } else {
                    document.getElementById("cus").className = "hidden";
                    document.getElementById("res").className = "centerform";
                }
            }
        </script>
        <div class="container">
            <form id="res" class="hidden" action="../include/inc_regist_res.php" method="POST" enctype='multipart/form-data'>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">ชื่อร้านค้า</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="res_name" name='res_name' placeholder="ใส่ชื่อร้านค้าของคุณ" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for='picture'>รูปภาพ</label>
                    <div class="col-sm-9">
                        <input type="file" id='picture' name='picture' value='upload' class="form-control" required />
                        <small class="form-text text-muted">ขนาดไม่เกิน 2 MB</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">คำอธิบายร้าน</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="description" name='description' placeholder="ใส่คำอธิบายร้านค้าของคุณ" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">เวลาเปิด-ปิดร้าน</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="close_open" name='close_open' placeholder="ใส่ช่วงเวลาเปิด-ปิดร้านของคุณ" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">ชื่อ</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="fname" name='fname' placeholder="ชื่อของคุณ" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">นามสกุล</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="lname" name='lname' placeholder="นามสกุลของคุณ" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">เบอร์โทรศัพท์</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="tel" name='tel' placeholder="เบอร์โทรศัพท์ของคุณ" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="username" name='username' placeholder="ชื่อUsernameของคุณ" required />
                        <small class="form-text text-muted">ตัวอักษร A-Z ก-ฮ 1-9</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password" name='password' placeholder="ใส่Passwordของคุณ" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Comfirm Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="passwordcheck" name='passwordcheck' placeholder="ตรวจสอบPasswordของคุณ" required />
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-outline-secondary">ลงทะเบียน</button>
            </form>
            <form id="cus" class="centerform" action="../include/inc_regist_cus.php" method="POST" enctype='multipart/form-data'>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for='fname'>ชื่อ</label>
                    <div class="col-sm-9">
                        <input type="text" id="fname" name="fname" class="form-control" placeholder="ใส่ชื่อของคุณ" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for='lname'>นามสกุล</label>
                    <div class="col-sm-9">
                        <input type="text" id='lname' name='lname' class="form-control" placeholder="ใส่นามสกุลของคุณ" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for='picture'>รูปภาพ</label>
                    <div class="col-sm-9">
                        <input type="file" id='picture' name='picture' value='upload' class="form-control" />
                        <small class="form-text text-muted">ขนาดไม่เกิน 2 MB</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for='tel'>เบอร์โทรศัพท์</label>
                    <div class="col-sm-9">
                        <input type="text" id='tel' name='tel' class="form-control" placeholder="ใส่เบอร์โทรศัพท์ของคุณ" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for='address'>ที่อยู่</label>
                    <div class="col-sm-9">
                        <textarea type="text" id='address' name='address' class="form-control" placeholder="โปรดกรอกที่อยู่ของคุณ" required></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for='username'>Username</label>
                    <div class="col-sm-9">
                        <input type="text" id='username' name='username' class="form-control" placeholder="ใส่ชื่อUsernameของคุณ" required />
                        <small class="form-text text-muted">ตัวอักษร A-Z ก-ฮ 1-9</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for='password'>Password</label>
                    <div class="col-sm-9">
                        <input type="password" id='password' name='password' class="form-control" placeholder="ใส่Passwordของคุณ" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for='passwordcheck'>Comfirm Password</label>
                    <div class="col-sm-9">
                        <input type="password" id='passwordcheck' name='passwordcheck' class="form-control" placeholder="กรุณาตรวจสอบPasswordของคุณ" required />
                    </div>
                </div>
                <button type="submit" name='submit' class="btn btn-outline-secondary">ลงทะเบียน</button>
            </form>
        </div>

    </div>
    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo '<script type="text/javascript">alert("Please fill in all fields");</script>';
        } else if ($_GET["error"] == "passworddontmatch") {
            echo '<script type="text/javascript">alert("Your password doesn\'t match");</script>';
        } else if ($_GET["error"] == "stmtfailed") {
            echo '<script type="text/javascript">alert("Something went wrong, please try again");</script>';
        } else if ($_GET["error"] == "invaliduid") {
            echo '<script type="text/javascript">alert("Invalid username");</script>';
        } else if ($_GET["error"] == "usernametaken") {
            echo '<script type="text/javascript">alert("Your username has been already taken");</script>';
        } else if ($_GET["error"] == "nopicture") {
            echo '<script type="text/javascript">alert("Please upload picture");</script>';
        }else if ($_GET["error"] == "picturetoobig") {
            echo '<script type="text/javascript">alert("Your picture is larger than 2MB");</script>';
        } else if ($_GET["error"] == "none") {
            echo "<div class='signup-box' align='center'>";
            echo "<i class='fa fa-check-circle fa-10x'>";
            echo "<p style='font-size:22px; color:black; margin-top:12px;'>You're signed up</p>";
            echo "<button type='submit' name='finish' id='finish' class='btn btn-success' onclick='finish()'>ตกลง</button></i></div>";
        }
    }
    ?>

    <script>
        function finish() {
            window.location = "cus_main.php";
        }
    </script>

</body>

</html>