<?php
include("include/cookie-check.php");
include("include/db_connect.php");
include("include/auth_cookie.php");
$identify=$_GET["id"];
$cart= $uniq_id;
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="rus">  <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Автозапчасти</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<link rel="stylesheet" media="all" href="css/style.css">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>

<?php
	include("include/block-header.php");
	include("include/block-menu.php");
	?>
<?php
$result=mysqli_query($link,"SELECT goods.name,goods.discount,goods.stock,goods.description,goods.price,image.img,goods.quantity FROM goods,image WHERE goods.id=$identify AND image.goods=goods.id");
if(mysqli_num_rows($result)>0)
{
	$row=mysqli_fetch_array($result);
	$price='<h4>'.number_format($row["price"],0,'',' ').' '.'₽</h4>';
    $discount='Данный товар не участвует ни в какой акции';
    if($row["discount"]!=null)
         {
                                        $dis=mysqli_query($link,"SELECT `skidka`,`start`,`end` FROM discount WHERE (CURRENT_DATE BETWEEN start and end) and id=".$row["discount"]."");
                                        if(mysqli_num_rows($dis)>0){
                                            $rowdisk=mysqli_fetch_array($dis);
											$newprice=(int)($row["price"]*(1-$rowdisk["skidka"]/100));
											$price='<h4><s>'.number_format($row["price"],0,'',' ').' '.'₽'.' </s><br>'.number_format($newprice,0,'',' ').' '.'₽'.'</h4>';
    $discount='На данный товар сейчас имеется скидка и она составляет '.$rowdisk["skidka"].'%. Данная скидка действует в промежутке с '.$rowdisk["start"].' по '.$rowdisk["end"].'.';}


        }
				echo "<script>console.log(1)</script>";
        $nal='<a  class="btn-add" tid="'.$identify.'">в корзину</a>';
        $materila=mysqli_query($link,"SELECT materials.name FROM materials,composition WHERE composition.goods=".$identify." AND materials.id=composition.matrials ");
                                    $sostav="Материалы:";
                                    $count=mysqli_num_rows($materila);
                                    for($i=0;$i<$count;$i++){
                                         if($i==0){
                                            $j=mysqli_fetch_array($materila);
                                            $sostav=$sostav." ".$j["name"];
                                        }else{
                                            $j=mysqli_fetch_array($materila);
                                        $sostav=$sostav.",".$j["name"];
                                        }

                                    }
				echo "<script>console.log(2)</script>";
        if($row["quantity"]<=0)
									{
										$nal='<p class="btn-not">нет в наличии</p>';
									}
echo'<div id="body">
<div class="container">
    <div id="content" class="full">
        <div class="product">
            <div class="image">
                <img src="images/'.$row["img"].'" alt="">
            </div>
            <div class="details">
                <h1>'.$row["name"].'</h1>
                '.$price.'
                <div class="entry">
                    <p>'.$discount.'</p>
                    <div class="tabs">
                        <div class="nav">
                            <ul>
                                <li class="active"><a >Описание</a></li>
                            </ul>
                        </div>
                        <div class="tab-content active" id="desc">
                            <p> '.$sostav.'<br>'.$row["description"].'<br><br><br><br><br></p>
                        </div>
                    </div>
                </div>


                    '.$nal.'

            </div>
        </div>
    </div>
    <!-- / content -->
</div>
<!-- / container -->
</div>';
echo "<script>console.log(3)</script>";
}
?>


	<div class="container">
		<div class="last-products">
			<h2>Вам может понравиться</h2>
			<section class="products" id="sale">
			<?php
			$pohoj=mysqli_query($link,"SELECT category,price FROM goods WHERE  id=$identify");
			$pohoje=mysqli_fetch_array($pohoj);

$start=$pohoje["price"]-15000;
$end=$pohoje["price"]+15000;
				  $result=mysqli_query($link,"SELECT id,`name`,discount,price FROM goods where (price BETWEEN $start and $end ) and (quantity>0) and category=".$pohoje["category"]." and id<>$identify");
				  $nul=false;
				  if(mysqli_num_rows($result)>0)
				  $nul=true;
				  { while($row = mysqli_fetch_array($result))
					{
						$query=sprintf("SELECT `start`,`end`,`skidka` FROM discount WHERE (CURRENT_DATE BETWEEN start and end) and id='%s'",mysqli_escape_string($link,$row["discount"]));
						$dis=mysqli_query($link,$query);
						if(mysqli_num_rows($dis)>0){

							$rowdisk=mysqli_fetch_array($dis);
							$newprice=$row["price"]*(1-$rowdisk["skidka"]/100);
							$magquery=sprintf("SELECT * FROM image WHERE goods='%s'",mysqli_escape_string($link,$row["id"]));
							$mag=mysqli_query($link,$magquery);
							$magarray=mysqli_fetch_array($mag);

						echo '
									<article>
										<a  class="imagesck"href="product.php?id='.$row["id"].'"><img src="images/'.$magarray["img"].'" height="198px" alt=""> </a>
										<a href="product.php?id='.$row["id"].'"> <h3>'.$row["name"].'</h3></a>
										<a href="product.php?id='.$row["id"].'">
										<h4><a href="product.php?id='.$row["id"].'"><s>'.number_format($row["price"],0,'',' ').' '.'₽'.'</s><br>'.number_format($newprice,0,'',' ').' '.'₽'.'</a></h4>
										<a  class="btn-add"  tid="'.$row["id"].'">в корзину</a>
									</article>
									';
						}
						else{$magquery=sprintf("SELECT * FROM image WHERE goods='%s'",mysqli_escape_string($link,$row["id"]));
							$mag=mysqli_query($link,$magquery);
							$magarray=mysqli_fetch_array($mag);

						echo '
									<article>
										<a  class="imagesck"href="product.php?id='.$row["id"].'"><img src="images/'.$magarray["img"].'" height="198px" alt=""> </a>
										<a href="product.php?id='.$row["id"].'"> <h3>'.$row["name"].'</h3></a>
										<a href="product.php?id='.$row["id"].'">
										<h4><a href="product.php?id='.$row["id"].'"><br>'.number_format($row["price"],0,'',' ').' '.'₽'.'</a></h4>
										<a  class="btn-add"  tid="'.$row["id"].'">в корзину</a>
									</article>
									';}

								}
						}


					if($nul==false)
					{
                       echo'<h4>Скоро добавим ещё товаров</h4>';
					}



				   ?>

			</section>
		</div>
		</section>
	</div>
	<!-- / container -->
	<!-- / body -->

	<?php
	echo "<script>console.log(4)</script>";
include("include/block-footer.php");
?>


<script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script>window.jQuery || document.write("<script src='js/jquery-3.5.1.min.js'>\x3C/script>")</script>
	<script src="js/plugins.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
