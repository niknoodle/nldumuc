<!-- finish page
 Date: April 05, 2018
 Author: Nikki Dalrymple
 Title: thankyou.php
 description: end of shopping experience
 -->
 
<?php

session_start();

include "./menu.php"; 

 if (isLoginSessionExpired()){
            session_destroy();
            echo "</br>Your session has expired! <a href='http://localhost/week4/Lab4/login.php'> Click Here to Login</a>";
        }
        else { 

        if (!isset($_SESSION['username'])) {
        echo "</br>Please Login again";
        echo "<a href='http://localhost/week4/Lab4/login.php'> Click Here to Login</a>";
    }
    else {

echo "<p><h2>Thank you for your order. Please log out using the menu option above if you are finished shopping.</h2></p>";

}
}
?>
