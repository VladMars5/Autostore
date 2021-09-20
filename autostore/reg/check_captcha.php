<?php
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    session_start();
    if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $_POST['reg_captcha'])    
    {
       echo'true';
    }
    else{
        echo 'false';
    }
} ?>