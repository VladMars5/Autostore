<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    include("cookie-check.php");
    include("db_connect.php");
$cart= $uniq_id;
$result=mysqli_query($link,"SELECT basket_goods.count,goods.discount,goods.price FROM basket_goods,goods WHERE basket_goods.ip='".$cart."' AND goods.id=basket_goods.goods ");
$all_price=0;
								while($row = mysqli_fetch_array($result))
                                {
                                    if($row["discount"]!=null && $_SESSION['auth']=='yes_auth')
                                    {                                       
                                        $dis=mysqli_query($link,"SELECT `skidka` FROM discount WHERE (CURRENT_DATE BETWEEN start and end) and id=".$row["discount"]."");
                                        if(mysqli_num_rows($dis)>0){
                                        $rowdisk=mysqli_fetch_array($dis);
                                        $newprice=(int)($row["price"]*(1-$rowdisk["skidka"]/100));
                                        $row["price"]=$newprice;}
                                    }
                                    $all_price=$all_price+$row["price"]*$row["count"];}
                                    echo number_format($all_price,0,'',' ').' '.'₽';
} 
    ?>