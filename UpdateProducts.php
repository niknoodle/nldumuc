<html>
	<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">   
   <title>Update Product </title>
</head>
<body > 

<?php 

include "./menu.php"; 

session_start();

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
// Check to see if Update id is provided
if (isset($_GET["productid"])) {
  $toUpdate = $_GET["productid"];
  // A bit dangerous without checks and use of getMethod
  updateIt($toUpdate);
  
   
}
else if (isset($_POST["UpdateMe"])) {
	// Assign values
  $productid = $_POST["productid"];
  $productname = $_POST["productname"];
  $productdescription = $_POST["productdescription"];
  $prodquantity = $_POST["prodquantity"];
  $price = $_POST["price"];
  
  $product = new ProductClass($productid,$productname,$productdescription,$prodquantity,$price);
  // Update the database
  FinalUpdate($product);
 	 echo "<h3>Product updated successfully.</h3>";
         echo "<p></p>";
	    echo "Select an option from the top menu to continue.";
}
 else {
	    show_form();  
	    
	    
	   	   }
}
}
	?>
		
<?php
function show_form() { 			
	
	echo "<p></p>";
	echo "<h2> Select the product to update</h2>";
	echo "<p></p>";	 	
	// Retrieve the products
	$products = selectProducts();
	
	echo "<h3> " . "Number of Products:  " . sizeof($products) . "</h3>";
	// Loop through table and display
	echo "<table border='1'>";
	foreach ($products as $data) {
	echo "<tr>";	
	// Provide Hyperlink for Selection
	// Could also use Form with Post method 
	echo "<td> <a href=UpdateProducts.php?productid=" . $data->getProductID() . ">" . "Update" . "</a></td>";
	 echo "<td>" . $data->getProductName() . "</td>";
	 echo "<td>" . $data->getProductDescription() . "</td>";
	 echo "<td>" . $data->getProdQuantity() . "</td>";
	 echo "<td>" . $data->getPrice() . "</td>";
	echo "</tr>";
}
	echo "</table>";

} // End Show form

?>

<?php
  	
  function getProduct ($productD) {
  	// Connect to the database
   $mysqli = connectdb();
   
   // Add Prepared Statement
		$Query = "Select ProductID, ProductName, ProductDescription, ProdQuantity, Price from Products 
		         where ProductID = ?";	         
	           
		$stmt = $mysqli->prepare($Query);
				
// Bind and Execute
$stmt->bind_param("s", $productD);
$result = $stmt->execute();

 $stmt->bind_result($productid,$productname,$productdescription,$prodquantity,$price);
 
  /* fetch values */
    $stmt->fetch();
  $productData = new Productclass($productid,$productname,$productdescription,$prodquantity,$price);

// Clean-up				
	$stmt->close();   
   $mysqli->close();
   return $productData;
  }
  function updateIt($productD) {
  	
  	
	$product = getProduct($productD);
	// Extract data
	$productid = $product->getProductID();
	$productname = $product->getProductName();
	$productdescription = $product->getProductDescription();
	$prodquantity= $product->getProdQuantity();
     $price= $product->getPrice();
	
	// Show the data in the Form for update
	?>
	<p></p>
	
	<form name="updateProduct" method="POST" action="UpdateProducts.php">	
	<table border="1" width="75%" cellpadding="0">			
			<tr>
				<td width="157">Product ID:</td>
				<td><input type="text" name="productid" value='<?php echo $productid ?>' size="30"></td>
			</tr>
			<tr>
				<td width="157">Product Name:</td>
				<td><input type="text" name="productname" value='<?php echo $productname ?>' size="30"></td>
			</tr>
			<tr>
				<td width="157">Product Quantity:</td>
				<td><input type="text" name="prodquantity" value='<?php echo $prodquantity ?>' size="30"></td>
			</tr>
			<tr>
				<td width="157">Product Description:</td>
				<td><input type="text" name="productdescription" value='<?php echo $productdescription ?>' size="30"></td>
			</tr>
<tr>
				<td width="157">Price:</td>
				<td><input type="text" name="price" value='<?php echo $price ?>' size="30"></td>
			</tr>
			<tr>
				<td width="157"><input type="submit" value="Update" name="UpdateMe"></td>
				<td>&nbsp;</td>
			</tr>
	</table>			
	</form>
		  	
  <?php	
  }
  function selectProducts ()
  {
		
		// Connect to the database
   $mysqli = connectdb();
		
	 
		// Add Prepared Statement
		$Query = "Select ProductID, ProductName, ProductDescription, ProdQuantity, Price from Products";	         
	          
		$result = $mysqli->query($Query);
		$myProducts = array();
if ($result->num_rows > 0) {    
    while($row = $result->fetch_assoc()) {
    	// Assign values
    	$productid = $row["ProductID"];
    	$productname = $row["ProductName"];
    	$productdescription = $row["ProductDescription"];
    	$prodquantity= $row["ProdQuantity"];
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
	
 // Class to construct Products with getters/setter
class ProductClass
{
    // property declaration
    private $productid="";
    private $productname="";
    private $productdescription="";
    private $prodquantity="";
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

// Final Update
function FinalUpdate($product) {
	// Assign values
  $productid = $product->getProductID();
  $productname = $product->getProductName();
  $prodquantity = $product->getProdQuantity();
  $productdescription = $product->getProductDescription();
  $price = $product->getPrice();
  
  // update
  // Connect to the database
   $mysqli = connectdb();		
	 		
		// Add Prepared Statement
		$Query = "Update Products set
		         ProductName = ?, ProductDescription = ?, ProdQuantity = ?, Price = ?
		         where ProductID = ?";
		         
	                    
		
		$stmt = $mysqli->prepare($Query);
				
$stmt->bind_param("ssidi", $productname, $productdescription,$prodquantity,$price,$productid);
$stmt->execute();

 //Clean-up				
	$stmt->close();   
   $mysqli->close();

}

?>
</body>
</html>
