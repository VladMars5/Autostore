<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    include("db_connect.php");
    
    $email=$_POST["email"];
    if($email!=""){
        $result=mysqli_query($link,"SELECT email FROM reg_user WHERE email='$email'");
        if(mysqli_num_rows($result)>0){
            // Символы, которые будут использоваться в пароле.

$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";

// Количество символов в пароле.

$max=10;

// Определяем количество символов в $chars

$size=StrLen($chars)-1;

// Определяем пустую переменную, в которую и будем записывать символы.

$password=null;

// Создаём пароль.

    while($max--)
    $password.=$chars[rand(0,$size)];

// Выводим созданный пароль.


$pass=md5($password);
$pass=strrev($pass);
$pass=strtolower("9nm2rv8q".$pass."2yo6z");
$update=mysqli_query($link,"UPDATE reg_user SET pass='$pass' WHERE email='$email'");
mail($email,'Новый пароль для сайта inet-magazin','Ваш пароль: '.$password,'From: Inet.magazin.pearl@gmail.com');
echo'yes';
        }
        else{
            echo'Данный E-mail не найден!';
        }
    }
}
?>