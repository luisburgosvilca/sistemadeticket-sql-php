<?php

include_once('../st_ModuloSeguridad/Conexion.php');
class UsuarioTicket extends Conexion {
    
    function ObtenerResumenTickets($dataUser){
        
        $conn = $this->AbrirConexion();
        
            $query = "SELECT E.id, E.descripcion, (select count(*) from st_ticket T
                                where T.estado_id=E.id) as cantidad from st_estado E";
            //$result = mysqli_query($cn,$query) or die(mysqli_errno($cn).": ".mysqli_error($cn));
            $result = sqlsrv_query($conn,$query);
                        
            return $this->Datos($result);
            
        $this->CerrarConexion($result, $conn);    
    }
    
    function ObtenerTicketsDeUsuario($dataUser){
        
        $usuario_id = $dataUser['usuario_id'];
        
        $conn = $this->AbrirConexion();
            $query = "SELECT E.id, E.descripcion, (select count(*) from st_ticket T
                                where T.estado_id=E.id and T.registrado_por_usuario_id='$usuario_id') as cantidad from st_estado E";                   
            
            //$result = mysqli_query($cn, $query) or die(mysqli_errno($cn).': '.mysqli_error($cn));
            $result = sqlsrv_query($conn,$query) or die(sqlsrv_errno($conn).': '.sqlsrv_error($conn));          
                            
            return $this->Datos($result);
            
        //$this->CerrarConexion($result, $conn);
        
    }
    
    function Datos($result){
        $i = 0;
        while($r=sqlsrv_fetch_array($result)){
            $data[$i]['id']         = $r['id'];
            $data[$i]['descripcion'] = $r['descripcion'];
            $data[$i]['cantidad'] = $r['cantidad'];
            $i++;
        }
        
        return $data;
        
    }
    
}