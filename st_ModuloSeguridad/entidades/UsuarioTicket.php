<?php

include_once('../st_ModuloSeguridad/Conexion.php');
class UsuarioTicket extends Conexion {
    
    var $estado = "28','29','30','31";
    
//    function getEstados(){
//        return $this->estado;
//    }
    
    function ObtenerResumenTickets($dataUser){
        
        $sistema_id = $dataUser['t'];
        
        $conn = $this->AbrirConexion();
        
            $query = "SELECT E.ESTADO_REGISTRO as id, E.descripcion, (select count(*) from dbo.st_ticket T where T.estado_id=E.ESTADO_REGISTRO and T.sistema_id in ('$sistema_id')) as cantidad from [ONCO].[SYS_ESTADO_REGISTRO] E where E.ESTADO_REGISTRO IN('$this->estado')";
            //$result = mysqli_query($cn,$query) or die(mysqli_errno($cn).": ".mysqli_error($cn));
            $result = sqlsrv_query($conn,$query) or die("Error x1: UsuarioTicket");
                        
            return $this->Datos($result);
            
        $this->CerrarConexion($result, $conn);
    }
    
    function ObtenerTicketsDeUsuario($dataUser){
        
        $usuario = $dataUser['USUARIO'];
        
        $conn = $this->AbrirConexion();
            $query = "
SELECT E.ESTADO_REGISTRO as id, E.descripcion, (select count(*) from dbo.st_ticket T where T.estado_id=E.ESTADO_REGISTRO and T.registrado_por_usuario_id='$usuario') as cantidad from [ONCO].[SYS_ESTADO_REGISTRO] E where E.ESTADO_REGISTRO IN('$this->estado')";                   
            
            //$result = mysqli_query($cn, $query) or die(mysqli_errno($cn).': '.mysqli_error($cn));
            $result = sqlsrv_query($conn,$query) or die("Error x2: UsuarioTicket");          
                            
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