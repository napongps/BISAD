<?php   
    $dbservername = "localhost"; 
    $dbusername = "root"; 
    $dbpassword = "";   
    $dbdatabase = "food_delivery";
   
     // Create a connection 
     $conn = mysqli_connect($dbservername, 
        $dbusername, $dbpassword, $dbdatabase);   
    if($conn) {
        //echo "success"; 
    } 
    else {
        die("Error". mysqli_connect_error()); 
    } 
?>