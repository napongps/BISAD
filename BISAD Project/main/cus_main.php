<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <?php
    include_once '../navbar_footer/navbar.php';
    ?>
    <?php
    include("../include/connect.php");

    $sql = 'SELECT * FROM restaurant ORDER BY res_id';
    $query = mysqli_query($conn, $sql);

    ?>
    <div class="container my-5">
        <form>
            <div class="input-group btn-group">
                <div class="form-outline">
                    <input type="text" class="form-control" placeholder="Search" name="search" id='search'>
                </div>
            </div>
        </form>
    </div>
    <div class="container">
        <div class="row">
            <?php
            while ($shops = mysqli_fetch_assoc($query)) {
                echo "<div class='col-3 my-2 pop'>";
                echo "<a href='shop.php?res_id=" . $shops['res_id'] . "'>";
                echo "<div class='card'>";
                echo "<img class='card-img-top' src='data:image/jpeg;base64,". base64_encode($shops['picture']) ."'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $shops['res_name'] . "</h5>";
                echo "<p class='card-text'>" . $shops['description'] . "</p>";
                echo "</div>";
                echo "</div>";
                echo "</a>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <script>
        const search = document.getElementById('search');
        const col = document.getElementsByClassName('col-3');
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

    </script>
    <?php
    if(isset($_GET['error'])){
        if($_GET['error']=='stmtfailed'){
            echo '<script type="text/javascript">alert("Something went wrong, please try again");</script>';
        }
    }
    // if(isset($_GET['cart'])){
    //     echo '<script type="text/javascript">window.onload = cart();</script>';
    // }
    include_once '../navbar_footer/footer.php';
    ?>