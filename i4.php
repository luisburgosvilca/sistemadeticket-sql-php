<?php

try{
    
    $conn = new PDO("sqlsrv:Server=10.7.48.6,1433", "Database=db_ticket", "sa", "0nc0c4r3c\$b");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $ex) {
    die(print_r($e->getMessage()));
}

$tsql = "SELECT * FROM st_usuario";
$getResults = $conn->prepare($tsql);
$getResults->execute();
$results  = $getResults->fetchAll(PDO::FETCH_BOTH);

foreach ($results as $row){
    echo $row['username']."<br>";
}
