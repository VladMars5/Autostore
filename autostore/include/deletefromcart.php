<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
    include("cookie-check.php");
    include("db_connect.php");
	

    $id=$_POST["id"];
    $cart= $uniq_id;
	
	//
	 /*$query = "SELECT
                    g.id AS id, g.name AS `name`, g.price AS price, d.skidka AS disc, i.img AS img
                FROM goods g
                INNER JOIN image i ON i.goods = g.id
                INNER JOIN discount d ON d.id = g.discount
                WHERE g.discount != 0 AND g.quantity > 0";*/
			     	   
	/*$query = "SELECT
                    g.id AS id, g.name AS `name`, g.price AS price, d.skidka AS disc, i.img AS img
                FROM goods g
                INNER JOIN image i ON i.goods = g.id
                INNER JOIN discount d ON d.id = g.discount
                WHERE g.discount != 0 AND g.quantity > 0";*/
     
	//$perem1=mysqli_query($link,"SELECT `name` FROM goods WHERE id='$id'");   	   
    //    $row2=mysqli_fetch_array($perem1);
    //  	$new_count4=$row["name"];
	$perem1=mysqli_query($link,"SELECT goods FROM basket_goods WHERE ip='".$cart."'");   	   
        $array=array();
		for ($i = 1; $i <= mysqli_num_rows($perem1); $i++) {				
    echo  	       
	       $row2=mysqli_fetch_array($perem1);
      	   $new_count4=$row2["goods"];
		   $perem5=mysqli_query($link,"SELECT name FROM goods WHERE id='$new_count4'");  
		   $row5=mysqli_fetch_array($perem5);
      	   $new_count6=$row5["name"];
		   array_push($array, $new_count6);         	   
	}	
	$array1 = implode(",", $array);	
	
	
	$perem3=mysqli_query($link,"SELECT count FROM basket_goods WHERE ip='".$cart."'");   	   
        $array2=array();
		for ($i = 1; $i <= mysqli_num_rows($perem3); $i++) {				
    echo  	       
	       $row3=mysqli_fetch_array($perem3);
      	   $new_count5=$row3["count"];
		   array_push($array2, $new_count5);         	   
	}	
	$array3 = implode(",", $array2);	
	    //$row2=mysqli_fetch_array($perem1);
      	//$new_count4=$row2["goods"];
		
	$result=mysqli_query($link,"SELECT `count` FROM basket_goods WHERE ip='".$cart."' and goods='$id'");   
      	
		$row=mysqli_fetch_array($result);
      	$new_count=$row["count"];
		
	// $result1=mysqli_query($link,"SELECT phone FROM reg_user WHERE ip='".$cart."'); 	
      /*	$how=mysqli_query($link,"SELECT quantity FROM goods where id='$id'");
      	$mashow=mysqli_fetch_array($how);
      	if($new_count<=$mashow["quantity"]){
            $update=mysqli_query($link,"UPDATE basket_goods SET count='$new_count' WHERE ip='".$cart."' and goods='$id'");
      	}
        else echo 0;  */
	//mysqli_query($link,"INSERT INTO zakazi(goods,count,phone) VALUES ('$id','1','".$cart."')");*/  
	$perem2=mysqli_query($link,"SELECT phone,email,address FROM reg_user WHERE ip='".$cart."'");  
	   $row1=mysqli_fetch_array($perem2);
	   $new_count1=$row1["phone"];	
	   $new_count2=$row1["email"];
	   $new_count3=$row1["address"];
	   
	$result=mysqli_query($link,"SELECT bg.id AS id, disc.skidka AS discount, g.name AS name, g.price AS price, img.img AS img, g.description AS description, g.quantity AS quantity, bg.count AS count
																				FROM basket_goods bg INNER JOIN goods g ON g.id = bg.goods
																				INNER JOIN image img ON img.goods = g.id
																				LEFT JOIN discount disc ON g.discount = disc.id
																				WHERE bg.ip = '$cart'");
						$total_price = 0;
						if(mysqli_num_rows($result) > 0) {
								while($row = mysqli_fetch_array($result)) {
										$discount = $row["discount"];
										$price = $row["price"];
										if ($discount != null) {
												$price = $price - ($price / 100 * $discount);
										}
										
										
												$selected_count = $row["count"];
												if($_POST["quantity_selector"]){
														$selected_quentity = $_POST["quantity_selector"];
														$id = $_POST["rowId"];
														$update = mysqli_query($link, "UPDATE basket_goods SET count='$selected_quentity' WHERE id = '$id'");
														if ($row["id"] == $id) {
																$selected_count = $selected_quentity;
													  }
												}
												$total_price = $total_price +	$selected_count * $price;
												$counter = 1;
												while($counter <= $row["quantity"]) {
														if ($selected_count == $counter) {
																echo '<option selected value="'.$counter.'">'.$counter.'</option>';
														} else {
																echo '<option value="'.$counter.'">'.$counter.'</option>';
													 }
														$counter++;
												}										
								}
						}
	
	mysqli_query($link,"INSERT INTO zakazi(goods,count,phone,email,address,total_price,date) VALUES ('$array1','$array3','$new_count1','$new_count2','$new_count3','$total_price',NOW())");
	  	
	   
    if ($id == null) {
        mysqli_query($link,"DELETE FROM basket_goods WHERE ip='".$cart."'");
    } else {
        mysqli_query($link,"DELETE FROM basket_goods WHERE ip='".$cart."' AND id='$id'");
    }
}
