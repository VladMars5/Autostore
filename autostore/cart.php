<?php
include("include/db_connect.php");
include("include/cookie-check.php");
$cart=$uniq_id;
$total_quantity = 0;
$query = "SELECT SUM(`count`) AS sum FROM basket_goods WHERE ip = '$cart'";
$result = mysqli_query($link, $query);
echo '<script>console.log("q = '.$query.'")</script>';
if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_array($result)) {
				if ($row["sum"] != null) {
						$total_quantity = $row["sum"];
						break;
				}
		}
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
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
	<header id="header">
		<div class="container" style="display: flex; justify-content: space-between; align-items: center">
			<a href="index.php" id="l1ogo" title="">MotorSide</a>
			<div class="right-links">
				<ul>
					<?php
					echo '<li><a href="cart.php"><span class="ico-products"></span>'.$total_quantity.' товаров</a></li>';
					 ?>
				</ul>
			</div>
		</div>
		<!-- / container -->
	</header>
	<!-- / header -->

	<nav id="menu">
		<div class="container">
			<div class="trigger"></div>
			<ul>
				<li><a href="index.php#sale">Товары по скидке</a></li>
				<li><a href="products.php">Каталог</a></li>
			</ul>
		</div>
		<!-- / container -->
	</nav>
	<!-- / navigation -->

	<!-- / body -->

	<div id="body">
		<div class="container">
			<div id="content" class="full">
				<div class="cart-table">
					<table>
						<tr>
							<th class="items">Товары</th>
							<th class="price">Цена</th>
							<th class="qnt">Количество</th>
							<th class="total">Сумма</th>
							<th class="delete"></th>
						</tr>
						<?php
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
										echo '
										<tr>
										<td class="items">
											<div class="image">
												<img src="images/'.$row["img"].'" alt="">
											</div>
											<h3><a href="#">'.$row["name"].'</a></h3>
											<p>'.$row["description"].'</p>
										</td>
										<td class="price">'.$price.' ₽</td>
										<td class="qnt">
										<form method="POST" action="">
											<input type="hidden" id="rowId" name="rowId" value="'.$row["id"].'" />
											<select name="quantity_selector" onChange="this.form.submit();">';
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
											echo '</select>
										</form>
										</td>
										<td class="total">'.$selected_count * $price.' ₽</td>
										<td class="delete"><a href="#" class="ico-del" tid="'.$row["id"].'"></a></td>
										</tr>
										';
								}
						}
					 	?>
					</table>
				</div>

				<?php
				// $result=mysqli_query($link,"SELECT SUM(g.price * bg.`count`) AS total_price FROM basket_goods bg
				// 														INNER JOIN goods g ON bg.goods = g.id
				// 														WHERE bg.ip = '$cart'");
				// $total_price = 0;
				// if(mysqli_num_rows($result) > 0) {
				// 			while($row = mysqli_fetch_array($result)) {
				// 					$total_price = $row["total_price"];
				// 			}
				// }
				echo '
				<div class="total-count">
					<h3>Итоговая сумма: <strong>'.$total_price.' ₽</strong></h3>
					<form id="payment_form" method="POST" action="payment_page.php">
							<a href="#" class="btn-grey" onClick="document.getElementById(\'payment_form\').submit();">Оплатить</a>
					</form>
				</div>
				';
				 ?>

			</div>
			<!-- / content -->
		</div>
		<!-- / container -->
	</div>
	<!-- / body -->

	<footer id="footer">
		<div class="container">
			<div class="cols">
				<div class="col contact">
					<h3>Свяжитесь с нами</h3>
					<p><span class="ico ico-em"></span><a href="#">почта@mail.ru</a></p>
					<p><span class="ico ico-ph"></span>8-ххх-ххх-хх-хх</p>
				</div>
				<!-- <div class="col newsletter">
					<h3>Подписаться на рассылку о скидках</h3>
					<p>Чтобы получать самые лучшие предложения о товарах.</p>
					<form action="#">
						<input type="text" placeholder="Ваш @mail адрес...">
						<button type="submit"></button>
					</form>
				</div> -->
			</div>
			<p class="copy">МО-415, Марсаков В., Гиззатуллин А., Кистанова Д., Долгушин В., Валиахметова Р.</p>
		</div>
		<!-- / container -->
	</footer>
	<!-- / footer -->


	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script>window.jQuery || document.write("<script src='js/jquery-1.11.1.min.js'>\x3C/script>")</script>
	<script src="js/plugins.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
