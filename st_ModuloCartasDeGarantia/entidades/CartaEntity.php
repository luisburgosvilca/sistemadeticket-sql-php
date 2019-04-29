<?php

include_once('../st_ModuloSeguridad/Conexion.php');
class CartaEntity extends Conexion{
    
    function Registrar($data){
       
        $conn = $this->AbrirConexion();
       
            $usuario    = $data['usuario'];
            $nombre     = $data['nombre'];
            $seguro     = $data['seguro'];
            $fecha      = $data['fecha'];
            $estado     = $data['estado'];
            $carta      = $data['carta'];        

            $query = "INSERT INTO cdg_cartas (usuario,nombre,seguro,fecha,estado_id,carta) VALUES ('$usuario','$nombre','$seguro','$fecha','$estado','$carta')";
            $result = sqlsrv_query($conn,$query) or die('Error x1: '. sqlsrv_errno($conn).' - '.sqlsrv_error($conn));
            
            return $result;
            
        $this->DestruirDatos($result);
        $this->CerrarConexion($conn);
    }
    
    function ObtenerRegistros(){
        
        $conn = $this->AbrirConexion();
        
            $query = "SELECT C.*, EC.descripcion as estado FROM cdg_cartas C
                        inner join cdg_estadocarta EC on C.estado_id=EC.id
                            order by fecha desc";
            $result = sqlsrv_query($conn,$query) or die('Error x2: '.sqlsrv_errno($conn).' - '.sqlsrv_error($conn));
            
            $i=0;
            $data=NULL;
            while($carta = sqlsrv_fetch_array($result)){
                $data[$i]['usuario'] = $carta['usuario'];
                $data[$i]['nombre']  = utf8_encode($carta['nombre']) ;
                $data[$i]['seguro']  = utf8_decode($carta['seguro']);
                $data[$i]['fecha']   = date_format($carta['fecha'],"Y-m-d H:i:s");
                $data[$i]['estado_id']  = utf8_decode($carta['estado_id']);
                $data[$i]['estado']  = utf8_decode($carta['estado']);
                $data[$i]['carta']   = utf8_decode($carta['carta']);
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
                $data[$i]['td']             = ($carta['TD']) ;
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
        
            $query = "SELECT
                        IdGarantia,
                        G.FechaInicioGarantia,
                        IdEmpresaAseguradora,
                        A.NombreCompleto as aseguradora
                        FROM Spring_Produccion.dbo.SS_AD_Garantia G
                                RIGHT JOIN Spring_Produccion.dbo.PersonaMast P
                                        ON P.Persona = G.IdPaciente
                                RIGHT JOIN Spring_Produccion.dbo.PersonaMast A
                                        ON A.Persona = G.IdEmpresaAseguradora
                                        where P.Persona ='$persona'";
            $result = sqlsrv_query($conn,$query, array(), array('Scrollable' => 'buffered')) or die('Error x4: ');
            
            //echo '->'.var_dump(sqlsrv_num_rows($result)).'<-';
            if(sqlsrv_num_rows($result)>0){
                $i=0;
                while($carta = sqlsrv_fetch_array($result)){
                    $data[$i]['IdGarantia']        = $carta['IdGarantia'];              
                    $data[$i]['FechaInicioGarantia']             = ($carta['FechaInicioGarantia']) ;
                    $data[$i]['IdEmpresaAseguradora']      = ($carta['IdEmpresaAseguradora']);
                    $data[$i]['aseguradora']         = ($carta['aseguradora']);
                    $i++;                 
                }  
            }else{
                $data=NULL;
            }
             
            return ($data);
 
        $this->DestruirDatos($result);
        $this->CerrarConexion($conn);              
            
        
    }
    
}