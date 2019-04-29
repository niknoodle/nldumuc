<?php

session_start();
include "./menu.php";

  if (isLoginSessionExpired()){
            session_destroy();
            echo "</br>Your session has expired! <a href='http://localhost/Week7/Lab7/login.php'> Click Here to Login</a>";
        }
        else { 

        if (!isset($_SESSION['username'])) {
        echo "</br>Please Login again";
        echo "<a href='http://localhost/Week7/Lab7/login.php'> Click Here to Login</a>";
    }
    else {

if(isset($_POST["CreateSubmit"])) 
		{    	 
	 	 		 	 	
	   	validate_form();	   	     
		} 
		else 
		{			    
			$messages = array();
	    show_form($messages);  
  	} 
}

}


function show_form() { 

        echo "<h2>Enter customer information:</h2>";

?>
<form name="orderproduct" method="POST" action="OrderProducts.php">
<table>
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
</table>
	<?php		
	
	echo "<p></p>";
	echo "<h2> Select Quantities Desired:</h2>";
	echo "<p></p>";	 	
	// Retrieve the products
	$products = selectProducts();
	

	// Loop through table and display
	echo "<table border='1' width='75%'>";
	foreach ($products as $data) {
	echo "<tr>";	
	 echo "<td>" . $data->getProductID() . "</td>";
         echo "<td>" . $data->getProductName() . "</td>";
	 echo "<td>" . $data->getProductDescription() . "</td>";
	 echo "<td>" . $data->getProdQuantity() . "</td>";
	 echo "<td>$" . $data->getPrice() . "</td>";
         echo "<td><input type='number' name='orderQuantity' min='0' selected='0'></td>";

        
	echo "</tr>";


}
	
?>
<tr>
				<td width="157"><input type="submit" value="Place Order" name="CreateSubmit"></td>
				<td>&nbsp;</td>
			</tr>
<?php
echo "</table>";

} // End Show form
?>

<?php


