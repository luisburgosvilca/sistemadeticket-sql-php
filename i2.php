<?php
$serverName = "10.7.48.6";
$connectionInfo = array("Database"=>"DB_TICKET","UID"=>"sa","PWD"=>"0nc0c4r3c\$b","CharacterSet"=>"UTF-8");
$conn = sqlsrv_connect($serverName,$connectionInfo);

        $query = "SELECT E.id, E.descripcion, (select count(*) from st_ticket T
                        where T.estado_id=E.id) as cantidad from st_estado E";
    //$result = mysqli_query($cn,$query) or die(mysqli_errno($cn).": ".mysqli_error($cn));
    $result = sqlsrv_query($conn,$query) or die(sqlsrv_errno($conn).': '.sqlsrv_error($conn));
    echo sqlsrv_num_rows($result);
    echo "<br>";
    while($r=sqlsrv_fetch_array($result)){
        echo $r['descripcion'].'<br>';
    }

            
?>