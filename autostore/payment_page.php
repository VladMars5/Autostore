<?php
include("include/auth_cookie.php");
include("include/cookie-check.php");
include("include/db_connect.php");
$cart = $uniq_id;
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

    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>window.jQuery || document.write("<script src='js/jquery-3.5.1.min.js'>\x3C/script>")</script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</html>


<?php
include("include/block-header.php");
include("include/block-menu.php");
?>

<div id="body">
      <div class="container">
          <h3 class="title-h3">Оформление заказа</h3>
          <form method="post">
              <ul id="info-profile">
                  <li>
                      <label for="info_address">Адрес доставки</label><span class="star">*</span>
                      <textarea name="info_address" > <?php if($_POST["save_submit"]){echo $_POST["info_address"];}else{echo $_SESSION['auth_address'];} ?></textarea>
                  </li>
                  <li>
                      <label for="payment_type">Способ оплаты</label><span class="star">*</span>
                      <select id="payment_type" style="margin-left: 200px">
                          <option value="nal">Оплата наличными</option>
                          <option value="beznal">Оплата по карте</option>
                      </select>
                  </li>
              </ul>
              <br>
              <?php
              $total_quantity = 0;
              $query = "SELECT SUM(`count`) AS sum FROM basket_goods WHERE ip = '$cart'";
              $result = mysqli_query($link, $query);
              if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_array($result)) {
                      if ($row["sum"] != null) {
                          $total_quantity = $row["sum"];
                          break;
                      }
                  }
              }
              if ($total_quantity > 0) {
                  echo '<p align="right"><input type="submit" onclick="make_zakaz(\''.$cart.'\')" name="save_submit" id="form_submit" value="Оформить заказ"></p>';
              } else {
                  echo '<a>Корзина пуста!</a>';
              }
              ?>
          </form>
      </div>
</div>

<script type="text/javascript">
    function make_zakaz(cart) {
      var paymentTypeSelect = document.getElementById('payment_type');
      var selectedOption = paymentTypeSelect.value;
      $.ajax({
          type:"POST",
          url:"/include/deletefromcart.php",
          dataType: "html",
          cache:false,
          success:function(data) {
              alert('Заказ успешно оформлен!')
          }
      });
    }
</script>

<?php
include("include/block-footer.php");
?>
