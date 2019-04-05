<?php  
/* Connect to the local server using Windows Authentication and  
specify the AdventureWorks database as the database in use. */  
$serverName = "10.7.48.6";  
$connectionInfo = array("Database"=>"DB_TICKET","UID"=>"sa","PWD"=>"0nc0c4r3c\$b","CharacterSet"=>"UTF-8");  
$conn = sqlsrv_connect($serverName, $connectionInfo);  
if ($conn === false) {  
    echo "Could not connect.\n";  
    die(print_r(sqlsrv_errors(), true));  
}  

$username ="luis";
 $tsql = "SELECT * FROM ST_USUARIO where username = ?";
$params = array($username);  
/* Prepare and execute the query. */  
$stmt = sqlsrv_query($conn, $tsql,$params);  
if ($stmt) {  
    while ($u = sqlsrv_fetch_array($stmt)){
        echo $u['username'].'<br>';
    }
} else {  
    echo "Row insertion failed.\n";  
    die(print_r(sqlsrv_errors(), true));  
}  

/* Free statement and connection resources. */
sqlsrv_free_stmt($stmt);  
sqlsrv_close($conn);  
  
/* Set up the parameterized query. *
$tsql = "INSERT INTO Sales.SalesOrderDetail   
        (SalesOrderID,   
         OrderQty,   
         ProductID,   
         SpecialOfferID,   
         UnitPrice,   
         UnitPriceDiscount)  
        VALUES   
        (?, ?, ?, ?, ?, ?)";  
  
/* Set parameter values. *
$params = array(75123, 5, 741, 1, 818.70, 0.00);  */
?>  