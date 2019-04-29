<?php

include_once('../st_ModuloSeguridad/Conexion.php');
class TicketEntity extends Conexion{
    
    public function ConsultaBase(){
        
        $q = "SELECT T.id, T.codigo, T.asunto, T.descripcion, T.estado_id, T.registrado_por_usuario_id, ISNULL(P.Nombres, NULL) as registrado_por, T.ip_registro, T.fechaRegistro, T.asignado_a_usuario_id, ISNULL(P2.Nombres,NULL) as asignado_a, T.fechaAsignado, T.asignado_por_usuario_id, ISNULL(P3.Nombres,NULL) as asignado_por, T.fechaAsignado, T.atendido_por_usuario_id, ISNULL(P4.Nombres,NULL) as atendido_por, T.fechaAtendido, T.confirmado_por_usuario_id, ISNULL(P5.Nombres,NULL) as confirmado_por, T.fechaConfirmado, L.title as lugar, DATEDIFF(SECOND, T.fechaRegistro,T.fechaAtendido) as tiempo_solucion 
                        FROM st_ticket T
                            left join [ONCO].[SYS_USUARIOS] U on T.registrado_por_usuario_id = U.USUARIO
                            left join [Spring_Produccion].[dbo].[PersonaMast] P on U.PERSONA = P.Persona --registrado por
                            left join [ONCO].[SYS_USUARIOS] U2 on T.asignado_a_usuario_id=U2.USUARIO
                            left join [Spring_Produccion].[dbo].[PersonaMast] P2 on U2.PERSONA = P2.Persona --asignado a
                            left join [ONCO].[SYS_USUARIOS] U3 on T.asignado_por_usuario_id = U3.USUARIO
                            left join [Spring_Produccion].[dbo].[PersonaMast] P3 on U3.PERSONA = P3.Persona --asignado por
                            left join [ONCO].[SYS_USUARIOS] U4 on T.atendido_por_usuario_id = U4.USUARIO
                            left join [Spring_Produccion].[dbo].[PersonaMast] P4 on U4.PERSONA = P4.Persona --atendido por
                            left join [ONCO].[SYS_USUARIOS] U5 on T.confirmado_por_usuario_id = U5.USUARIO
                            left join [Spring_Produccion].[dbo].[PersonaMast] P5 on U5.PERSONA = P5.Persona --confirmado por
                                inner join st_lugar L on T.lugar_id=L.id";
        
        return $q;
        
    }
    
    public function ObtenerTickets(){
        
        $conn = $this->AbrirConexion();
            $query = $this->ConsultaBase()." order by T.fechaRegistro DESC";
            //$result = mysqli_query($Conexion, $query) or die(mysqli_errno($Conexion).": ". mysqli_error($Conexion));
            $result = sqlsrv_query($conn,$query) or die('Error x1: TicketEntity');
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
        
        $usuario = $dataUser['USUARIO'];
        
        $conn = $this->AbrirConexion();
        
            $query= $this->ConsultaBase()." where T.registrado_por_usuario_id='$usuario' order by T.fechaRegistro DESC";
            //$result = mysqli_query($cn, $query) or die(mysqli_errno($cn).': '.mysqli_error($cn));
            $result = sqlsrv_query($conn,$query) or die('Error x2: TicketEntity');
            
            return $this->ObtenerTicketsData($result);
        
        $this->CerrarConexion($result, $conn);
    }
    
