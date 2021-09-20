<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    session_start();
    unset($_SESSION['auth']);
    unset($_SESSION["order_fio"]);
    unset($_SESSION["order_email"]);
    unset($_SESSION["order_phone"]);
    unset($_SESSION["order_address"]);
    setcookie('rememberme','',0,'/');
    setcookie('save_cart', '',0,"/");
    echo'logout';
}
?>