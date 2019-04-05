<?php

include_once('../st_ModuloSeguridad/Conexion.php');
class TicketEntity extends Conexion{
    
    public function ObtenerTickets(){
        
        $conn = $this->AbrirConexion();
        
            $query = "SELECT T.id, T.codigo, T.asunto, T.estado_id, T.registrado_por_usuario_id,T.fechaRegistro,T.fechaAtendido, T.asignado_a_usuario_id, ISNULL(P.nombre, (P.nombre)) as administrador, (PE.nombre) as autor, L.title as lugar
                        FROM st_ticket T
                            left join st_usuario U on T.asignado_a_usuario_id=U.id
                            left join st_persona P on P.id=U.persona_id
                            left join st_usuario US on T.registrado_por_usuario_id=US.id
                            left join st_persona PE on PE.id=US.persona_id
                            inner join st_lugar L on T.lugar_id=L.id
                                                ORDER BY T.fechaRegistro DESC";
            //$result = mysqli_query($Conexion, $query) or die(mysqli_errno($Conexion).": ". mysqli_error($Conexion));
            $result = sqlsrv_query($conn,$query) or die('Error x1 ');
            if($result===false){
                if( ($errors = sqlsrv_errors() ) != null) {
                    foreach( $errors as $error ) {
                        echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                        echo "code: ".$error[ 'code']."<br />";
                        echo "message: ".$error[ 'message']."<br />";
                    }
                }
            }
            
            return $this->ObtenerTicketsData($result);
            
        $this->CerrarConexion($result, $conn);    
        
    } 
    
    public function ObtenerTicketsUsuario($dataUser){
        
        $usuario_id = $dataUser['usuario_id'];
        
        $conn = $this->AbrirConexion();
        
            $query="SELECT T.id,T.codigo,T.asunto,T.estado_id,T.registrado_por_usuario_id,T.fechaRegistro, T.fechaAtendido, T.asignado_a_usuario_id, ISNULL(P.nombre, (P.nombre)) as administrador
                        FROM st_ticket T
                            left join st_usuario U on T.asignado_a_usuario_id=U.id
                            left join st_persona P on P.id=U.persona_id
                            where registrado_por_usuario_id='$usuario_id' order by T.fechaRegistro DESC";
            //$result = mysqli_query($cn, $query) or die(mysqli_errno($cn).': '.mysqli_error($cn));
            $result = sqlsrv_query($conn,$query) or die('Error x2 ');
            
            return $this->ObtenerTicketsData($result);
        
        $this->CerrarConexion($result, $conn);
    }
    
    public function RegistrarTicket($data,$dataUser){
        
        $asunto         = $data['asunto'];
        $descripcion    = $data['descripcion'];
        $usuario_id     = $dataUser['usuario_id'];
        $lugar_id       = $data['lugar_id'];
        $ip             = $data['ip'];
        $hostname       = $data['hostname'];
        $os             = $data['so'];
       
         //var_dump($data);
        
        $conn = $this->AbrirConexion();
            $query = "INSERT INTO st_ticket (asunto,descripcion,registrado_por_usuario_id,lugar_id,ip_registro,hostname_registro,so_registro,fechaRegistro)"
                    . " VALUES ('$asunto','$descripcion','$usuario_id','$lugar_id','$ip','$hostname','$os',getdate())";
            //$result = mysqli_query($Conexion, $query) or die(mysqli_errno($Conexion).": ".mysqli_error($Conexion));
            $result = sqlsrv_query($conn,$query) or die("Error x3");
            return $result;
            
            $this->CerrarConexion($result, $conn);
        
    }
    
