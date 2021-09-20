<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    include("cookie-check.php");
    include("db_connect.php");
$id=($_POST["id"]);
$cart= $uniq_id;
$result=mysqli_query($link,"SELECT `count` FROM basket_goods WHERE ip='".$cart."' and goods='$id'");
if(mysqli_num_rows($result)>0){
    $row=mysqli_fetch_array($result);
    $new_count=$row["count"]-1;
    if($new_count>0){
        $update=mysqli_query($link,"UPDATE basket_goods SET count='$new_count' WHERE ip='".$cart."' and goods='$id'");
        echo $new_count;
    }
    else{
        echo $row["count"];
    }
}
} 
    ?>