    public function RegistrarTicket($data,$dataUser){
        
        $asunto         = $data['asunto'];
        $descripcion    = $data['descripcion'];
        //$usuario_id     = $dataUser['usuario_id'];
        $usuario        = $dataUser['USUARIO'];
        //$persona        = $dataUser['PERSONA'];
        $lugar_id       = $data['lugar_id'];
        $ip             = $data['ip'];
        $hostname       = $data['hostname'];
        $os             = $data['so'];
       
         //var_dump($data);
//        $nuevo = htmlspecialchars("<a href='test'>Test</a>", ENT_QUOTES);
//        echo $nuevo; // &lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;
        
        $conn = $this->AbrirConexion();
            $query = "INSERT INTO st_ticket (asunto,descripcion,registrado_por_usuario_id,lugar_id,ip_registro,hostname_registro,so_registro,fechaRegistro)
                     VALUES ('$asunto','$descripcion','$usuario','$lugar_id','$ip','$hostname','$os',getdate())";
            //$result = mysqli_query($Conexion, $query) or die(mysqli_errno($Conexion).": ".mysqli_error($Conexion));
            $result = sqlsrv_query($conn,$query) or die("Error x3: TicketEntity: ");
            
            $ticket_id = sqlsrv_query($conn,"SELECT TOP 1 T.id FROM st_ticket T order by T.fechaRegistro desc");
            
            $ticket_id = (sqlsrv_fetch_array($ticket_id));
            
            return $ticket_id['id'];
            
            $this->CerrarConexion($result, $conn);
        
    }
    public function RegistrarCodigo($ticket_id){
        
        $codigo = "Aliada-".$ticket_id;
        
        $conn = $this->AbrirConexion();
           $query = "UPDATE st_ticket set codigo='$codigo' where id='$ticket_id'";
           //$result = mysqli_query($Conexion, $query) or die(mysqli_errno($Conexion).": ".mysqli_error($Conexion));
           $result = sqlsrv_query($conn, $query) or die("Error x10: TicketEntity");
           
           return $codigo;

        $this->CerrarConexion($result, $conn);
        
    }    
    
    public function DetalleTicket($ticket_id,$dataUser){
        
        $conn = $this->AbrirConexion();
            $query = $this->ConsultaBase()." WHERE T.id='$ticket_id'";
            //$result = mysqli_query($cn, $query) or die(mysqli_errno($cn).": ".mysqli_error($cn));
            
            $result = sqlsrv_query($conn,$query) or die("Error x4: TicketEntity");
        
            return sqlsrv_fetch_array($result);
            
        $this->CerrarConexion($result, $conn);
        
    }
    
    public function ObtenerComentariosTicket($ticket_id,$dataUser){
        
        $conn = $this->AbrirConexion();
            $query = "SELECT C.comentario, C.fechaRegistro, P.ApellidoPaterno, P.Nombres, C.usuario_id,U.PERSONA, ISNULL(P1.tipo_id,NULL) as tipo_id
                        FROM st_comentario C
                                inner join [ONCO].[SYS_USUARIOS] U on C.usuario_id=U.USUARIO
                                inner join [Spring_Produccion].[dbo].[PersonaMast] P ON U.PERSONA=P.Persona
                                            left join [dbo].[st_persona] P1 on U.PERSONA=P1.PERSONA
                                    WHERE C.ticket_id='$ticket_id'
                                        ORDER BY C.fechaRegistro DESC";
            //$result = mysqli_query($cn,$query) or die(mysqli_errno($cn).': '.mysqli_error($cn));
            $result = sqlsrv_query($conn,$query) or die("Error x5: TicketEntity");
            
              $i=0;
              $data=NULL;
              while($comentario = sqlsrv_fetch_array($result)){
                  $data[$i]['comentario']     = $comentario['comentario'];
                  $data[$i]['fechaRegistro']  = date_format($comentario['fechaRegistro'], "Y-m-d H:i:s") ;
                  $data[$i]['nombre']         = utf8_decode($comentario['Nombres']);
                  $data[$i]['apellido']       = utf8_decode($comentario['ApellidoPaterno']);
                  $data[$i]['usuario_id']     = $comentario['usuario_id'];
                  $data[$i]['PERSONA']        = $comentario['PERSONA'];
                  $data[$i]['tipo_id']        = $comentario['tipo_id'];
                  $i++;
              }
                                          
            return ($data);
            
        $this->CerrarConexion($result, $conn);    
        
    }

