<?php
$db_host='localhost';
$db_user='root';
$db_pass='root';
$db_databasse='online_store';
$link=mysqli_connect($db_host,$db_user,$db_pass);
mysqli_select_db($link,$db_databasse) or die ("Нет соединения с БД".mysqli_connect_error() );


 ?>
