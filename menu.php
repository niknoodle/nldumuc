<!-- Menu
 Date: April 05, 2018
 Author: Nikki Dalrymple
 Title: menu.php
 description: Menu to be included on all pages
 -->

<?php
session_start();
?>

<html lang="en-ca">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="./css.css" type="text/css">
    <title>Lab 7 e-Commerce Home</title>
</head>


<nav>
        <ul>
            <li class="home"><a href="index.php">Product List</a></li>

 <li class="InsertProducts"><a href="InsertProducts.php">Add Products</a></li>
 <li class="DeleteProducts"><a href="DeleteProducts.php">Remove Products</a></li>
<li class="UpdateProducts"><a href="UpdateProducts.php">Update Products</a></li>
<li class="OrderProducts"><a href="OrderProducts.php">Order Products</a></li>

<?php

   if (!isset($_SESSION['username'])){
        echo '<li class="login"><a href="login.php">Log In</a></li>';
}
      else {
         echo '<li class="logout"><a href="logout.php">Log Out</a></li>';
}
    
?>

        </ul>
 </nav>

<?php

function isLoginSessionExpired(){ 
	$current_time = time(); 
	if(isset($_SESSION['expire']) and isset($_SESSION["username"])){  
		if($_SESSION['expire'] < time()){ 
			return true; 
		} 
	}
	return false;
}
?>
