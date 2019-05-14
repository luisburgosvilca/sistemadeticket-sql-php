<?php

include_once('../st_ModuloSeguridad/controles/RecursosController.php');
class UsuarioController extends RecursosController
{
    function __construct() {
        @session_start();
    }

	function AutenticarUsuario(){
            
            
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

                include_once('../st_ModuloSeguridad/vistas/FormularioAccesoDenegado.php');
                $FormMessage = new FormularioAccesoDenegado();
	
                if($this->ValidarTexto($username) and $this->ValidarTexto($password)){

                    include_once ('../st_ModuloSeguridad/entidades/Usuario.php');                
                    $ObjUser = new Usuario;
                                       
                        if($usu = $ObjUser ->VerificarExistenciaDeUsuario($username)){
                            //die(var_dump($usu['CLAVE']));
                            $dataUser['USUARIO'] = $usu['USUARIO'];
                            $dataUser['CLAVE']   = $usu['CLAVE'];
                            $dataUser['NOMBRE']  = $usu['NOMBRE'];
                            $dataUser['Persona'] = $usu['Persona'];
                            $dataUser['CMP']     = $usu['CMP'];
                            $dataUser['iniciales'] = $usu['INICIALES'];
                            
                            $dataUsuario = $ObjUser ->AutenticarUsuario($usu['CLAVE']);
                            //die(var_dump($dataUsuario['clave']));
                            if($dataUsuario['clave']==$password){
                                
                                if(isset($dataUser['Persona'])){
                                    
                                    $dataUsuario=$ObjUser->ObtenerDatosPersonales($dataUser['Persona']);
                                    //var_dump($dataUsuario['Persona']);
                                    $dataUser['ApellidoPaterno'] = $dataUsuario['ApellidoPaterno'];
                                    $dataUser['ApellidoMaterno'] = $dataUsuario['ApellidoMaterno'];
                                    $dataUser['Nombres']         = $dataUsuario['Nombres'];                                    
                                    
                                    $parte = explode(" ",$dataUser['Nombres']); 
                                    $dataUser['Nombres'] = $parte[0]; 
                                    
                                    $dataUser['CorreoElectronico']=$dataUsuario['CorreoElectronico']; 
                                    $dataUser['sistema_id']      = $dataUsuario['sistema_id'];
                                
                                    $dataUser['usuario_nombre'] = ucfirst(strtolower($dataUser['Nombres']))." ".ucfirst(strtolower($dataUser['ApellidoPaterno']));    
                                }else{
                                    $dataUser['usuario_nombre'] = $usu['NOMBRE'];
                                }
                               
                                $dataUser['usuario_id']     = $dataUsuario['Persona'];                              
                                $dataUsuario=$ObjUser->EsAdministrador($dataUsuario['Persona'], $dataUser);
                                $dataUser['usuario_tipo']=$dataUsuario['tipo_id'];
                                //var_dump($dataUsuario['tipo_id']);
                                $_SESSION['usuario_nombre'] = $dataUser['usuario_nombre'];
                                $_SESSION['usuario_id']     = $dataUser['usuario_id'];
                                $_SESSION['usuaruio_tipo']  = $dataUser['usuario_tipo'];
                                $_SESSION['USUARIO']        = $dataUser['USUARIO'];
                                $_SESSION['Persona']        = $dataUser['Persona'];
                                $_SESSION['CorreoElectronico']= $dataUser['CorreoElectronico'];
                                $_SESSION['sistema_id']     = $dataUser['sistema_id'];
                                
                                include_once ('../st_ModuloSeguridad/vistas/Dashboard.php');
                                $ObjView = new Dashboard;
                                $ObjView ->MostrarDashboard($dataUser);
                                                                
                            }
                            else{
                                $mensaje['foto']        = "../st_includes/img/doctor.png";
                                $mensaje['nombre_usuario'] = utf8_encode($dataUser['NOMBRE']);
                                $mensaje['username']    = $dataUser['USUARIO'];
                                $mensaje['descripcion'] = "Error en la contraseña.<br>Escríbalo nuevamente para ingresar, verifique mayúsculas o minúsculas por favor";
                            }


                        }
                        else{
                            
                            $mensaje['foto']        = "../st_includes/img/doctor.png";
                            $mensaje['descripcion'] = "Usuario no registrado";
                            
                        }             
		}
                else{
                    $mensaje['foto']        = "../st_includes/img/doctor.png";
                    $mensaje['descripcion'] =  "Verifique sus credenciales";
                }
                
                $FormMessage ->MostrarMensajeAutenticacionDenegada($mensaje);
	}
        
        public function MostrarDashboard(){
            
            $dataUser['usuario_nombre'] = $_SESSION['usuario_nombre'];
            $dataUser['usuario_id']     = $_SESSION['usuario_id'];
            $dataUser['usuario_tipo']   = $_SESSION['usuaruio_tipo']; 
        
            include_once ('../st_ModuloSeguridad/vistas/Dashboard.php');
            $ObjView = new Dashboard;
            $ObjView ->MostrarDashboard($dataUser);             
        }
        
        public function ObtenerResumenTickets(){   
            
            $dataUser=$this->getUsuario();
                       
            include_once('../st_ModuloSeguridad/entidades/UsuarioTicket.php');
            $UsuarioTicekt = new UsuarioTicket();
            if($dataUser['usuario_tipo']==1){
                $tickets = $UsuarioTicekt->ObtenerResumenTickets($dataUser);                               
                
            }else{
                $tickets= $UsuarioTicekt->ObtenerTicketsDeUsuario($dataUser);
            }
//            var_dump($tickets);
//                while($r=sqlsrv_fetch_array($tickets)){
//                  echo $r['descripcion'].'<br>';
//                } 
//            for($i=0;$i<count($tickets);$i++){
//                echo $tickets[$i]['descripcion'].": ".$tickets[$i]['cantidad']."<br>";
//            }
                        
            return $tickets;            
            
        }
}

?>