function validate_form(){

  $messages = array();
  $redisplay = false;
 // Assign values
  $customerid = 0;
  $firstname = $_POST["firstName"];
  $lastname = $_POST["lastName"];
  $streetaddress = $_POST["streetAddress"];
  $city = $_POST["city"];
  $state = $_POST["state"];
  $zipcode =$_POST["zipCode"];
  
  $customer = new CustomerClass($customerid,$firstname,$lastname,$streetaddress,$city,$state,$zipcode);
   
  	  		
            insertCustomer($customer);
           
                
            echo  "<h3>Customer Added Successfully.</h3> "; 



}

 function insertCustomer ($customer)
  {
		
		// Connect to the database
   $mysqli = connectdb();
   $customerid = 0;
   $firstname = $customer->getFirstName();
   $lastname = $customer->getLastName();
   $streetaddress = $customer->getStreetAddress();
   $city = $customer->getCity();
   $state = $customer->getState();
   $zipcode = $customer->getZipcode();
		
		// Add Prepared Statement
		$Query = "INSERT INTO Customers 
	          (CustomerID,FirstName,LastName,StreetAddress,City,State,Zip) 
	           VALUES (0,?,?,?,?,?,?)";
	           
if($stmt = $mysqli->prepare($Query))
{
echo ("Error: "	.mysqli_error($Query));
}
				 
$stmt->bind_param("issssss", $customerid, $firstname, $lastname,$streetaddress,$city,$state,$zipcode);
$stmt->execute();
		
		echo 
	
	$stmt->close();
	$mysqli->close();

		
		return true;

}
  	
  function selectProducts ()
  {
		
		// Connect to the database
   $mysqli = connectdb();
		
	 
		// Add Prepared Statement
		$Query = "Select ProductID, ProductName,  ProductDescription, ProdQuantity, Price from Products";	         
	          
		$result = $mysqli->query($Query);
		$myProducts = array();
if ($result->num_rows > 0) {    
    while($row = $result->fetch_assoc()) {
    	// Assign values
    	$productid = $row["ProductID"];
    	$productname = $row["ProductName"];
        $productdescription = $row["ProductDescription"];
    	$prodquantity = $row["ProdQuantity"];
    	$price= $row["Price"];    	
      
       // Create a Product instance     
       $productData = new Productclass($productid,$productname,$productdescription,$prodquantity,$price);
       $myProducts[] = $productData;         
      }    
 } 

	$mysqli->close();
	
	return $myProducts;		
		
	}


  function getDbparms()
	 {
	 	$trimmed = file('parms/dbparms.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$key = array();
	$vals = array();
	foreach($trimmed as $line)
	{
		  $pairs = explode("=",$line);    
	    $key[] = $pairs[0];
	    $vals[] = $pairs[1]; 
	}
	// Combine Key and values into an array
	$mypairs = array_combine($key,$vals);
	
	// Assign values to ParametersClass
	$myDbparms = new DbparmsClass($mypairs['username'],$mypairs['password'],
	                $mypairs['host'],$mypairs['db']);
	
	// Display the Paramters values
	return $myDbparms;
	 }
	 
  function connectdb() {      		
		// Get the DBParameters
	  $mydbparms = getDbparms();
	  
	  // Try to connect
	  $mysqli = new mysqli($mydbparms->getHost(), $mydbparms->getUsername(), 
	                        $mydbparms->getPassword(),$mydbparms->getDb());
	
	   if ($mysqli->connect_error) {
	      die('Connect Error (' . $mysqli->connect_errno . ') '
	            . $mysqli->connect_error);      
	   }
	  return $mysqli;
	}
 
 class DBparmsClass
	{
	    // property declaration  
	    private $username="";
	    private $password="";
	    private $host="";
	    private $db="";
	   
	    // Constructor
	    public function __construct($myusername,$mypassword,$myhost,$mydb)
	    {
	      $this->username = $myusername;
	      $this->password = $mypassword;
			  $this->host = $myhost;
				$this->db = $mydb;
	    }
	    
	    // Get methods 
		  public function getUsername ()
	    {
	    	return $this->username;
	    } 
		  public function getPassword ()
	    {
	    	return $this->password;
	    } 
		  public function getHost ()
	    {
	    	return $this->host;
	    } 
		  public function getDb ()
	    {
	    	return $this->db;
	    } 	 
	
	    // Set methods 
	    public function setUsername ($myusername)
	    {
	    	$this->username = $myusername;    	
	    }
	    public function setPassword ($mypassword)
	    {
	    	$this->password = $mypassword;    	
	    }
	    public function setHost ($myhost)
	    {
	    	$this->host = $myhost;    	
	    }
	    public function setDb ($mydb)
	    {
	    	$this->db = $mydb;    	
	    }    
	    
	} // End DBparms class
	
 // Class to construct Productss with getters/setter
class ProductClass
{
    // property declaration
    private $productid="";
    private $productname="";
    private $productdescription="";
    private $prodQuantity="";
    private $price="";
   
    // Constructor
    public function __construct($productid,$productname,$productdescription,$prodquantity,$price)
    {
      $this->productid = $productid;
      $this->productname = $productname;
      $this->productdescription = $productdescription;
      $this->prodquantity = $prodquantity; 
      $this->price = $price;     
    }
    
    // Get methods 
	  public function getProductID ()
    {
    	return $this->productid;
    } 
	  public function getProductName ()
    {
    	return $this->productname;
    } 
	  public function getProductDescription ()
    {
    	return $this->productdescription;
    } 
	  public function getProdQuantity ()
    {
    	return $this->prodquantity;
    } 
        public function getPrice()
    {
    	return $this->price;
    } 
	  

    // Set methods 
    public function setProductID ($value)
    {
    	$this->productid = $value;    	
    }
    public function setProductName ($value)
    {
    	$this->productname = $value;    	
    }
    public function setProductDescription ($value)
    {
    	$this->productdescription = $value;    	
    }
    public function setProdQuantity ($value)
    {
    	$this->prodquantity = $value;    	
    }     

     public function setPrice ($value)
    {
    	$this->price = $value;    	
    }   
    
} // End Productclass

// Class to construct Customers with getters/setter
class CustomerClass
{
    // property declaration
    private $customerid="";
    private $firstname="";
    private $lastname="";
    private $streetaddress="";
    private $city="";
    private $state="";
    private $zipcode="";
   
    // Constructor
    public function __construct($customerid,$firstname,$lastname,$streetaddress,$city,$state,$zipcode)
    {
      $this->customerid = $customerid;
      $this->firstname = $firstname;
      $this->lastname = $lastname;
      $this->streetaddress = $streetaddress; 
      $this->city = $city;
      $this->state = $state;
      $this->zipcode = $zipcode;     
    }
    
    // Get methods 
	  
      public function getCustomerID ()
    {
    	return $this->customerid;

}
	  public function getFirstName ()
    {
    	return $this->firstname;
    } 
	  public function getLastName ()
    {
    	return $this->lastname;
    } 
	  public function getStreetAddress ()
    {
    	return $this->streetaddress;
    } 
  public function getCity ()
    {
    	return $this->city;
    } 
 public function getState ()
    {
    	return $this->state;
    } 
	  
 public function getZipcode ()
    {
    	return $this->zipcode;
    } 
	  
	  	  


    // Set methods 

 public function setCustomerID ($value)
    {
    	$this->customeridid = $value;    	
    }
      
   
    public function setFirstName ($value)
    {
    	$this->firstname = $value;    	
    }
    public function setLastName ($value)
    {
    	$this->lastname = $value;    	
    }
    public function setStreetAddress ($value)
    {
    	$this->streetaddress = $value;    	
    }   
    public function setCity ($value)
    {
    	$this->city = $value;    	
    }
     public function setState ($value)
    {
    	$this->state = $value;    	
    }
 public function setCZipcode ($value)
    {
    	$this->zipcode = $value;    	
    }
 }

    // End Customerclass

?>
