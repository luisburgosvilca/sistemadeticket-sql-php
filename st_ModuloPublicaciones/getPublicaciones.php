<?php

session_start();
if(isset($_REQUEST['mostrar_publicaciones']) && isset($_SESSION['USUARIO'])){
    include_once('../st_ModuloPublicaciones/controles/PublicacionesController.php');
    $ControlPublicaciones = new PublicacionesController();
    $ControlPublicaciones ->MostrarPublicacionesGrilla();
    
}

elseif(isset($_REQUEST['nueva_publicacion']) && isset ($_SESSION['USUARIO'])){
    include_once('../st_ModuloPublicaciones/controles/PublicacionesController.php');
    $ControlPublicaciones = new PublicacionesController();
    $ControlPublicaciones ->FormularioNuevaPublicacion();        
}

elseif(isset($_REQUEST['registrar_publicacion']) && isset($_SESSION['USUARIO'])){
    include_once('../st_ModuloPublicaciones/controles/PublicacionesController.php');
    $PublicacionesController = new PublicacionesController();
    $PublicacionesController ->RegistrarPublicacion();
}
?>