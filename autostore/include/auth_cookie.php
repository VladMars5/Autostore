<?php
include('db_connect.php');
include('cookie-check.php');
if($_SESSION['auth']!='yes_auth'&& $_COOKIE["rememberme"]){
    $str=$_COOKIE["rememberme"];
    $all_len=strlen($str);
    $login_len=strpos($str,'+');
    $login=substr($str,0,$login_len);
    $pass=substr($str,$login_len+1,$all_len);    
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
    }
    
}
?>