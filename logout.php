<!-- Logout Form
 Date: April 05, 2018
 Author: Nikki Dalrymple
 Title: logout.php.php
 description: Form displays when logged out
 -->

<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <Title> Logout </Title>
</head>

<?php

include "./menu.php";

session_start();
session_destroy();
?>

<br/>

<?php

echo "<h3>You have successfully logged out.</h3>";
echo "<p>You will be automatically redirected to the login page in 5 seconds.</p>";

header( "refresh:5;url=login.php" );

?>


