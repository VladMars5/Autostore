<?php 
if($_SERVER["REQUEST_METHOD"]=="POST"){
    include("../include/db_connect.php");
    $email=$_POST['reg_email'];
    $result=mysqli_query($link,"SELECT email FROM reg_user WHERE email='$email'");
    if(mysqli_num_rows($result)>0){
        echo 'false';
    }
    else{
        echo 'true';
    }
}
?>