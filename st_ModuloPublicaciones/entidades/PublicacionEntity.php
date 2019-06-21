<?php
include_once('../st_ModuloSeguridad/Conexion.php');
class PublicacionEntity extends Conexion{
    
    function ObtenerRegistros(){
        
        $conn = $this->AbrirConexion();
        
            $query = "";
            $result = sqlsrv_query($conn,$query, array(), array('Scrollable' => 'buffered')) or die('Error x2: ');
            
            //var_dump(($result));
            
            $i=0;
            $data=NULL;
            while($carta = sqlsrv_fetch_array($result)){
//                $data[$i]['id']             = $carta['id'];
//                $data[$i]['usuario']        = $carta['usuario'];
//                $data[$i]['paciente']       = utf8_encode($carta['paciente']);
//                $data[$i]['nombrePaciente'] = utf8_encode($carta['nombre_paciente']) ;
//                $data[$i]['IdEmpresaAseguradora']  = utf8_decode($carta['IdEmpresaAseguradora']);
//                $data[$i]['aseguradora']    = ($carta['nombre_aseguradora']);
//                $data[$i]['tratamiento']    = utf8_decode($carta['tratamiento']);
//                $data[$i]['fechaRegistro']  = date_format($carta['fechaRegistro'],"Y-m-d H:i:s");
//                $data[$i]['nrocarta']       = utf8_decode($carta['nrocarta']);
//                $data[$i]['tratamiento']    = utf8_decode($carta['tratamiento']);
//                $data[$i]['estado']         = utf8_decode($carta['estado']);
//                $data[$i]['fechaAprobado']  = is_null($carta['fechaAprobado'])?'':date_format($carta['fechaAprobado'],"Y-m-d H:i:s");
//                $data[$i]['estado_id']      = $carta['estado_id'];
//                $data[$i]['esUrgente']      = $carta['esUrgente'];
//                $data[$i]['tiempo_aprobacion']= $carta['tiempo_aprobacion'];
                //$data[$i]['esUrgenteCheck'] = $carta['esUrgente'];
                $i++;
            }
            
            return $data;
            
        $this->DestruirDatos($result);
        $this->CerrarConexion($conn);
        
    }
    
    public function RegistrarPublicacion($data,$dataUser){
        
        $titulo         = $data['titulo'];
        $titulo_url     = $data['titulo_url'];
        $descripcion    = $data['descripcion'];
        $estado_id      = $data['estado_id'];
        
        $hostname_registro  = $data['hostname'];
        $ip_registro        = $data['ip'];
        $so_registro        = $data['so'];
        $usuario_registro   = $data['usuario_id'];
        
        $conn = $this->AbrirConexion();
        
            $query = "INSERT INTO [DB_Aliada_Production].dbo.st_publicacion (titulo,titulo_url,descripcion,estado_id,fecha_registro,hostname_registro,ip_registro,so_registro, registrado_por_usuario_id)
                        values ('$titulo','$titulo_url','$descripcion','$estado_id',GETDATE(),'$hostname_registro','$ip_registro','$so_registro', '$usuario_registro')";
            $result = sqlsrv_query($conn,$query, array(), array('Scrollable' => 'buffered')) or die('Error x2: ');
        
            $ticket_id = sqlsrv_query($conn,"SELECT TOP 1 T.id FROM st_ticket T order by T.fechaRegistro desc");
            
            $ticket_id = (sqlsrv_fetch_array($ticket_id));
            
            return $ticket_id['id'];
            
            $this->CerrarConexion($result, $conn);
            
            }
    
}