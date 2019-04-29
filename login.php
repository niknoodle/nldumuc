<!--Login Form
 Date: April 05, 2018
 Author: Nikki Dalrymple
 Title: login.php
 description: Login to eCommerce website
 -->

<?php
    session_start();

include "./menu.php";

$usernameErr = $emailaddrErr = $passwordErr = "";
$username = $emailaddr = $password = "";



   if ($_SERVER["REQUEST_METHOD"] == "POST") {
         $valid=true;
         if (empty($_POST["username"])) {
         $usernameErr = "Username is required";
         $valid=false;
         } else {
         $username = test_input($_POST["username"]);
   }

  if (empty($_POST["emailaddr"])) {
         $emailaddrErr = "Email Address is required";
         $valid=false;
        } else {
        $emailaddr = test_input($_POST["emailaddr"]);
         // check if e-mail address is well-formed
        if (!filter_var($emailaddr, FILTER_VALIDATE_EMAIL)) {
        $emailaddrErr = "Invalid email format"; 
        $valid=false;
    }
  }

  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
    $valid=false;
  } else {
    $password = test_input($_POST["password"]);
  
   if ($valid) {            
            $_SESSION['username'] = $username;
            $_SESSION['emailaddr'] = $emailaddr;
            $_SESSION['start'] = time(); 
            $_SESSION['expire'] = $_SESSION['start'] + (1800);
            header("Location: http://localhost/Week7/Lab7/index.php");
        } 
     }       
 }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<html>
<head>
   <title>Login</title>
</head>
<style>
.error {color: #FF0000;}
</style>
<body>
<table >
	<tr>
		<td colspan="2">	
<h4>Enter your Username, Email Address, and Password to continue</h4> 
</td>
</tr>
<!-- Login Form -->
<form name="main" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<tr> 
<td>username:</td> 
<td><input name="username" type="text" size="50" value="<?php echo $username;?>"><span class="error">* <?php echo $usernameErr;?></span></td> 

<br><br>
</tr> 
<tr> 
<td>Email Address:</td> 
<td><input name="emailaddr" type="text" size="50" value="<?php echo $emailaddr;?>"><span class="error">* <?php echo $emailaddrErr;?></span></td>

<br><br> 
</tr> 
<tr> 
<td>Password:</td> 
<td><input name="password" type="password" size="50" value="<?php echo $password;?>"><span class="error">* <?php echo $passwordErr;?></span>
<br><br></td>
</tr>
<tr> 
<td colspan="2" align="center"><input name="btnsubmit" type="submit" value="Submit"></td> 
</tr>
</table>
</form>



</body>
</html> 

