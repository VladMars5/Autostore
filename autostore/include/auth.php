<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    include('db_connect.php');
    include('cookie-check.php');
    $login=$_POST["login"];
    $pass=md5($_POST["pass"]);
    $pass=strrev($pass);
    $pass=strtolower("9nm2rv8q".$pass."2yo6z");
    if($_POST["rememberme"]=="yes"){        
        setcookie("rememberme",$login.'+'.$pass,(time()+(3600*24*31)),"/");         
    }
    $result=mysqli_query($link,"SELECT* FROM reg_user WHERE(login='$login'or email='$login')AND pass='$pass'");
    if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_array($result);
        $_SESSION['auth']='yes_auth';
        $_SESSION['auth_pass']=$row["pass"];
        $_SESSION['auth_login']=$row["login"];
        $_SESSION['auth_surname']=$row["surname"];
        $_SESSION['auth_name']=$row["name"];
        $_SESSION['auth_patronymic']=$row["patronymic"];
        $_SESSION['auth_address']=$row["address"];
        $_SESSION['auth_phone']=$row["phone"];
        $_SESSION['auth_email']=$row["email"];
        $_SESSION["order_fio"]=$_SESSION['auth_surname'].' '. $_SESSION['auth_name'].' '.$_SESSION['auth_patronymic'];
        $_SESSION["order_email"]= $_SESSION['auth_email'];
        $_SESSION["order_phone"]=$_SESSION['auth_phone'];
        $_SESSION["order_address"]=$_SESSION['auth_address'];
        setcookie("save_cart", $row["ip"],(time()+(86400 * 30)),"/");
        echo'yes_auth';
    }
    else{
        echo 'no_auth';
    }
}
?>