<?php

include_once('../st_ModuloSeguridad/DataCn.php');

class Conexion extends DataCN{
    
    public function AbrirConexion(){
        
        $serverName = DataCN::servername;
        $connectionInfo = array("Database"=> DataCN::database,"UID"=> DataCN::user,"PWD"=> DataCN::password,"CharacterSet"=>"UTF-8");
        $conn = sqlsrv_connect($serverName,$connectionInfo);

        //$cn = mysqli_connect(DataCN::server,DataCN::username,DataCN::password, DataCN::database) or die(mysqli_errno().": ".mysqli_error());

        return $conn;
        
        
    }

    public function CerrarConexion($result,$conn){

        sqlsrv_free_stmt( $result);
        sqlsrv_close( $conn );
        //mysqli_free_result($result);
        //mysqli_close($cn);

    }
    
}