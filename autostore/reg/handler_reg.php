<?php
include("../include/cookie-check.php");
include("../include/db_connect.php");

$error=array();
$login=strtolower($_POST['reg_login']);
$pass=strtolower($_POST['reg_pass']);
$surname=$_POST['reg_surname'];

$name=$_POST['reg_name'];
$patronymic=$_POST['reg_patronymic'];
$email=$_POST['reg_email'];

$phone=$_POST['reg_phone'];
$address=$_POST['reg_address'];
if(mb_strlen($login)<5 or mb_strlen($login)>15){
    $error="Логин должен быть от 5 до 15 символов!";
}
else{
    $result=mysqli_query($link,"SELECT login FROM reg_user WHERE login='$login'");
    if(mysqli_num_rows($result)>0){
        $error[]="Логин занят!";
    }
}
if(mb_strlen($pass)<7 or mb_strlen($pass)>15) $error[]="Укажите пароль от 7 до 15 символов!";
if(mb_strlen($surname)<3 or mb_strlen($surname)>15) $error[]="Укажите фамилию от 3 до 15 символов!";
if(mb_strlen($name)<2 or mb_strlen($name)>15) $error[]="Укажите имя от 2 до 15 символов!";
if(mb_strlen($patronymic)<3 or mb_strlen($patronymic)>25) $error[]="Укажите отчество от 3 до 15 символов!";
if(!preg_match("/^[\w]{1}[\w-\.]*@[\w-]+\.[a-z]{2,4}$/i",trim($email))) {$error[]="Укажите корректный email";} else{$result=mysqli_query($link,"SELECT email FROM reg_user WHERE email='$email'"); if(mysqli_num_rows($result)>0){
    $error[]="Данный E-mail уже зарегистрирован!";
}}
if(!preg_match("/^(\+7|8)(\(\d{3}\)|\d{3})\d{7}$/",trim($phone))) $error[]="Укажите корректный номер телефона";
if(!preg_match("/г+\.[А-Яа-я\s-]+[\s,]+[ул|пер|пр|б-р]+\.[А-Яа-я\s-]+[\s,]+[дом|д]+\.[0-9\/]+[\s,]+кв+\.[0-9]/u",trim($address))) $error[]="Укажите корректный адрес доставки";
if(count($error)){
    echo implode('<br>',$error);
}
else{
    $pass=md5($pass);
    $pass=strrev($pass);
    $pass="9nm2rv8q".$pass."2yo6z";
    $ip= $uniq_id;
    unset($_SESSION['captcha_keystring']);
    mysqli_query($link,"INSERT INTO reg_user(login,pass,surname,name,patronymic,email,phone,address,datatime,ip) VALUES('".$login."','".$pass."','".$surname."','".$name."','".$patronymic."','".$email."','".$phone."','".$address."',NOW(),'".$ip."')");
    echo 'true';

}
?>
