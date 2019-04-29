<!-- index
 Date: April 29, 2018
 Author: Nikki Dalrymple
 Title: index.php
 description: start of navigation
 -->

<?php
session_start();
?>


<form method="post" action="checkout.php">

<?php 

include "./menu.php";
include "./SelectProducts.php"; 
      
   if (isLoginSessionExpired()){
            session_destroy();
            echo "</br>Your session has expired! <a href='http://localhost/Week7/Lab7/login.php'> Click Here to Login</a>";
        }
        else { 

        if (!isset($_SESSION['username'])) {
        echo "</br>Please Login again <br>";
        echo "<a href='http://localhost/Week7/Lab7/login.php'> Click Here to Login</a>";
    }
    else {

		
	    
       

 if (isset($_SESSION['username'])) {
            echo "<p small>You are currently logged in as " .$_SESSION['username']."</p>" ;}
                      else {
            echo "<p small>You are not logged in </p>"; 
                }     

  show_form(); 
                      
?>
 
     
   
</body>
</html>
</main>

</body>
</html>

<?php
        }
    }
?>
