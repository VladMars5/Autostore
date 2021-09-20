<?php
include("include/cookie-check.php");

if($_SESSION['auth']=='yes_auth'){

    include("include/db_connect.php");
if($_POST["save_submit"]){
    $error=array();
    $pass=md5($_POST["info_pass"]);
    $pass=strrev($pass);
    $pass="9nm2rv8q".$pass."2yo6z";
    $_POST["info_surname"]=trim($_POST["info_surname"]);
    $_POST["info_name"]=trim($_POST["info_name"]);
    $_POST["info_patronymic"]=trim($_POST["info_patronymic"]);
    $_POST["info_address"]=trim($_POST["info_address"]);
    $_POST["info_phone"]=trim($_POST["info_phone"]);
    $_POST["info_email"]=trim($_POST["info_email"]);

    if($_SESSION['auth_pass']!=$pass){
        $error[]='Неверный текущий пароль';
    }
    else{
        if($_POST["info_new_pass"]!=""){
            if(mb_strlen($_POST["info_new_pass"])<7 or mb_strlen($_POST["info_new_pass"])>15) {$error[]="Укажите пароль от 7 до 15 символов!";}
            else{
                $newpass=md5($_POST["info_new_pass"]);
                $newpass=strrev($newpass);
                $newpass="9nm2rv8q".$newpass."2yo6z";
                $newpassquery="pass='".$newpass."',";
            }
        }
        if(mb_strlen($_POST["info_surname"])<3 or mb_strlen($_POST["info_surname"]>15)) $error[]="Укажите фамилию от 3 до 15 символов!";
        if(mb_strlen($_POST["info_name"])<2 or mb_strlen($_POST["info_name"])>15) $error[]="Укажите имя от 2 до 15 символов!";
        if(mb_strlen($_POST["info_patronymic"])<3 or mb_strlen($_POST["info_patronymic"])>25) $error[]="Укажите отчество от 3 до 15 символов!";
        if(!preg_match("/[А-Яа-я]$/u",trim($_POST["info_patronymic"])))$error[]="Для отчества используйте пожалуйста буквы русского алфавита";
        if(!preg_match("/[А-Яа-я]$/u",trim($_POST["info_surname"])))$error[]="Для фамилии используйте пожалуйста буквы русского алфавита";
        if(!preg_match("/[А-Яа-я]$/u",trim($_POST["info_name"])))$error[]="Для имени используйте пожалуйста буквы русского алфавита";
        if(!preg_match("/^[\w]{1}[\w-\.]*@[\w-]+\.[a-z]{2,4}$/i",trim($_POST["info_email"]))) $error[]="Укажите корректный email!";
        if(!preg_match("/^(\+7|8)(\(\d{3}\)|\d{3})\d{7}$/",trim($_POST["info_phone"]))) $error[]="Укажите корректный номер телефона!";
        if(!preg_match("/г+\.[А-Яа-я\s-]+[\s,]+[ул|пер|пр|б-р]+\.[А-Яа-я\s-]+[\s,]+[дом|д]+\.[0-9\/]+[\s,]+кв+\.[0-9]/u",trim($_POST["info_address"]))) $error[]="Введите адрес по форме(г.город,ул(пер или пр или б-р).улица, дом(д).цифры(/корпус если имеется),кв.цифры)!";
    }
        if(count($error)){
            $_SESSION['msg']="<p align='left' id='form-error'>".implode('<br>',$error)."</p>";
        }
        else{
            $_SESSION['msg']="<p align='left' id='form-success'>Данные успешно сохранены!</p>";
            $dataquery=$newpassquery."surname='".$_POST["info_surname"]."',name='".$_POST["info_name"]."',patronymic='".$_POST["info_patronymic"]."',email='".$_POST["info_email"]."',phone='".$_POST["info_phone"]."',address='".$_POST["info_address"]."'";
            $login=$_SESSION['auth_login'];
            $update=mysqli_query($link,"UPDATE reg_user SET $dataquery WHERE login='$login'");
            if($newpass){
                $_SESSION['auth_pass']=$newpass;
            }

        $_SESSION['auth_surname']=$_POST["info_surname"];
        $_SESSION['auth_name']=$_POST["info_name"];
        $_SESSION['auth_patronymic']=$_POST["info_patronymic"];
        $_SESSION['auth_address']=$_POST["info_address"];
        $_SESSION['auth_phone']=$_POST["info_phone"];
        $_SESSION['auth_email']=$_POST["info_email"];
        $_SESSION["order_fio"]=$_SESSION['auth_surname'].' '. $_SESSION['auth_name'].' '.$_SESSION['auth_patronymic'];
        $_SESSION["order_email"]= $_SESSION['auth_email'];
        $_SESSION["order_phone"]=$_SESSION['auth_phone'];
        $_SESSION["order_address"]=$_SESSION['auth_address'];
        }
    }


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
    <?php 
	   $id=$_POST["id"];
       $cart= $uniq_id;
	   
	  $perem2=mysqli_query($link,"SELECT phone FROM reg_user WHERE ip='".$cart."'");  
	   $row1=mysqli_fetch_array($perem2);
	   $new_count1=$row1["phone"];		   
	  
	  $perem3=mysqli_query($link,"SELECT id,goods,count,total_price,date,status FROM zakazi WHERE phone='$new_count1'");  
	    	      
      if (mysqli_num_rows($perem3) > 0) {
          echo '<table >';
		    echo '
			  <h3 class="title-h3 container">История заказов</h3>
			<tr>
                            <th>№ заказа</th>
                            <th>Товары</th>
							<th>Кол-во штук</th>
                            <th>Цена</th>
                            <th>Дата</th>
							<th>Статус</th>
                        
				</tr>	
        			
         ';
         
          while($row = mysqli_fetch_array($perem3)) {
              $stat12  ;
			  if ($row["status"] == 1){$stat12 = 'Обработывается'; }
			  if ($row["status"] == 2){$stat12 = 'Принят(Ожидается отправка)'; }			  
			  if ($row["status"] == 3){$stat12 = 'В пути'; }
			  if ($row["status"] == 4){$stat12 = 'Получен '; }
			  if ($row["status"] == 4){$stat12 = 'Отменен'; }
              $goods = $row["goods"];
              $count = $row["count"];
              $price = $row["total_price"];
              echo '	
	                   <tr>
                            <td>'.$row["id"].'</td>
                            <td>'.$goods.'</td>
                            <td>'.$count.' </td>
                            <td>'.$price.'₽</td>
							<td>'.$row["date"].'</td>
							<td>'.$stat12.'</td>
                        </tr>
			  ';			             
          }
		  echo '</table>';        
      } 
	?>
	
    <div id="body">
		<div class="container">
        <h3 class="title-h3">Изменение профиля</h3>
        <?php
        if($_SESSION['msg']){
            echo $_SESSION['msg'];
            unset ($_SESSION['msg']);
        }?>
            <form method="post" >

                <ul id="info-profile">
                    <li>
                        <label for="info_pass">Текущий пароль</label><span class="star">*</span>
                        <input type="text" name="info_pass" id="info_pass" value="">
                    </li>
                    <li>

                        <label for="info_new_pass">Новый пароль</label><span class="star">*</span>
                        <input type="text" name="info_new_pass" id="info_new_pass" value="">

                    </li>
                    <li>
                        <label for="info_surname">Фамилия</label><span class="star">*</span>
                        <input type="text" name="info_surname" id="info_surname" value="<?php if($_POST["save_submit"]){echo $_POST["info_surname"];}else{echo $_SESSION['auth_surname'];} ?>">
                    </li>
                    <li>
                        <label for="info_name">Имя</label><span class="star">*</span>
                        <input type="text" name="info_name" id="info_name" value="<?php if($_POST["save_submit"]){echo $_POST["info_name"];}else{echo  $_SESSION['auth_name'];} ?>">
                    </li>
                    <li>
                        <label for="info_patronymic">Отчество</label><span  class="star">*</span>
                        <input type="text" name="info_patronymic" id="info_patronymic" value="<?php if($_POST["save_submit"]){echo $_POST["info_patronymic"];}else{echo $_SESSION['auth_patronymic'];} ?>">
                    </li>
                    <li>
                        <label for="info_email">E-mail</label><span class="star">*</span>
                        <input type="text" name="info_email" id="info_email" value="<?php if($_POST["save_submit"]){echo $_POST["info_email"];}else{echo $_SESSION['auth_email'];} ?>">
                    </li>
                    <li>

                        <label for="info_phone">Мобильный телефон</label><span class="star">*</span>
                        <input type="text" name="info_phone" id="info_phone" value="<?php if($_POST["save_submit"]){echo $_POST["info_phone"];}else{echo $_SESSION['auth_phone'];} ?>">
                    </li>
                    <li>
                        <label for="info_address">Адрес доставки</label><span class="star">*</span>
                        <textarea name="info_address" > <?php if($_POST["save_submit"]){echo $_POST["info_address"];}else{echo $_SESSION['auth_address'];} ?></textarea>
                    </li>
                </ul>

<p align="right"><input type="submit" name="save_submit" id="form_submit"  value="Сохранить"></p>
            </form>
		</div>
        </div>









        <?php
include("include/block-footer.php");
?>


<script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script>window.jQuery || document.write("<script src='js/jquery-3.5.1.min.js'>\x3C/script>")</script>
	<script src="js/plugins.js"></script>
	<script src="js/main.js"></script>



</body>
</html>
<?php
}
else{
    header("Location:index.php");
} ?>
