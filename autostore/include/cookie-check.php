<?php
if(!isset($_COOKIE["save_cart"]) && $_SESSION['auth']!='yes_auth')
    {
		srand((double) microtime() * 1000000);
		$uniq_id = uniqid(rand());		
		setcookie("save_cart", $uniq_id,(time()+(86400 * 30)));
    }
    else
    {
        
      $uniq_id=$_COOKIE["save_cart"];
      
    } 
    session_start();
    
    
?>