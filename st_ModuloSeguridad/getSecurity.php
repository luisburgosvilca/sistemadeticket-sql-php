<?php
@session_start();
if(isset($_POST['ingresar'])){
    
	include_once('controles/UsuarioController.php');
	$ObjUser = new UsuarioController;
	$ObjUser -> AutenticarUsuario();
}
else if(isset($_SESSION['usuario_id'])){
    
    	include_once('controles/UsuarioController.php');
	$ObjUser = new UsuarioController;
	$ObjUser ->MostrarDashboard(); 
}
else{
    header('location: ../st_ModuloSeguridad/logout.php');
    //echo "Sucedió algo inesperado";
}

?>