<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
    include("cookie-check.php");
    include("db_connect.php");

    $id=$_POST["id"];
    $cart= $uniq_id;
    $result=mysqli_query($link,"SELECT goods,`count` FROM basket_goods WHERE ip='".$cart."' and goods='$id'");
    if(mysqli_num_rows($result)>0) {
      	$row=mysqli_fetch_array($result);
      	$new_count=$row["count"]+1;
      	$how=mysqli_query($link,"SELECT quantity FROM goods where id='$id'");
      	$mashow=mysqli_fetch_array($how);
      	if($new_count<=$mashow["quantity"]){
            $update=mysqli_query($link,"UPDATE basket_goods SET count='$new_count' WHERE ip='".$cart."' and goods='$id'");
      	}
        else echo 0;
    } else {
		
    		$how=mysqli_query($link,"SELECT quantity FROM goods where id='$id'");
    		$mashow=mysqli_fetch_array($how);

    		mysqli_query($link,"INSERT INTO basket_goods(goods,count,ip) VALUES ('$id','1','".$cart."')");
    }
}
?>