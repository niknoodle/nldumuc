<?php

function show_form() { 			
	
	echo "<p></p>";
	echo "<h2> Product List</h2>";
	echo "<p></p>";	 	
	// Retrieve the products
	$products = selectProducts();
	
	echo "<h3> " . "Number of Products in Database is:  " . sizeof($products) . "</h3>";
	// Loop through table and display
	echo "<table border='1' width='75%'>";
	foreach ($products as $data) {
	echo "<tr>";	
	 echo "<td>" . $data->getProductID() . "</td>";
         echo "<td>" . $data->getProductName() . "</td>";
	 echo "<td>" . $data->getProductDescription() . "</td>";
	 echo "<td>" . $data->getProdQuantity() . "</td>";
	 echo "<td>$" . $data->getPrice() . "</td>";
	echo "</tr>";
}
	echo "</table>";

} // End Show form
?>

<?php
  	
  function selectProducts ()
  {
		
		// Connect to the database
   $mysqli = connectdb();
		
	 
		// Add Prepared Statement
		$Query = "Select ProductID, ProductName,  ProductDescription, ProdQuantity, Price from Products";	         
	          
		$result = $mysqli->query($Query);
		$myStudents = array();
if ($result->num_rows > 0) {    
    while($row = $result->fetch_assoc()) {
    	// Assign values
    	$productid = $row["ProductID"];
    	$productname = $row["ProductName"];
        $productdescription = $row["ProductDescription"];
    	$prodquantity = $row["ProdQuantity"];
    	$price= $row["Price"];    	
      
       // Create a Student instance     
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

?>
