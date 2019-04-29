<!-- Checkout Form
 Date: April 05, 2018
 Author: Nikki Dalrymple
 Title: checkout.php
 description: Checkout and place order
 -->

<?php  

session_start();
include "./menu.php";
include "./products.php";

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

function totalPrice($price, $quantity) {
    return $price * $quantity;
}

?>
<html lang="en-ca">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="./css.css" type="text/css">
    <title>e-Commerce Site Checkout</title>
</head>

<form method="post" action="thankyou.php">

<p><h2>Order Verification</h2></p>
<p><h3>Please verify your selections below and enter your payment information. Then click the Purchase button.</h3></p>
</br>
First Name: <?php echo $_SESSION['username'];?></br>
</br>
Email Address: <?php echo $_SESSION['emailaddr'];?></br>
</br>

<table width="75%">

<tr><th>Item</th><th>Quantity</th><th>Price</th><th>Total Price</th></tr>

<?php

$arrlength = count($products);

$grandtotal=0;

for($x = 0; $x < $arrlength; $x++) {
    $pvariable = $products[$x][3];
    if ($_POST[$pvariable]>"0"){
          echo "<tr><td>".$products[$x][0]."</td><td align='right'>".$_POST[$pvariable]."</td><td align='right'>".$products[$x][2]."</td><td align='right'>".totalPrice($products[$x][2],$_POST[$pvariable])."</td></tr>";
          $grandtotal = $grandtotal + totalPrice($products[$x][2],$_POST[$pvariable]);     
        }
}

echo '<tr><td colspan="3" align="right"><h2>Order Total</td><td align="right">'.$grandtotal.'</h2></td></tr>';

?>

<tr><td><p><h3>Shipping/Billing Information</h3></p></td></tr>

<tr><td>First Name: </td><td><input type="text" name="firstName"></td></tr>
<tr><td>Last Name: </td><td><input type="text" name="lastName"></td></tr>
<tr><td>Street Address: </td><td> <input type="text" name="streetAddress"></td></tr>
<tr><td>City: </td><td><input type="text" name="city"></td></tr>
<tr><td><select name="state" id="state">
  <option value="" selected="selected">Select a State</option>
  <option value="AL">Alabama</option>
  <option value="AK">Alaska</option>
  <option value="AZ">Arizona</option>
  <option value="AR">Arkansas</option>
  <option value="CA">California</option>
  <option value="CO">Colorado</option>
  <option value="CT">Connecticut</option>
  <option value="DE">Delaware</option>
  <option value="DC">District Of Columbia</option>
  <option value="FL">Florida</option>
  <option value="GA">Georgia</option>
  <option value="HI">Hawaii</option>
  <option value="ID">Idaho</option>
  <option value="IL">Illinois</option>
  <option value="IN">Indiana</option>
  <option value="IA">Iowa</option>
  <option value="KS">Kansas</option>
  <option value="KY">Kentucky</option>
  <option value="LA">Louisiana</option>
  <option value="ME">Maine</option>
  <option value="MD">Maryland</option>
  <option value="MA">Massachusetts</option>
  <option value="MI">Michigan</option>
  <option value="MN">Minnesota</option>
  <option value="MS">Mississippi</option>
  <option value="MO">Missouri</option>
  <option value="MT">Montana</option>
  <option value="NE">Nebraska</option>
  <option value="NV">Nevada</option>
  <option value="NH">New Hampshire</option>
  <option value="NJ">New Jersey</option>
  <option value="NM">New Mexico</option>
  <option value="NY">New York</option>
  <option value="NC">North Carolina</option>
  <option value="ND">North Dakota</option>
  <option value="OH">Ohio</option>
  <option value="OK">Oklahoma</option>
  <option value="OR">Oregon</option>
  <option value="PA">Pennsylvania</option>
  <option value="RI">Rhode Island</option>
  <option value="SC">South Carolina</option>
  <option value="SD">South Dakota</option>
  <option value="TN">Tennessee</option>
  <option value="TX">Texas</option>
  <option value="UT">Utah</option>
  <option value="VT">Vermont</option>
  <option value="VA">Virginia</option>
  <option value="WA">Washington</option>
  <option value="WV">West Virginia</option>
  <option value="WI">Wisconsin</option>
  <option value="WY">Wyoming</option></td>
<td></select> Zipcode: <input type="text" name="zipCode" maxlength="5" size="5"></td></tr>
<tr><td>Credit Card Type:</td></tr>
  <tr><td><input type="radio" name="cType" value="Visa"> Visa</td>
  <td><input type="radio" name="cType" value="Mastercard"> Mastercard<br></td>
  <td><input type="radio" name="cType" value="American Express"> American Express</td>
</tr>
<tr><td>Credit Card Number: </td></tr>
<tr><td><input type="text" name="ccNumber"></td></tr>
<tr><td>Expiration Date:</td></tr> 
<tr><td><select name="expMonth" id="expMonth">
  <option value="" selected="selected">Select a Month</option>
  <option value="01">01</option>
  <option value="02">02</option>
  <option value="03">03</option>
  <option value="04">04</option>
  <option value="05">05</option>
  <option value="06">06</option>
  <option value="07">07</option>
  <option value="08">08</option>
  <option value="09">09</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="22">12</option>
</select></td><td>
<select name="expYear" id="expYear">
  <option value="" selected="selected">Select a Year</option>
  <option value="2018">2018</option>
  <option value="2019">2019</option>
  <option value="2020">2020</option>
  <option value="2021">2021</option>
  <option value="2022">2022</option>
  <option value="2023">2023</option>
  <option value="2024">2024</option>
  <option value="2025">2025</option>
  <option value="2026">2027</option>
  <option value="2028">2028</option>
  <option value="2029">2029</option>
  <option value="2030">2030</option>
</select></td></tr>
<tr><td colspan="4">Comments: <textarea name="comments" rows="10" cols="100"></textarea></td></tr>
<tr><td><input type="submit" value="Purchase"/></td><td><input type="reset" value="Clear"/></td></tr>
</table>
</form>
<?php
}
}
?>
</html>
