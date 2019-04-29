<?php

include_once('../st_ModuloSeguridad/Conexion.php');
Class Usuario extends Conexion{
    
    function VerificarExistenciaDeUsuario($username){
        
        $conn = $this->AbrirConexion();
        
//            $query = "SELECT U.id,U.username, P.nombre, P.apellido, P.tipo_id FROM st_usuario U
//                       inner join st_persona P on U.persona_id=P.id
//                           WHERE U.username = '$username'";

            $query = "exec DB_Aliada_Production.[ONCO].[SYS_CONSULTAS_USUARIO] @VAROPCION=1,@VARSUBOPCION=0,@USUARIO='$username'";
            //$params = array($username);
            //$result = mysqli_query($cn,$query) or die(mysqli_errno($cn).": ".mysqli_error($cn));      
            $result = sqlsrv_query($conn,$query) or die("Error x1: Usuario");
         
            return sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
            
        $this->CerrarConexion($result, $conn);
    }
    
    function AutenticarUsuario($clave){
        
        $conn = $this->AbrirConexion();
        
//            $query = "SELECT P.nombre,P.apellido, U.id, U.username,U.password, P.tipo_id FROM st_usuario U "
//                    . " inner join st_persona P on U.persona_id=P.id"
//                    . " WHERE U.id= '$id' and U.password='$password' and U.estado='1'";
                    
            //$result = mysqli_query($cn,$query) or die(mysqli_errno($cn).": ".mysqli_error($cn));
            //return mysqli_fetch_array($result); 
            
            $query = "SELECT [DB_Aliada_Production].[ONCO].[SF_CLAVE]('$clave') as clave";
            $result = sqlsrv_query($conn,$query) or die("Error x2: Usuario<br>".sqlsrv_errno($conn).': '.sqlsrv_error($conn));

            return sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
            
        $this->CerrarConexion($result, $cn);          
        
    }
    
    function ObtenerDatosPersonales($persona){
        
        $conn = $this->AbrirConexion();
        
            $query = "select * from [Spring_Produccion].[dbo].[PersonaMast] where Persona='$persona'";
            $result = sqlsrv_query($conn, $query) or die("Error x3: Usuario<br>".sqlsrv_errno($conn).': '.sqlsrv_error($conn));
            
            return sqlsrv_fetch_array($result);
            
            $this->CerrarConexion($result, $conn);
        
    }
    
    function EsAdministrador($persona,$dataUser){
        
        $conn = $this->AbrirConexion();
        
            $query = "SELECT tipo_id FROM dbo.st_persona WHERE PERSONA='$persona'";
            $result = sqlsrv_query($conn,$query) or die("Error x4: Usuario<br>".sqlsrv_errno($conn).': '.sqlsrv_error($conn));
        
            return sqlsrv_fetch_array($result);   
            
            $this->CerrarConexion($result, $conn);
            
    }
     
}