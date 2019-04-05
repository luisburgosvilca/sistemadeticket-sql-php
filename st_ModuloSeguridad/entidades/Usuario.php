<?php

include_once('../st_ModuloSeguridad/Conexion.php');
Class Usuario extends Conexion{
    
    function VerificarExistenciaDeUsuario($username){
        
        $conn = $this->AbrirConexion();
        
            $query = "SELECT U.id,U.username, P.nombre, P.apellido, P.tipo_id FROM st_usuario U
                       inner join st_persona P on U.persona_id=P.id
                           WHERE U.username = '$username'";
            //$params = array($username);
            //$result = mysqli_query($cn,$query) or die(mysqli_errno($cn).": ".mysqli_error($cn));      
            $result = sqlsrv_query($conn,$query) or die(sqlsrv_errno($conn).': '.sqlsrv_error($conn));
            return sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
            
        $this->CerrarConexion($result, $conn);    
    }
    
    function AutenticarUsuario($id,$password){
        
        $conn = $this->AbrirConexion();
        
            $query = "SELECT P.nombre,P.apellido, U.id, U.username,U.password, P.tipo_id FROM st_usuario U "
                    . " inner join st_persona P on U.persona_id=P.id"
                    . " WHERE U.id= '$id' and U.password='$password' and U.estado='1'";
            //$result = mysqli_query($cn,$query) or die(mysqli_errno($cn).": ".mysqli_error($cn));
            //return mysqli_fetch_array($result); 
            $result = sqlsrv_query($conn,$query) or die(sqlsrv_errno($conn).': '.sqlsrv_error($conn));

            return sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
            
        $this->CerrarConexion($result, $cn);          
        
    }
     
}