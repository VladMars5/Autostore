<?php
 

if($_SERVER["REQUEST_METHOD"]=="POST"){
    include("cookie-check.php");
    include("db_connect.php");
    $order_fio=$_POST["order_fio"];
    $order_email=$_POST["order_email"];
    $order_phone=$_POST["order_phone"];
    $order_address=$_POST["order_address"];
    $order_note=$_POST["order_note"];
    $cart= $uniq_id;
    $payment=$_POST["payment"];
    $result=mysqli_query($link,"SELECT basket_goods.goods,basket_goods.count,goods.discount,goods.price FROM basket_goods,goods WHERE basket_goods.ip='".$cart."' AND goods.id=basket_goods.goods ");
    if(mysqli_num_rows($result)>0){
        $all_price=0;
        $all_count=0;
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
                                    $all_count= $all_count+$row["count"];
                                    $all_price=$all_price+$row["price"]*$row["count"];}
        
        $insert=mysqli_query($link,"INSERT INTO zakazi(fio,telephone,mail,`count`,price,addres,payment,`date`,state,note) VALUES ('".$order_fio."',$order_phone,'".$order_email."',$all_count,$all_price,'". $order_address."',$payment,CURRENT_DATE,1,".$order_note.")");
        echo $order_fio;
    }
    else echo 0;

   

}