    public function DetalleTicket($ticket_id,$dataUser){
        
        $conn = $this->AbrirConexion();
            $query = "SELECT T.id,T.codigo,T.asunto,T.descripcion,T.ip_registro, T.estado_id, T.fechaRegistro,T.fechaAsignado, T.fechaAtendido, L.title as lugar, P.nombre as autor, T.asignado_a_usuario_id, PE.nombre as administrador, T.atendido_por_usuario_id, PER.nombre as administrador_atendio  FROM st_ticket T
                        left join st_usuario U on T.registrado_por_usuario_id=U.id
                        left join st_persona P on U.persona_id=P.id
                        left join st_usuario US on T.asignado_a_usuario_id=US.id
                        left join st_persona PE on US.persona_id=PE.id
                        left join st_usuario USU on T.atendido_por_usuario_id=USU.id
                        left join st_persona PER on USU.persona_id=PER.id                        
                        left join st_lugar L on T.lugar_id=L.id
                            WHERE T.id='$ticket_id'";
            //$result = mysqli_query($cn, $query) or die(mysqli_errno($cn).": ".mysqli_error($cn));
            
            $result = sqlsrv_query($conn,$query) or die("Error x4");
            
            
            
            return sqlsrv_fetch_array($result);
            
        $this->CerrarConexion($result, $conn);
        
    }
    
    public function ObtenerComentariosTicket($ticket_id,$dataUser){
        
        $conn = $this->AbrirConexion();
            $query = "SELECT C.comentario,C.fechaRegistro,P.nombre, P.apellido, P.tipo_id FROM st_comentario C 
                        inner join st_usuario U on C.usuario_id=U.id
                        inner join st_persona P on U.persona_id=P.id
                            where C.ticket_id='$ticket_id'
                            order by C.fechaRegistro Desc";
            //$result = mysqli_query($cn,$query) or die(mysqli_errno($cn).': '.mysqli_error($cn));
            $result = sqlsrv_query($conn,$query) or die("Error x5");
            
              $i=0;
              $data=NULL;
              while($comentario = sqlsrv_fetch_array($result)){
                  $data[$i]['comentario']     = $comentario['comentario'];
                  $data[$i]['fechaRegistro']  = date_format($comentario['fechaRegistro'], "Y-m-d H:i:s") ;
                  $data[$i]['nombre']         = utf8_decode($comentario['nombre']);
                  $data[$i]['apellido']       = utf8_decode($comentario['apellido']);
                  $data[$i]['tipo_id']        = utf8_decode($comentario['tipo_id']);
                  $i++;
              }
                              
            
            return ($data);
            
        $this->CerrarConexion($result, $conn);    
        
    }

    function RegistrarComentario($data,$dataUser){

        $conn = $this->AbrirConexion();

            //$comentario = mysql_real_escape_string($data['comentario']);
            $comentario = $data['comentario'];
            $usuario_id = $data['usuario_id'];
            $ticket_id  = $data['ticket_id'];

            $query = "INSERT INTO st_comentario (comentario, ticket_id, usuario_id) values ('$comentario','$ticket_id','$usuario_id')";
            //$result = mysqli_query($cn,$query) or die(mysqli_errno($cn).': '.mysqli_error($cn));
            $result = sqlsrv_query($conn,$query) or die("Error x6");
            
            return $result;

        $this->CerrarConexion($result,$conn);    

    }
    
    function ObtenerAdministradores(){
        
        $conn = $this->AbrirConexion();

            $query = "SELECT U.id, P.nombre as admin FROM st_usuario U 
                        inner join st_persona P on U.persona_id=P.id
                        where P.tipo_id='1'";
            $result = sqlsrv_query($conn,$query) or die("Error x5");
            //$result = mysqli_query($cn,$query) or die(mysqli_errno($cn).': '.mysqli_error($cn));

                //var_dump($result);
                $i=0;
                $data=NULL;
                while ($admin = sqlsrv_fetch_array($result)){
                    $data[$i]['id']     = $admin['id'];
                    $data[$i]['admin']  = $admin['admin'];
                    $i++;
                }
                            
            return $data;

        $this->CerrarConexion($result,$conn);         
        
    }
    
    function AsignarAdministradorATicket($data,$dataUser){
        
        $admin_id   = $data['admin_id'];
        $usuario_id = $data['usuario_id'];
        $ticket_id  = $data['ticket_id'];
        
        $conn = $this->AbrirConexion();
            
            $q_update   ="UPDATE st_ticket  SET fechaAsignado=GETDATE(), asignado_a_usuario_id='$admin_id', asignado_por_usuario_id='$usuario_id',estado_id='2'
                        WHERE id='$ticket_id'";
            
            $q_null     ="UPDATE st_ticket SET fechaAsignado=GETDATE(), asignado_a_usuario_id=NULL, asignado_por_usuario_id='$usuario_id',estado_id='1'
                        WHERE id='$ticket_id'";            
            
            $query = ($admin_id==0)?$q_null:$q_update;

            //$result = mysqli_query($cn, $query) or die(mysqli_errno($cn).': '.mysqli_error($cn));
            $result = sqlsrv_query($conn,$query) or die('Error x7');
            return $result;
            
        $this->CerrarConexion($result, $conn);
    }
    
