<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
    include("cookie-check.php");
    include("db_connect.php");
  $cart= $uniq_id;
  $count=0;
  $all_price=0;
  echo '<script>console.log(12345)</script>';
  $result=mysqli_query($link,"SELECT basket_goods.goods,basket_goods.count,goods.price,goods.discount FROM basket_goods,goods WHERE basket_goods.ip='".$cart."' and goods.id=basket_goods.goods");
  if(mysqli_num_rows($result)>0){
                  while($row=mysqli_fetch_array($result))
                  {

                        // if($row["discount"]!=null && $_SESSION['auth']=='yes_auth')
                        if($row["discount"]!=null)
                        {  $dis=mysqli_query($link,"SELECT `skidka` FROM discount WHERE (CURRENT_DATE BETWEEN start and end) and id=".$row["discount"]."");
                            if(mysqli_num_rows($dis)>0)
                            {
                                $rowdisk=mysqli_fetch_array($dis);
                            $newprice=(int)($row["price"]*(1-$rowdisk["skidka"]/100));
                            $row["price"]=$newprice;
                            }


                        }
                        $all_price=$all_price+$row["price"]*$row["count"];
                        $count=$count+$row["count"];


                  }
                  if($count==1 || $count==21 || $count==31 || $count==41 || $count==51 || $count==61 || $count==71 || $count==81){$srt=' товар';};
                  if($count==2 || $count==3 || $count==4 || $count==22 || $count==23 || $count==24 || $count==32 || $count==33 || $count==34 || $count==42 || $count==43 || $count==44 || $count==52 || $count==53 || $count==54 || $count==62 || $count==63 || $count==64){$srt=' товара';};
                  if($count==5 || $count==6 || $count==7 || $count==8 || $count==9 || $count==10 || $count==11 || $count==12 || $count==13 || $count==14 || $count==15 || $count==16 || $count==17 || $count==18 || $count==19 || $count==20 || $count==25 || $count==26 || $count==27 || $count==28 || $count==29 || $count==30 || $count==35 || $count==36 || $count==37 || $count==38 || $count==39 || $count==40 || $count==45 || $count==46 || $count==47 || $count==48 || $count==49 || $count==50 || $count==55 || $count==56 || $count==57 || $count==58 || $count==59 || $count==60 || $count==65){$srt=' товаров';};
                  if($count>81){
                      $srt=" тов.";
                }
                echo' <span class="ico-products"></span> '.$count.$srt.' на сумму '.number_format($all_price,0,'',' ').' '.'₽'.'';
                }
                else{

                    echo'0';
                }




  }
