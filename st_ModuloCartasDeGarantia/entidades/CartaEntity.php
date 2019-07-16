<?php

include_once('../st_ModuloSeguridad/Conexion.php');
class CartaEntity extends Conexion{
    
    var $estado = "4','8','27','33";
    //4:  Pendiente
    //8:  Aprobado
    //27: Observado
    //33: Rechazado
    function Registrar($data){
       
        $conn = $this->AbrirConexion();
       
            $usuario        = $data['usuario'];
            $paciente       = $data['paciente'];
            $nombrePaciente = $data['nombrePaciente'];
            $IdEmpresaAseguradora=$data['IdEmpresaAseguradora'];
            $aseguradora    = $data['aseguradora'];
            $fechaRegistro  = $data['fechaRegistro'];
            $fechaAprobado  = $data['fechaAprobado'];
            $estado_id      = $data['estado_id'];
            $nrocarta       = $data['nrocarta'];    
            $tratamiento    = $data['tratamiento'];
            $esUrgente      = $data['esUrgente'];
            $CodigoOA     = $data['CodigoOA'];

            if($fechaAprobado==NULL){
                $query = "INSERT INTO st_carta (usuario,paciente,nombrePaciente,IdEmpresaAseguradora,aseguradora,fechaRegistro,fechaAprobado,estado_id,nrocarta,tratamiento, esUrgente, CodigoOA,fecha) VALUES 
                    ('$usuario','$paciente','$nombrePaciente','$IdEmpresaAseguradora','$aseguradora','$fechaRegistro',NULL,'$estado_id','$nrocarta','$tratamiento','$esUrgente','$CodigoOA',GETDATE())";                
            }else{
                $query = "INSERT INTO st_carta (usuario,paciente,nombrePaciente,IdEmpresaAseguradora,aseguradora,fechaRegistro,fechaAprobado,estado_id,nrocarta,tratamiento, esUrgente, CodigoOA,fecha) VALUES 
                    ('$usuario','$paciente','$nombrePaciente','$IdEmpresaAseguradora','$aseguradora','$fechaRegistro','$fechaAprobado','$estado_id','$nrocarta','$tratamiento','$esUrgente','$CodigoOA',GETDATE())";                
            }
            //echo $query;
            $result = sqlsrv_query($conn,$query) or die('Error x1: CartaEntity');
            
            return $result;
            
        $this->DestruirDatos($result);
        $this->CerrarConexion($conn);
    }
    
    function ObtenerRegistros(){
        
        $conn = $this->AbrirConexion();
        
            $query = "SELECT C.*, ER.DESCRIPCION as estado,A.NombreCompleto as nombre_aseguradora, P.NombreCompleto as nombre_paciente, DATEDIFF(MINUTE, C.fechaRegistro, C.fechaAprobado) as tiempo_aprobacion
                        FROM st_carta C
                            inner join [ONCO].[SYS_ESTADO_REGISTRO] ER on C.estado_id=ER.ESTADO_REGISTRO
                            inner JOIN Spring_Produccion.dbo.PersonaMast A ON A.Persona = C.IdEmpresaAseguradora
                            inner JOIN Spring_Produccion.dbo.PersonaMast P ON P.Persona = C.paciente
                                WHERE ESTADO_REGISTRO IN ('$this->estado')
                                    order by C.fecha desc";
            $result = sqlsrv_query($conn,$query, array(), array('Scrollable' => 'buffered')) or die('Error x2: ');
            
            //var_dump(($result));
            
            $i=0;
            $data=NULL;
            while($carta = sqlsrv_fetch_array($result)){
                $data[$i]['id']             = $carta['id'];
                $data[$i]['usuario']        = $carta['usuario'];
                $data[$i]['paciente']       = $carta['paciente'];
                $data[$i]['nombrePaciente'] = ($carta['nombre_paciente']) ;
                $data[$i]['IdEmpresaAseguradora']  = utf8_decode($carta['IdEmpresaAseguradora']);
                $data[$i]['aseguradora']    = ($carta['nombre_aseguradora']);
                $data[$i]['tratamiento']    = utf8_decode($carta['tratamiento']);
                $data[$i]['fechaRegistro']  = date_format($carta['fechaRegistro'],"Y-m-d H:i:s");
                $data[$i]['nrocarta']       = utf8_decode($carta['nrocarta']);
                $data[$i]['tratamiento']    = utf8_decode($carta['tratamiento']);
                $data[$i]['estado']         = utf8_decode($carta['estado']);
                $data[$i]['fechaAprobado']  = is_null($carta['fechaAprobado'])?'':date_format($carta['fechaAprobado'],"Y-m-d H:i:s");
                $data[$i]['estado_id']      = $carta['estado_id'];
                $data[$i]['esUrgente']      = $carta['esUrgente'];
                $data[$i]['tiempo_aprobacion']= $carta['tiempo_aprobacion'];
                //$data[$i]['esUrgenteCheck'] = $carta['esUrgente'];
                $i++;
            }
            
            return $data;
            
        $this->DestruirDatos($result);
        $this->CerrarConexion($conn);
        
    }
    
