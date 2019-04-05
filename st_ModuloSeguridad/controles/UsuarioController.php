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
                            //die(var_dump($usu));
                            if($dataUsuario = $ObjUser ->AutenticarUsuario($usu['id'],$password)){
                                
                                $dataUser['usuario_nombre'] = ucfirst($dataUsuario['nombre'])." ".ucfirst($dataUsuario['apellido']);
                                $dataUser['usuario_id'] = $dataUsuario['id'];
                                $dataUser['usuario_tipo']=$dataUsuario['tipo_id'];
                                
                                $_SESSION['usuario_nombre'] = $dataUser['usuario_nombre'];
                                $_SESSION['usuario_id']     = $dataUser['usuario_id'];
                                $_SESSION['usuaruio_tipo']  = $dataUser['usuario_tipo'];
                                
                                include_once ('../st_ModuloSeguridad/vistas/Dashboard.php');
                                $ObjView = new Dashboard;
                                $ObjView ->MostrarDashboard($dataUser);            
                                                                
                            }
                            else{
                                $mensaje['foto']        = "../st_includes/img/doctor.png";
                                $mensaje['nombre_usuario'] = utf8_encode($usu['nombre'].' '.$usu['apellido']);
                                $mensaje['username']    = $usu['username'];
                                $mensaje['descripcion'] = "Error en la contraseña.<br>Escríbalo nuevamente para ingresar, por favor";
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
        
        public function ObtenerResumenTickets($dataUser){            
                       
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