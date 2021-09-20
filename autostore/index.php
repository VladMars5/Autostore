<?php
include("include/auth_cookie.php");
include("include/cookie-check.php");
include("include/db_connect.php");
 ?>
<!DOCTYPE html>

 <html lang="rus">
 <head>
	<meta charset="utf-8">
	<title>Автозапчасти</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<link rel="stylesheet" media="all" href="css/style.css">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>


</head>


	<?php
	include("include/block-header.php");
	include("include/block-menu.php");
	?>


<body>
  <div id="slider">
    <ul>
      <li style="background-image: url(images/20.jpg)">
        <h3 style=" color: white;">Автозапчасти на иномарки</h3>
        <h2>Управляй мечтой</h2>
      </li>
    </ul>
  </div>

  <?php
      $query = "SELECT
                    g.id AS id, g.name AS `name`, g.price AS price, d.skidka AS disc, i.img AS img
                FROM goods g
                INNER JOIN image i ON i.goods = g.id
                INNER JOIN discount d ON d.id = g.discount
                WHERE g.discount != 0 AND g.quantity > 0";
      $result = mysqli_query($link, $query);
      if (mysqli_num_rows($result) > 0) {
          echo '
          <div id="body">
          		<div class="container">
          			   <div class="last-products" style="border: 0; outline: 1px solid #d3d3d3">
        				       <h2>Товары по скидке</h2>
      				         <section class="products" id="sale">';
          $counter = 0;
          while($row = mysqli_fetch_array($result)) {
              $counter++;
              $original_price = $row["price"];
              $discount = $row["disc"];
              $new_price = $original_price - $original_price / 100 * $discount;
              echo '
              <article>
      						<a href="product.php?id='.$row["id"].'"><img src="images/'.$row["img"].'" alt=""></a>
      						<h3>'.$row["name"].'</h3>
      						<h4><s>'.$original_price.' ₽</s><br>'.$new_price.' ₽</h4>
      						<a class="btn-add" tid="'.$row["id"].'">в корзину</a>
    					</article>
              ';
              if ($counter == 5) {
                  break;
              }
          }
          echo '
                </section>
        			</div>
        			</section>
        		</div>
        	</div>
          ';
      }
   ?>


	<!-- / body -->
</body>
	<?php
include("include/block-footer.php");
?>


<script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script>window.jQuery || document.write("<script src='js/jquery-3.5.1.min.js'>\x3C/script>")</script>
	<script src="js/plugins.js"></script>
	<script src="js/main.js"></script>




</html>