    function ObtenerDatosPersonalesAdministratorAsignado($ticket_id){
        
        $cn = $this->AbrirConexion();
        
            $query = "SELECT U.id,P.nombre, P.apellido, P.tipo_id, T.fechaAsignado, T.fechaAtendido, T.estado_id FROM st_persona P 
                        INNER JOIN st_usuario U ON P.id=U.persona_id
                        INNER JOIN st_ticket T ON U.id=T.asignado_a_usuario_id
                            WHERE T.id='$ticket_id'";
            $result = mysqli_query($cn,$query) or die(mysqli_errno($cn).": ".mysqli_error($cn));
            
            return mysqli_fetch_array($result); 
        
        $this->CerrarConexion($result, $cn);       
    }
    
    function MarcarComoResuelto($data,$dataUser){
        
        $ticket_id = $data['ticket_id'];
        $usuario_id = $data['usuario_id'];
        $hostname_atendido = $data['hostname_atendido'];
        $so_atendido    = $data['so_atendido'];
        
        $conn = $this->AbrirConexion();
        
            $query = "UPDATE st_ticket set estado_id='3', fechaAtendido=GETDATE(), atendido_por_usuario_id='$usuario_id',hostname_atendido='$hostname_atendido', so_atentido='$so_atendido'
                        where id='$ticket_id'";            
            
            //$result = mysqli_query($cn, $query) or die(mysqli_errno($cn).': '.mysqli_error($error));            
            $result = sqlsrv_query($conn,$query)or die('Error x8');
            return $result;
            
        $this->CerrarConexion($result, $conn);        
        
    }
    
    function TicketResuelto($data,$dataUser){
        
        //var_dump($data);
        
        $usuario_id     = $data['usuario_id'];        
        $ticket_id      = $data['ticket_id'];
        $hostname_confirmado = $data['hostname_confirmado'];
        $so_confirmado  = $data['so_confirmado'];
        $ip_confirmado  = $data['ip_confirmado'];
        
        $conn = $this->AbrirConexion();
        
            $query = "UPDATE st_ticket SET estado_id='4', ip_confirmado='$ip_confirmado', fechaConfirmado=GETDATE(), confirmado_por_usuario_id='$usuario_id',hostname_confirmado='$hostname_confirmado',so_confirmado='$so_confirmado'
                        WHERE id='$ticket_id'";
            //$result = mysqli_query($cn, $query) or die(mysqli_errno($cn).': '.mysqli_error($cn));
            $result = sqlsrv_query($conn,$query) or die('Error x9');
            return $result;
            
        $this->CerrarConexion($result, $conn);
    
        
    }
    
    function ObtenerTicketsData($result){   
    
        $i = 0;
        while($r=sqlsrv_fetch_array($result)){
            $data[$i]['id']                 = $r['id'];
            $data[$i]['codigo']             = $r['codigo'];
            $data[$i]['asunto']             = $r['asunto'];
            $data[$i]['estado_id']          = $r['estado_id'];
            $data[$i]['registrado_por_usuario_id'] = !isset($r['registrado_por usuario_id'])?:$r['registrado_por usuario_id'];
            $data[$i]['fechaRegistro']      = date_format($r['fechaRegistro'],"Y-m-d H:i:s");
            $data[$i]['fechaAtendido']      = isset($r['fechaAtendido'])?date_format($r['fechaAtendido'],"Y-m-d H:i:s"):NULL;
            $data[$i]['asignado_a_usuario_id'] = $r['asignado_a_usuario_id'];
            $data[$i]['administrador']      = $r['administrador'];
            $data[$i]['autor']              = !isset($r['autor'])?:$r['autor'];
            $data[$i]['lugar']              = !isset($r['lugar'])?:$r['lugar'];
            
            $i++;
        }
        
        return $data;
                
    }  
    
}
