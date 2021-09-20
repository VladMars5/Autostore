<?php
include("include/cookie-check.php");
include("include/db_connect.php");
include("include/auth_cookie.php");
$sorting=$_GET["sort"];
switch($sorting){
case 'priceup';
	$sort="price";
	$sorting="priceup";
	$direction="up";
break;
case 'pricedown';
	$sort="price";
	$sorting="pricedown";
	$direction="down";
break;
case 'popularup';
	$sort="popular";
	$direction='sales ASC';
break;
case 'populardown';
	$sort="popular";
	$direction='sales DESC';
break;
case 'dateup';
	$sort="date";
	$direction='date ASC ';
break;
case 'datedown';
	$sort="date";
	$direction='date DESC';
break;
default:
$sort="default";
}
$categ=$_GET["categ"];
if($categ==""|| $categ==0){
	$sortcateg="";
	$categ=0;
}
else{
$result=mysqli_query($link,"SELECT id,`name` FROM category");
							if(mysqli_num_rows($result)>0)
							{
								while($row = mysqli_fetch_array($result))
								{
									if($categ==$row["id"])
									{
										$sortcateg='WHERE category='.$row["id"].'';
									break;

									}
								}
							}
						}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="rus">  <!--<![endif]-->
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
	$_SESSION['auth'];
