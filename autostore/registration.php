<?php

include("include/cookie-check.php");
include("include/db_connect.php");
include("include/auth_cookie.php");
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


	<div id="body">
		<div class="container">
        <h2 class="h2-title">Регистрация</h2>
            <form method="post" id="form_reg" action="/reg/handler_reg.php">
            <p id="reg_message"></p>
            <div id="block-form-registration">
                <ul id="form-registration">
                    <li>
                        <label>Логин</label><span class="star">*</span>
                        <input type="text" name="reg_login" id="reg_login">
                    </li>
                    <li>

                        <label >Пароль</label><span class="star">*</span>
                        <input type="text" name="reg_pass" id="reg_pass">
                        <span id="genpass">Сгенерировать</span>
                    </li>
                    <li>
                        <label>Фамилия</label><span class="star">*</span>
                        <input type="text" name="reg_surname" id="reg_surname">
                    </li>
                    <li>
                        <label>Имя</label><span class="star">*</span>
                        <input type="text" name="reg_name" id="reg_name">
                    </li>
                    <li>
                        <label>Отчество</label><span  class="star">*</span>
                        <input type="text" name="reg_patronymic" id="reg_patronymic">
                    </li>
                    <li>
                        <label>E-mail</label><span class="star">*</span>
                        <input type="text" name="reg_email" id="reg_email">
                    </li>
                    <li>

                        <label>Мобильный телефон</label><span class="star">*</span>
                        <input type="text" name="reg_phone" id="reg_phone">
                    </li>
                    <li id="bezperenosa">
                        <label>Адрес доставки</label><span class="star">*</span>
                        <input type="text" name="reg_address" id="reg_address">
                    </li>

                </ul>
            </div>
<p align="right"><input type="submit" name="reg_submit" id="form_submit"  value="Регистрация"></p>
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
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $.validator.addMethod("validaddress",function(value){
        var pattern=new RegExp(/г+\.[А-Яа-я\s-]+[\s,]+[ул|пер|пр|б-р]+\.[А-Яа-я\s-]+[\s,]+[дом|д]+\.[0-9\/]+[\s,]+кв+\.[0-9]/);
        var address=$("#reg_address").val();
        return pattern.test(address);
    },"");
    $.validator.addMethod("validphone",function(value){
        var pattern=new RegExp(/^(\+7|8)(\(\d{3}\)|\d{3})\d{7}$/);
        var phone=$("#reg_phone").val();
        return pattern.test(phone);
    },"");

    $.validator.addMethod("validname",function(value){
        var pattern=new RegExp(/^[А-Яа-я]+$/);
        var name=$("#reg_name").val();
        return pattern.test(name);
    },"");
    $.validator.addMethod("validsurname",function(value){
        var pattern=new RegExp(/^[А-Яа-я]+$/);
        var surname=$("#reg_surname").val();
        return pattern.test(surname);
    },"");
    $.validator.addMethod("validpatronymic",function(value){
        var pattern=new RegExp(/^[А-Яа-я]+$/);
        var patronymic=$("#reg_patronymic").val();
        return pattern.test(patronymic);
    },"");
    $('#form_reg').validate(
        {
            rules:{
                "reg_login":{
                    required:true,
                    minlength:5,
                    maxlength:15,
                    remote:{
                        type:"post",url:"/reg/check_login.php"
                    }
                },
                "reg_pass":{
                    required:true,
                    minlength:7,
                    maxlength:15
                },
                "reg_surname":{
                    required:true,
                    minlength:3,
                    maxlength:15,
                    validsurname:true
                },
                "reg_name":{
                    required:true,
                    minlength:2,
                    maxlength:15,
                    validname:true
                },
                "reg_patronymic":{
                    required:true,
                    minlength:3,
                    maxlength:25,
                    validpatronymic:true
                },
                "reg_email":{
                    required:true,
                    email:true,
                    remote:{
                        type:"post",url:"/reg/check_email.php"
                    }
                },
                "reg_phone":{
                    required:true,
                    validphone:true
                },
                "reg_address":{
                    required:true,
                    validaddress:true
                },

            },
            messages:{
                "reg_login":{
                    required:"Укажите логин!",
                    maxlength:"От 5 до 15 символов!",
                    minlength:"От 5 до 15 символов!",
                    remote:"Логин занят!"
                        },
                        "reg_pass":{
                    required:"Укажите пароль!",
                    maxlength:"От 5 до 15 символов!",
                    minlength:"От 5 до 15 символов!"
                        },
                        "reg_surname":{
                    required:"Укажите вашу фамилию!",
                    maxlength:"От 3 до 20 символов!",
                    minlength:"От 3 до 20 символов!",
                    validsurname:"Используйте пожалуйста буквы русского алфавита"
                        },
                        "reg_name":{
                    required:"Укажите ваше Имя!",
                    maxlength:"От 2 до 15 символов!",
                    minlength:"От 2 до 15 символов!",
                    validname:"Используйте пожалуйста буквы русского алфавита"
                        },
                        "reg_patronymic":{
                    required:"Укажите вашу отчество!",
                    maxlength:"От 3 до 25 символов!",
                    minlength:"От 3 до 25 символов!",
                    validpatronymic:"Используйте пожалуйста буквы русского алфавита"
                        },
                        "reg_email":{
                    required:"Укажите свой E-mail!",
                    email:"Не корректный E-mail",
                    remote:"Данный E-mail уже зарегистрирован!"
                        },
                        "reg_phone":{
                    required:"Укажите номер телефона!",
                    validphone:"Введите номер телефона в верном формате"
                        },
                        "reg_address":{
                    required:"Необходимо указать адрес доставки!",
                    validaddress:"Введите адрес по форме:г.город,ул(пер или пр или б-р).улица, дом(д).цифры(/корпус если имеется),кв.цифры"
                        },
                
            },

         submitHandler:function(form){
             $(form).ajaxSubmit({
                 success:function(data){
                     if(data=='true'){
                         $("#block-form-registration").fadeOut(300,function(){
                             $("#reg_message").removeClass("reg_message_error");
                             $("#reg_message").addClass("reg_message_good").fadeIn(400).html("Вы успешно зарегестрированы!");
                             $("#form_submit").hide();
                         });
                     }
                     else{
                         $("#reg_message").addClass("reg_message_error").fadeIn(400).html(data);
                     }
                 }
             });
         }
    });
});
 </script>



</body>
</html>
