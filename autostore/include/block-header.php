<header id="header">
		<div class="container">
			<a href="index.php" >MotorSide</a>
			
<div style="background-image: url('<?=$imgPath?>;')"></div>
			<?php
			if($_SESSION['auth']=='yes_auth'){
               echo'<p id="auth-user-info" align="right"> <img src="/images/ico_auth.png"/> Здравствуйте,'.$_SESSION['auth_name'].'!</p>';
			}
			else{
				echo'<p id="reg-aut-title" align="right"><a class="top-auth">Вход</a><a href="registration.php">Регистрация</a></p>';

			}
			?>
			<div id="block-top-auth">
			<form method="post">
			<ul id="input-email-pass">
			<h3>Вход</h3>
			<p id="message-auth">Неверный логин и(или) пароль</p>
			<li><center><input type="text" id="auth_login" placeholder="Логин или e-mail"></center></li>
			<li><center><input type="password" id="auth_pass" placeholder="Пароль"><span id="button-pass-show-hide" class="pass-show"></span></center></li>
			<ul id="list-auth">
			<li>
			<label class="container-box">Запомнить меня
            <input type="checkbox"  name="rememberme" id="rememberme" >
            <span class="checkmark"></span>
</label>
		</li>
			<li><a id="remindpass">Забыли пароль?</a></li>
			</ul>
			<p align="right"id="button-auth"><a href="profile.php" >Вход</a></p>
			
			</ul>
			</form>
			<div id="block-remind">
				<h3>Восстановление<br>пароля</h3>
				<p id="message-remind" class="message-remind-success"></p>
				<center><input type="text"id="remind-email"placeholder="Ваш E-mail"></center>
				<p align="right" id="button-remind">
					<a>Готово</a>
				</p>
				<p id="prev-auth">Назад</p>
			</div>
			</div>
			<div id="block-user">
		
			<ul>				
				<li><img src="/images/user_info.png"><a href="profile.php">Профиль</a></li>				
				<li><img src="/images/out_profile.png"><a id="logout">Выход</a></li>
			</ul>
		
	</div>
			
		</div>
		
	</header>
	
	