    function RegistrarComentario($data,$dataUser){

        $conn = $this->AbrirConexion();
            //TABLA ESTADOREGISTRO
            //1:  Activo
            //32: Inactivo
            //$comentario = mysql_real_escape_string($data['comentario']);
            $comentario = addslashes($data['comentario']);
            $usuario_id = $dataUser['USUARIO'];
            $ticket_id  = $data['ticket_id'];

            $query = "INSERT INTO st_comentario (comentario, estado_id, fechaRegistro, ticket_id, usuario_id) values ('$comentario','1',GETDATE(),'$ticket_id','$usuario_id')";
            //$result = mysqli_query($cn,$query) or die(mysqli_errno($cn).': '.mysqli_error($cn));
            $result = sqlsrv_query($conn,$query) or die("Error x6: TicketEntity");
            
            return $result;

        $this->CerrarConexion($result,$conn);    

    }
    
    function ObtenerAdministradores(){
        
        $conn = $this->AbrirConexion();

            $query = "SELECT U.USUARIO, U.PERSONA, P.Nombres as admin FROM [ONCO].[SYS_USUARIOS] U 
                        inner join [Spring_Produccion].[dbo].[PersonaMast] P on U.PERSONA=P.Persona
                        inner join st_persona P1 on U.PERSONA=P1.PERSONA
                                  where P1.tipo_id ='1'";
            $result = sqlsrv_query($conn,$query, array(), array('Scrollable' => 'buffered')) or die("Error x5");
            //$result = mysqli_query($cn,$query) or die(mysqli_errno($cn).': '.mysqli_error($cn));

                //var_dump($result);
                $i=0;
                $data=NULL;
                while ($admin = sqlsrv_fetch_array($result)){
                    $data[$i]['USUARIO']= $admin['USUARIO']; 
                    $data[$i]['id']     = $admin['PERSONA'];
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

            $q_update   ="UPDATE st_ticket SET fechaAsignado=GETDATE(), asignado_a_usuario_id='$admin_id', asignado_por_usuario_id='$usuario_id',estado_id='29'
                        WHERE id='$ticket_id'";

            $q_null   = "UPDATE st_ticket SET fechaAsignado=GETDATE(), asignado_a_usuario_id=NULL, asignado_por_usuario_id='$usuario_id',estado_id='28'
                        WHERE id='$ticket_id'";            
            //$result = mysqli_query($cn, $query) or die(mysqli_errno($cn).': '.mysqli_error($cn));
           
            $query = ($admin_id!='0')?$q_update:$q_null;
            $result = sqlsrv_query($conn,$query) or die('Error x7: TicketEntity');
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
        
        $ticket_id          = $data['ticket_id'];
        $usuario_id         = $data['usuario_id'];
        $hostname_atendido  = $data['hostname'];
        $so_atendido        = $data['so'];
        $ip_atendido        = $data['ip'];
        
        $conn = $this->AbrirConexion();
        
            $query = "UPDATE st_ticket set estado_id='30', fechaAtendido=GETDATE(), atendido_por_usuario_id='$usuario_id',hostname_atendido='$hostname_atendido', so_atentido='$so_atendido', ip_atendido='$ip_atendido'
                        where id='$ticket_id'";            
            
            //$result = mysqli_query($cn, $query) or die(mysqli_errno($cn).': '.mysqli_error($error));            
            $result = sqlsrv_query($conn,$query)or die('Error x8: TicketEntity');
            return $result;
            
        $this->CerrarConexion($result, $conn);        
        
    }
    
    function NegarSolucionTicket($data,$dataUser){
        
        $codigo     = $data['codigo'];
        $ticket_id  = $data['ticket_id'];
        $asunto     = $data['asunto'];
        $descripcion= $data['descripcion'];
        
        $usuario_id         = $data['usuario_id'];        
        $hostname_negado    = $data['hostname'];
        $so_negado          = $data['so'];
        $ip_negado          = $data['ip'];
        
        $conn = $this->AbrirConexion();
        
            //$query = "INSERT INTO st_ticket(codigo,asunto,descripcion,estado_id,ip_negado,fechaNegado,negado_por_usuario_id,hostname_negado,so_negado) values ('$codigo','$asunto','$descripcion','2','$ip_negado',now(),'$usuario_id','$hostname_negado','$so_negado')";
            //al insertar el nuevo id, tiene los datos del codigo con un estado 
            $query = "UPDATE st_ticket set estado_id='29 ',ip_negado='$ip_negado',fechaNegado=GETDATE(),negado_por_usuario_id='$usuario_id',hostname_negado='$hostname_negado',so_negado='$so_negado' where id='$ticket_id'";
            //$result = mysqli_query($cn, $query) or die(mysqli_errno($cn).': '.mysqli_error($cn));
            $result = sqlsrv_query($conn,$query) or die("Error x11: TicketEntity");
            return $result;
        
            $this->CerrarConexion($result, $conn);
    }    
    
    function TicketResuelto($data,$dataUser){
        
        //var_dump($data);
        
        $usuario_id     = $data['usuario_id'];        
        $ticket_id      = $data['ticket_id'];
        $hostname_confirmado = $data['hostname'];
        $so_confirmado  = $data['so'];
        $ip_confirmado  = $data['ip'];
        
        $conn = $this->AbrirConexion();
        
            $query = "UPDATE st_ticket SET estado_id='31', ip_confirmado='$ip_confirmado', fechaConfirmado=GETDATE(), confirmado_por_usuario_id='$usuario_id',hostname_confirmado='$hostname_confirmado',so_confirmado='$so_confirmado'
                        WHERE id='$ticket_id'";
            //$result = mysqli_query($cn, $query) or die(mysqli_errno($cn).': '.mysqli_error($cn));
            $result = sqlsrv_query($conn,$query) or die('Error x9: TicketEntity');
            return $result;
            
        $this->CerrarConexion($result, $conn);
    
        
    }
    
    function ObtenerArchivosAdjuntos($ticket_id){
        
        $conn = $this->AbrirConexion();
        
            $query = "SELECT nombre, url_file, size_kb, extension from st_file WHERE ticket_id='$ticket_id'";
            //$result = mysqli_query($cn, $query) or die(mysqli_errno($cn).': '.mysqli_error($cn));
            $result = sqlsrv_query($conn,$query, array(), array('Scrollable' => 'buffered')) or die('Error x12: TicketEntity');
            
            if(sqlsrv_num_rows($result)>0){
                $i=0;
                while($file = sqlsrv_fetch_array($result)){
                    $data[$i]['nombre']     = $file['nombre'];
                    $data[$i]['url_file']   = $file['url_file'];
                    $data[$i]['size_kb']    = $file['size_kb'];
                    $data[$i]['extension']  = $file['extension'];
                    $i++;
                }                
            }else{
                $data = NULL;
            }
            
            
            return ($data);
            
        $this->CerrarConexion($result, $conn);        
        
    }
    
    function ObtenerTicketsData($result){   
    
        
        $i = 0;
        while($r=sqlsrv_fetch_array($result)){
            $data[$i]['id']                 = $r['id'];
            $data[$i]['codigo']             = $r['codigo'];
            $data[$i]['asunto']             = $r['asunto'];
            $data[$i]['descripcion']        = $r['descripcion'];
            $data[$i]['estado_id']          = $r['estado_id'];
            $data[$i]['registrado_por_usuario_id'] = !isset($r['registrado_por usuario_id'])?:$r['registrado_por usuario_id'];
            $data[$i]['fechaRegistro']      = date_format($r['fechaRegistro'],"Y-m-d H:i:s");
            $data[$i]['fechaAtendido']      = isset($r['fechaAtendido'])?date_format($r['fechaAtendido'],"Y-m-d H:i:s"):NULL;
            $data[$i]['asignado_a_usuario_id'] = $r['asignado_a_usuario_id'];
            $data[$i]['asignado_a']      = $r['asignado_a'];
            $data[$i]['asignado_por']    = $r['asignado_por'];
            $data[$i]['atendido_por']    = $r['atendido_por'];
            $data[$i]['confirmado_por']  = $r['confirmado_por'];
            $data[$i]['registrado_por']  = !isset($r['registrado_por'])?:$r['registrado_por'];
            $data[$i]['lugar']           = !isset($r['lugar'])?:$r['lugar'];
            $data[$i]['tiempo_solucion'] = $r['tiempo_solucion'];
            
            $i++;
        }
        
        return isset($data)?$data:NULL;
                
    }  
    
}
