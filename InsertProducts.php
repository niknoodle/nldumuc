<html>
	<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">   
   <title>Create Product </title>
</head>
<body OnLoad="document.createproduct.productname.focus();"> 

<?php

session_start();

   	
include "./menu.php";

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
	?>
		
<?php
function show_form($messages) { 		
			
		
		// Assign post values if exist
		$productid =0;
		$productname="";
		$productdescription="";
		$prodquantity="";
                $price="";
		
	        if (isset($_POST["productname"]))
		  $productname=$_POST["productname"];	  
		if (isset($_POST["productdescription"]))
		  $productdescription=$_POST["productdescription"];  
		if (isset($_POST["prodquantity"]))
		  $prodquantity=$_POST["prodquantity"];
                 if (isset($_POST["price"]))
		  $price=$_POST["price"];
	
	echo "<p></p>";
	echo "<h2> Enter New Product Information</h2>";
	echo "<p></p>";	 	
	?>
	<h5>Complete the information in the form below and click Submit to add new products. All fields are required.</h5>
	<form name="createproduct" method="POST" action="InsertProducts.php">	
	<table border="1" width="100%" cellpadding="0">			
			
			<tr>
				<td width="157">Product Name:</td>
				<td><input type="text" name="productname" value='<?php echo $productname ?>' size="30"></td>
			</tr>
			<tr>
				<td width="157">Product Description:</td>
				<td><input type="text" name="productdescription" value='<?php echo $productdescription ?>' size="30"></td>
			</tr>
			<tr>
				<td width="157">Product Quantity:</td>
				<td><input type="text" name="prodquantity" value='<?php echo $prodquantity ?>' size="30"></td>
			</tr>
                        <tr>
				<td width="157">Price:</td>
				<td><input type="text" name="price" value='<?php echo $price ?>' size="30"></td>
			</tr>
			<tr>
				<td width="157"><input type="submit" value="Submit" name="CreateSubmit"></td>
				<td>&nbsp;</td>
			</tr>
	</table>			
	</form>
	
	<?php
} // End Show form


?>

<?php
function validate_form()
{
		
	$messages = array();
  $redisplay = false;
  // Assign values
  $productid = 0;
  $productname = $_POST["productname"];
  $productdescription = $_POST["productdescription"];
  $prodquantity = $_POST["prodquantity"];
  $price = $_POST["price"];
  
  $product = new ProductClass($productid,$productname,$productdescription,$prodquantity,$price);
  	$count = countProduct($product);    	  
 
 	 
  	// Check for accounts that already exist and Do insert
  	if ($count==0) 
  	{  		
  		$res = insertProduct($product);
  		echo "<h3>Product Added Successfully.</h3> "; 
                echo "Select an option from the top menu to continue. ";        
  	}
  	else 
  	{
  		echo "<h3>A product with that name already exists.</h3> ";  		
  	}  	
  }
}
  
 function countProduct ($product)
  {  	  	 
  	// Connect to the database
   $mysqli = connectdb();
  
   $productid = $product->getProductID(); 
   $productname = $product->getProductName();
   $productdescription = $product->getProductDescription();
   $prodquantity = $product->getProdQuantity();
   $price = $product->getPrice();
   
		// Connect to the database
	$mysqli = connectdb();
		
	// Define the Query
	// For Windows MYSQL String is case insensitive
	 $Myquery = "SELECT count(*) as count from Products
		   where ProductName ='$productname'";	 
		
	 if ($result = $mysqli->query($Myquery)) 
	 {
	    /* Fetch the results of the query */	     
	    while( $row = $result->fetch_assoc() )
	    {
	  	  $count=$row["count"];	    			   	     	  	     	  
	    }	 
	
 	    /* Destroy the result set and free the memory used for it */
	    $result->close();	      
   }
	
	$mysqli->close();   
	    
	return $count;
  	  	
  }
  	
  function insertProduct ($product)
  {
		
		// Connect to the database
   $mysqli = connectdb();
   $productid = 0;
   $productname = $product->getProductName();
   $productdescription = $product->getProductDescription();
   $prodquantity = $product->getProdQuantity();
   $price = $product->getPrice();
		
		// Add Prepared Statement
		$Query = "INSERT INTO Products 
	          (ProductID,ProductName,ProductDescription,ProdQuantity, Price) 
	           VALUES (?,?,?,?,?)";
	           
$stmt = $mysqli->prepare($Query);		
				 
$stmt->bind_param("issid", $productid, $productname, $productdescription,$prodquantity,$price);
$stmt->execute();
		
		
	
	$stmt->close();
	$mysqli->close();

		
		return true;

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
	
 // Class to construct Products with getters/setter
class ProductClass
{
    // property declaration
    private $productid="";
    private $productname="";
    private $prodquantity="";
    private $productdescription="";
    private $price="";
   
    // Constructor
    public function __construct($productid,$productname,$productdescription,$prodquantity,$price)
    {
      $this->productid = $productid;
      $this->productname = $productname;
      $this->prodquantity = $prodquantity;
      $this->productdescription = $productdescription; 
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
	  public function getProdQuantity ()
    {
    	return $this->prodquantity;
    } 
	  public function getProductDescription ()
    {
    	return $this->productdescription;
    } 
  public function getPrice ()
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
    public function setProdQuantity ($value)
    {
    	$this->prodquantity = $value;    	
    }
    public function setProductDescription ($value)
    {
    	$this->productdescription = $value;    	
    }   
    public function setPrice ($value)
    {
    	$this->price = $value;    	
    }
    
 }

    // End Productclass

?>
</body>
</html>