    function BuscarPaciente($codigo,$dataUser){
        
        $conn = $this->AbrirConexion();
        
            $query = "exec DB_Aliada_Production.[ONCO].[SYS_BUSQUEDA_PACIENTE]
                        @VAROPCION=6,@NOMBRE_COMPLETO='$codigo'";
            
            //$stmt = sqlsrv_query( $conn, $sql , $params, $options );            
            $result = sqlsrv_query($conn,$query) or die('Error x3: ');
            
            $i=0;
            while($carta = sqlsrv_fetch_array($result)){
                $data[$i]['persona']        = $carta['Persona'];            
                $data[$i]['td']             = ($carta['TD']);
                $data[$i]['documento']      = ($carta['Documento']);
                $data[$i]['nombre']         = ($carta['Nombre']);
                $data[$i]['sexo']           = $carta['SEXO'];
                $data[$i]['correoelectronico']=  $carta['CorreoElectronico'];
                $data[$i]['historia']       = $carta['Historia'];
                $data[$i]['fechanacimiento']= $carta['FechaNacimiento'];
                $data[$i]['telefono']       =  $carta['Telefono'];
                $data[$i]['edad']           =  $carta['Edad'];
                $i++;
            }               
            return (isset($data)?$data:NULL);
 
        $this->DestruirDatos($result);
        $this->CerrarConexion($conn);   
                    
    }
    
    function BuscarCartasDePaciente($persona){
        $conn = $this->AbrirConexion();
        
//            $query = "SELECT
//                        IdGarantia,
//                        G.FechaInicioGarantia,
//                        IdEmpresaAseguradora,
//                        A.NombreCompleto as aseguradora,
//                        G.EstadoDocumento
//                            FROM Spring_Produccion.dbo.SS_AD_Garantia G
//                                left JOIN Spring_Produccion.dbo.PersonaMast P
//                                        ON P.Persona = G.IdPaciente
//                                left JOIN Spring_Produccion.dbo.PersonaMast A
//                                        ON A.Persona = G.IdEmpresaAseguradora
//                                        where P.Persona ='$persona' 
//                                        order by G.FechaInicioGarantia DESC";
        $query="SELECT
                    OA.CodigoOA,
                    OA.FechaInicio,
                    OA.FechaFinal,
                    IdEmpresaAseguradora,
                    A.NombreCompleto as aseguradora,
                    OA.EstadoDocumento
                        FROM Spring_Produccion.dbo.SS_AD_OrdenAtencion OA 
                            left JOIN Spring_Produccion.dbo.PersonaMast P
                                ON P.Persona = OA.IdPaciente
                            left JOIN Spring_Produccion.dbo.PersonaMast A
                                ON A.Persona = OA.IdEmpresaAseguradora
                                    where P.Persona ='$persona' 
                                        order by OA.FechaInicio DESC";
            $result = sqlsrv_query($conn,$query, array(), array('Scrollable' => 'buffered')) or die('Error x4: ');
            
            //echo '->'.var_dump(sqlsrv_num_rows($result)).'<-';
            if(sqlsrv_num_rows($result)>0){
                $i=0;
                while($carta = sqlsrv_fetch_array($result)){
                    $data[$i]['CodigoOA']             = $carta['CodigoOA'];              
                    $data[$i]['FechaInicio']    = is_null($carta['FechaInicio'])? '': date_format($carta['FechaInicio'],"Y-m-d");
                    $data[$i]['FechaFinal']    = is_null($carta['FechaFinal'])? '': date_format($carta['FechaFinal'],"Y-m-d");
                    $data[$i]['IdEmpresaAseguradora']   = ($carta['IdEmpresaAseguradora']);
                    $data[$i]['aseguradora']            = ($carta['aseguradora']);
                    $i++;                 
                }  
            }else{
                $data=NULL;
            }
             
            return ($data);
 
        $this->DestruirDatos($result);
        $this->CerrarConexion($conn);                       
        
    }
    