?>

	<div id="body">
		<div class="container">
			<!--- <div class="pagination">
				<ul>
					<li><a href="#"><span class="ico-prev"></span></a></li>
					<li><a href="#">1</a></li>
					<li class="active"><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					<li><a href="#"><span class="ico-next"></span></a></li>
				</ul>
			</div> --->
			<div class="products-wrap">
				<aside id="sidebar">
					<div class="widget">
						<h3>Сортировать по:</h3>
						<section id="dark">
                        <label id="darklabel" >
					   <input id="dark2" type="radio" name="dark"  onclick="sort_price()">

					   <span class="design"></span>

					   <span class="text">Цене</span>
					</label>
					<label id="darklabel">
					<input id="dark1" type="radio" name="dark" onclick="sort_popular()" >
					<span class="design"></span>
					<span class="text">Популярности</span>
				</label>
				</label>
					<label id="darklabel">
					<input id="dark3" type="radio" name="dark" onclick="sort_date()" >
					<span class="design"></span>
					<span class="text">Дате</span>
				</label>

		</section>
		</div>


		<div class="widget">
						<h3>Вид запчасти:</h3>
						<section id="dark">
						<label id="darklabel" >
									<input id="dark0" type="radio" name="dark1" onclick="categ0()" >

									<span class="design"></span>

									<span class="text">Все</span>
								 </label>
							<?php
							$result=mysqli_query($link,"SELECT id,`name` FROM category");
							if(mysqli_num_rows($result)>0)
							{
								while($row = mysqli_fetch_array($result))
								{
									echo'<label id="darklabel" >
									<input id="dark'.$row["id"].'" type="radio" name="dark1" onclick="categ'.$row["id"].'()" >

									<span class="design"></span>

									<span class="text">'.$row["name"].'</span>
								 </label> ';
								}
							}
							 ?>


		</section>
					</div>






					<!--
					<div class="widget">
						<h3>Диапазон цен:</h3>
						<fieldset>
							<div id="price-range"></div>
						</fieldset>
					</div>
					-->
				</aside>
				<div id="content">
					<section class="products">
						<?php
						$num=8;
						$page=(int)$_GET['page'];
						$count=mysqli_query($link,"SELECT COUNT(*) FROM goods $sortcateg");
						$temp=mysqli_fetch_array($count);
						if($temp[0]>0)
						{
							$tempcount=$temp[0];
							$total=(($tempcount-1)/$num)+1;
							$total=intval($total);
							$page=intval($page);
							if(empty($page) || $page<0)  $page=1;
							if($page>$total) $page=$total;
							$start=$page *$num-$num;
							$qury_start_num=" LIMIT $start,$num";
						}
						if($sort=="price" )
						{
							$result=mysqli_query($link,"SELECT id,`name`,discount,price,quantity FROM goods $sortcateg ");
							$arraymas=[mysqli_num_rows($result)];
							$arraypris=[mysqli_num_rows($result)];
							for($i=0;$i<mysqli_num_rows($result);$i++)
							{
								$arraymas[$i]=mysqli_fetch_array($result);
								$arraypris[$i]=$arraymas[$i]["price"];

								if($arraymas[$i]["discount"]!=null)
								{
									$query=sprintf("SELECT `start`,`end`,`skidka` FROM discount WHERE (CURRENT_DATE BETWEEN start and end) and id='%s'",mysqli_escape_string($link,$arraymas[$i]["discount"]));
									$dis=mysqli_query($link,$query);
									$rowdisk=mysqli_fetch_array($dis);
									$arraymas[$i]["price"]=(int)($arraymas[$i]["price"]*(1-$rowdisk["skidka"]/100));
								}
							}
							if($direction=="up")
							{
								for($i=0;$i<mysqli_num_rows($result);$i++)
								{
									for($j=$i+1;$j<mysqli_num_rows($result);$j++)
									{
										if($arraymas[$i]["price"]>$arraymas[$j]["price"])
										{
											$tmp1=$arraypris[$j];
											$arraypris[$j]=$arraypris[$i];
											$arraypris[$i]=$tmp1;
											$tmp=$arraymas[$j];
											$arraymas[$j]=$arraymas[$i];
											$arraymas[$i]=$tmp;
										}
									}
								}
							}
							else
							{
								for($i=0;$i<mysqli_num_rows($result);$i++)
								{
									for($j=$i+1;$j<mysqli_num_rows($result);$j++)
									{
										if($arraymas[$i]["price"]<$arraymas[$j]["price"])
										{
											$tmp1=$arraypris[$j];
											$arraypris[$j]=$arraypris[$i];
											$arraypris[$i]=$tmp1;
											$tmp=$arraymas[$j];
											$arraymas[$j]=$arraymas[$i];
											$arraymas[$i]=$tmp;
										}
									}
								}
							}

for($i=$start;($i<($start+$num)) && ($i<mysqli_num_rows($result));$i++){
	$magquery=sprintf("SELECT * FROM image WHERE goods='%s'",mysqli_escape_string($link,$arraymas[$i]["id"]));
	$nal='<a  class="btn-add" tid="'.$arraymas[$i]["id"].'">в корзину</a>';
	if($arraymas[$i]["quantity"]<=0)
									{
										$nal='<p class="btn-not">нет в наличии</p>';
									}
										$mag=mysqli_query($link,$magquery);
										$magarray=mysqli_fetch_array($mag);
										if($arraymas[$i]["discount"]!=null && $arraypris[$i]!=$arraymas[$i]["price"]){

										echo '
										<article>
										   <a href="product.php?id='.$arraymas[$i]["id"].'"><img src="images/'.$magarray["img"].'" alt=""></a>
										   <h3><a href="product.php?id='.$arraymas[$i]["id"].'">'.$arraymas[$i]["name"].'</a></h3>
										   <h4><a href="product.php?id='.$arraymas[$i]["id"].'"><s>'.number_format($arraypris[$i],0,'',' ').' '.'₽'.'</s><br>'.number_format($arraymas[$i]["price"],0,'',' ').' '.'₽'.'</a></h4>
										   '.$nal.'
										</article>
										';}
										else{echo '
											<article>
											   <a href="product.php?id='.$arraymas[$i]["id"].'"><img src="images/'.$magarray["img"].'" alt=""></a>
											   <h3><a href="product.php?id='.$arraymas[$i]["id"].'">'.$arraymas[$i]["name"].'</a></h3>
											   <h4><a href="product.php?id='.$arraymas[$i]["id"].'"><br>'.number_format($arraymas[$i]["price"],0,'',' ').' '.'₽'.'</a></h4>
											   '.$nal.'

											</article>
											';}
}
						}
						else
						{
							if($sort=="popular" ||$sort=="date")
							{
								$query="SELECT id,`name`,discount,price,quantity FROM goods $sortcateg ORDER BY $direction $qury_start_num";
								$result=mysqli_query($link,$query);

							if(mysqli_num_rows($result)>0)
							{
								while($row = mysqli_fetch_array($result))

								{
									$nal='<a  class="btn-add" tid="'.$row["id"].'">в корзину</a>';

									if($row["quantity"]<=0)
									{
										$nal='<p class="btn-not">нет в наличии</p>';
									}
									if($row["discount"]!=null)
									{
									$query=sprintf("SELECT `start`,`end`,`skidka` FROM discount WHERE (CURRENT_DATE BETWEEN start and end) and id='%s'",mysqli_escape_string($link,$row["discount"]));
									$dis=mysqli_query($link,$query);
									if(mysqli_num_rows($dis)>0)
									{

										$rowdisk=mysqli_fetch_array($dis);
										$newprice=$row["price"]*(1-$rowdisk["skidka"]/100);
										$magquery=sprintf("SELECT * FROM image WHERE goods='%s'",mysqli_escape_string($link,$row["id"]));
										$mag=mysqli_query($link,$magquery);
										$magarray=mysqli_fetch_array($mag);
										echo '
										<article>
										   <a href="product.php?id='.$row["id"].'"><img src="images/'.$magarray["img"].'" alt=""></a>
										   <h3><a href="product.php?id='.$row["id"].'">'.$row["name"].'</a></h3>
										   <h4><a href="product.php?id='.$row["id"].'"><s>'.number_format($row["price"],0,'',' ').' '.'₽'.'</s><br>'.number_format($newprice,0,'',' ').' '.'₽'.'</a></h4>
										   '.$nal.'
										</article>
										';
									}
									else{
										$magquery=sprintf("SELECT * FROM image WHERE goods='%s'",mysqli_escape_string($link,$row["id"]));
									$mag=mysqli_query($link,$magquery);
									$magarray=mysqli_fetch_array($mag);
									echo '
										<article>
										   <a href="product.php?id='.$row["id"].'"><img src="images/'.$magarray["img"].'" alt=""></a>
										   <h3><a href="product.php?id='.$row["id"].'">'.$row["name"].'</a></h3>
										   <h4><a href="product.php?id='.$row["id"].'"><br>'.number_format($row["price"],0,'',' ').' '.'₽'.'</a></h4>
										   '.$nal.'

										</article>
										';
									}
								 }
								 else
								 {

									$magquery=sprintf("SELECT * FROM image WHERE goods='%s'",mysqli_escape_string($link,$row["id"]));
									$mag=mysqli_query($link,$magquery);
									$magarray=mysqli_fetch_array($mag);
									echo '
										<article>
										   <a href="product.php?id='.$row["id"].'"><img src="images/'.$magarray["img"].'" alt=""></a>
										   <h3><a href="product.php?id='.$row["id"].'">'.$row["name"].'</a></h3>
										   <h4><a href="product.php?id='.$row["id"].'"><br>'.number_format($row["price"],0,'',' ').' '.'₽'.'</a></h4>
										   '.$nal.'
										</article>
										';
								 }
								}
							}


						}
							else
							{
								$result=mysqli_query($link,"SELECT id,`name`,discount,price,quantity FROM goods $sortcateg $qury_start_num");
							if(mysqli_num_rows($result)>0)
							{
								while($row = mysqli_fetch_array($result))
								{
									$nal='<a  class="btn-add" tid="'.$row["id"].'">в корзину</a>';
									if($row["quantity"]<=0)
									{
										$nal='<p class="btn-not">нет в наличии</p>';
									}
									if($row["discount"]!=null)
									{
									$query=sprintf("SELECT `start`,`end`,`skidka` FROM discount WHERE (CURRENT_DATE BETWEEN start and end) and id='%s'",mysqli_escape_string($link,$row["discount"]));
									$dis=mysqli_query($link,$query);
									if(mysqli_num_rows($dis)>0)
									{

										$rowdisk=mysqli_fetch_array($dis);
										$newprice=$row["price"]*(1-$rowdisk["skidka"]/100);
										$magquery=sprintf("SELECT * FROM image WHERE goods='%s'",mysqli_escape_string($link,$row["id"]));
										$mag=mysqli_query($link,$magquery);
										$magarray=mysqli_fetch_array($mag);
										echo '
										<article>
										   <a href="product.php?id='.$row["id"].'"><img src="images/'.$magarray["img"].'" alt=""></a>
										   <h3><a href="product.php?id='.$row["id"].'">'.$row["name"].'</a></h3>
										   <h4><a href="product.php?id='.$row["id"].'"><s>'.number_format($row["price"],0,'',' ').' '.'₽'.'</s><br>'.number_format($newprice,0,'',' ').' '.'₽'.'</a></h4>
										   '.$nal.'
										</article>
										';
									}
									else{
										$magquery=sprintf("SELECT * FROM image WHERE goods='%s'",mysqli_escape_string($link,$row["id"]));
									$mag=mysqli_query($link,$magquery);
									$magarray=mysqli_fetch_array($mag);
									echo '
										<article>
										   <a href="product.php?id='.$row["id"].'"><img src="images/'.$magarray["img"].'" alt=""></a>
										   <h3><a href="product.php?id='.$row["id"].'">'.$row["name"].'</a></h3>
										   <h4><a href="product.php?id='.$row["id"].'"><br>'.number_format($row["price"],0,'',' ').' '.'₽'.'</a></h4>
										   '.$nal.'

										</article>
										';
									}
								 }
								 else
								 {
									$magquery=sprintf("SELECT * FROM image WHERE goods='%s'",mysqli_escape_string($link,$row["id"]));
									$mag=mysqli_query($link,$magquery);
									$magarray=mysqli_fetch_array($mag);
									echo '
										<article>
										   <a href="product.php?id='.$row["id"].'"><img src="images/'.$magarray["img"].'" alt=""></a>
										   <h3><a href="product.php?id='.$row["id"].'">'.$row["name"].'</a></h3>
										   <h4><a href="product.php?id='.$row["id"].'"><br>'.number_format($row["price"],0,'',' ').' '.'₽'.'</a></h4>
										   '.$nal.'

										</article>
										';
								 }
								}
							}

							}

						}

						?>


					</section>
				</div>
				<!-- / content -->
				<?php

		 if($page!=1){$pstr_prev='<li><a class="pstr-prev" href="products.php?sort='.$sorting.'&page='.($page-1).'&categ='.$categ.'">&lt;</a></li>'; }
		 if($page!=$total){$pstr_next='<li><a class="pstr-next"href="products.php?sort='.$sorting.'&page='.($page+1).'&categ='.$categ.'">&gt;</a></li>'; }
		 if($page-5>0)$page5left='<li><a href="products.php?sort='.$sorting.'&page='.($page-5).'&categ='.$categ.'">'.($page-5).'</a></li>';
		 if($page-4>0)$page4left='<li><a href="products.php?sort='.$sorting.'&page='.($page-4).'&categ='.$categ.'">'.($page-4).'</a></li>';
		 if($page-3>0)$page3left='<li><a href="products.php?sort='.$sorting.'&page='.($page-3).'&categ='.$categ.'">'.($page-3).'</a></li>';
		 if($page-2>0)$page2left='<li><a href="products.php?sort='.$sorting.'&page='.($page-2).'&categ='.$categ.'">'.($page-2).'</a></li>';
		 if($page-1>0)$page1left='<li><a href="products.php?sort='.$sorting.'&page='.($page-1).'&categ='.$categ.'">'.($page-1).'</a></li>';

		 if($page + 5 <= $total)$page5right='<li><a href="products.php?sort='.$sorting.'&page='.($page+5).'&categ='.$categ.'">'.($page+5).'</a></li>';
		 if($page + 4 <= $total)$page4right='<li><a href="products.php?sort='.$sorting.'&page='.($page+4).'&categ='.$categ.'">'.($page+4).'</a></li>';
		 if($page + 3 <= $total)$page3right='<li><a href="products.php?sort='.$sorting.'&page='.($page+3).'&categ='.$categ.'">'.($page+3).'</a></li>';
		 if($page + 2 <= $total)$page2right='<li><a href="products.php?sort='.$sorting.'&page='.($page+2).'&categ='.$categ.'">'.($page+2).'</a></li>';
		 if($page + 1 <= $total)$page1right='<li><a href="products.php?sort='.$sorting.'&page='.($page+1).'&categ='.$categ.'">'.($page+1).'</a></li>';
		 if ($page+5 < $total)
		 {
		    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="products.php?sort='.$sorting.'&page='.$total.'&categ='.$categ.'">'.$total.'</a></li>';
}else
{
    $strtotal = "";
}

if ($total > 1)
{$active='<li><a class="pstr-active" href="products.php?sort='.$sorting.'&page='.$page.'&categ='.$categ.'">'.$page.'</a></li>';
    echo '
    <div class="pstrnav">
    <ul>
    ';
    echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left.$active.$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
    echo '
    </ul>
    </div>
	';
}

		 ?>

			<!--- <div class="pagination">
				<ul>
					<li><a href="#"><span class="ico-prev"></span></a></li>
					<li><a href="#">1</a></li>
					<li class="active"><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					<li><a href="#"><span class="ico-next"></span></a></li>
				</ul>
			</div> --->

		</div>
		<!-- / container -->


	</div>
	<!-- / body -->

	<?php
include("include/block-footer.php");
?>
	<script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script>window.jQuery || document.write("<script src='js/jquery-3.5.1.min.js'>\x3C/script>")</script>
	<script src="js/plugins.js"></script>
	<script src="js/main.js"></script>
	<script>function sort_price(){

		if(~location.href.indexOf("products.php?sort=priceup")){
			<?php
		echo'location.href="http://autostore/products.php?sort=pricedown&page='.$page.'&categ='.$categ.'"'; ?>}
		else{if(~location.href.indexOf("products.php?sort=pricidown")){
			<?php
		echo'location.href="http://autostore/products.php?sort=priceup&page='.$page.'&categ='.$categ.'"'; ?>

		}
	else {
		<?php
		echo'location.href="http://autostore/products.php?sort=priceup&page='.$page.'&categ='.$categ.'"'; ?>}	}

	}
	function sort_popular(){

		if(~location.href.indexOf("products.php?sort=popularup")){
			<?php
		echo'location.href="http://autostore/products.php?sort=populardown&page='.$page.'&categ='.$categ.'"'; ?>}
		else{if(~location.href.indexOf("products.php?sort=populardown")){
			<?php
		echo'location.href="http://autostore/products.php?sort=popularup&page='.$page.'&categ='.$categ.'"'; ?>

		}
	else {
		<?php
		echo'location.href="http://autostore/products.php?sort=popularup&page='.$page.'&categ='.$categ.'"'; ?>}	}

	}
	function sort_date(){

		if(~location.href.indexOf("products.php?sort=dateup")){
			<?php
		echo'location.href="http://autostore/products.php?sort=datedown&page='.$page.'&categ='.$categ.'"'; ?>}
		else{if(~location.href.indexOf("products.php?sort=datedown")){
			<?php
		echo'location.href="http://autostore/products.php?sort=dateup&page='.$page.'&categ='.$categ.'"'; ?>

		}
	else {
		<?php
		echo'location.href="http://autostore/products.php?sort=dateup&page='.$page.'&categ='.$categ.'"'; ?>}	}

	}
	<?php
	$result=mysqli_query($link,"SELECT id,`name` FROM category");
	if(mysqli_num_rows($result)>0)
	{
		while($row = mysqli_fetch_array($result))
		{
			$view='location.href="http://autostore/products.php?sort='.$sorting.'&page='.$page.'&categ='.$row["id"].'"';
          echo'function categ'.$row["id"].'(){'.$view.'


		  }';
		}
	}
	 ?>
	 function categ0(){
		<?php
		echo'location.href="http://autostore/products.php?sort='.$sorting.'&page='.$page.'&categ=0"'; ?>
	 }
	</script>
</body>
</html>