    public function ObtenerEstadosDeCartas(){
        //4: Pendiente
        //8: Aprobado
        //27: Observado
        //33: Rechazado
        
        $conn = $this->AbrirConexion();
            
            $query = "SELECT ESTADO_REGISTRO, DESCRIPCION FROM [ONCO].[SYS_ESTADO_REGISTRO]
                            WHERE ESTADO_REGISTRO IN ('$this->estado')";
            $result = sqlsrv_query($conn,$query,array(), array('Scrollable' => 'buffered')) or die('Error x5: ');
     
            //echo sqlsrv_num_rows($result);    
            if(sqlsrv_num_rows($result)>0){
                $i=0;
                while($estado = sqlsrv_fetch_array($result)){
                    $data[$i]['estado_id']   = $estado['ESTADO_REGISTRO'];              
                    $data[$i]['descripcion'] = $estado['DESCRIPCION'];
                    $i++;                 
                }  
            }else{
                $data=NULL;
            }            
            
            return $data;
            
        $this->DestruirDatos($result);
        $this->CerrarConexion($conn);                
            
    }
    
    public function ActualizarEstadoCarta($data,$dataUser){
        
        $nrocarta       = $data['nrocarta'];
        $estado_id      = $data['estado_id'];
        $fechaIngresado = $data['fechaIngresado'];
        $fechaAprobado  = $data['fechaAprobado'];
        $id             = $data['id'];
        $tratamiento    = $data['tratamiento'];
        $esUrgente      = $data['esUrgente'];
        
        $conn = $this->AbrirConexion();
            
            echo $query = "UPDATE st_carta set nrocarta='$nrocarta', estado_id='$estado_id',tratamiento='$tratamiento',esUrgente='$esUrgente', $fechaIngresado,$fechaAprobado where id='$id'";
            $result = sqlsrv_query($conn,$query,array(), array('Scrollable' => 'buffered')) or die('Error x5: ');              
            
            return $result;
            
        $this->DestruirDatos($result);
        $this->CerrarConexion($conn);         

    }
    
    public function ActualizarFechaAprobacionCarta($data, $dataUser){
        
        $id             = $data['id'];
        $fechaAprobado  = $data['fechaAprobacion'];
        $hostname       = $data['hostname'];
        $so             = $data['so'];
        $ip             = $data['ip'];
        $usuario        = $dataUser['USUARIO'];
        $estado_id      = 8;//aprobado
        
        $conn = $this->AbrirConexion();
            
            $query = "UPDATE st_carta set fechaAprobado='$fechaAprobado', usuarioAprobado='$usuario',ipAprobado='$ip',hostnameAprobado='$hostname',soAprobado='$so', fechaRegistroAprobado=GETDATE(), estado_id='$estado_id' where id='$id'";
            $result = sqlsrv_query($conn,$query,array(), array('Scrollable' => 'buffered')) or die('Error x5: ');              
            
            return $result;
            
        $this->DestruirDatos($result);
        $this->CerrarConexion($conn);    
        
        
    }    
    
}