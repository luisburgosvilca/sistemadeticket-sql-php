<?php

session_start();
if(isset($_REQUEST['registrar_carta']) && isset($_SESSION['USUARIO'])){
    //echo "bien";
    include_once('../st_ModuloCartasDeGarantia/controles/CartasController.php');
    $ControlCarta = new CartasController();
    $ControlCarta -> RegistrarCarta();
    
}
elseif(isset($_REQUEST['mostrar_cartas']) && isset($_SESSION['USUARIO'])){
    include_once('../st_ModuloCartasDeGarantia/controles/CartasController.php');
    $ControlCarta = new CartasController();
    $ControlCarta ->MostrarCartasGrilla();
    
}

elseif(isset($_REQUEST['buscar_paciente']) && isset($_SESSION['USUARIO'])){
    //echo "buscar código";
    include_once('../st_ModuloCartasDeGarantia/controles/CartasController.php');
    $ControlCarta = new CartasController();
    $ControlCarta ->BuscarPaciente();
}
elseif(isset($_REQUEST['buscar_carta_persona']) && isset($_SESSION['USUARIO'])){
    //echo $_POST['persona'];
    include_once('../st_ModuloCartasDeGarantia/controles/CartasController.php');
    $ControlCarta = new CartasController();
    $ControlCarta ->BuscarCartasDePaciente();
}
elseif(isset($_REQUEST['mostrar_resultados']) && isset($_SESSION['USUARIO'])){
    
    include_once('../st_ModuloCartasDeGarantia/controles/CartasController.php');
    $ControlCarta = new CartasController();
    $ControlCarta ->MostrarResultadosCartaPaciente();
    
}

elseif(isset($_REQUEST['actualizar_estado_carta']) && isset ($_SESSION['USUARIO'])){
    
    include_once('../st_ModuloCartasDeGarantia/controles/CartasController.php');
    $ControlCarta = new CartasController();
    $ControlCarta ->ActualizarEstadoCarta();
    
}

elseif(isset($_REQUEST['actualizarFechaAprobacion']) && isset($_SESSION['USUARIO'])){
    
    include_once('../st_ModuloCartasDeGarantia/controles/CartasController.php');
    $ControlCarta = new CartasController();
    $ControlCarta ->ActualizarFechaAprobacion();
    
}
elseif(isset ($_REQUEST['actualizarFechaAprobacion3']) && isset ($_SESSION['USUARIO'])){
 
    include_once('../st_ModuloCartasDeGarantia/controles/CartasController.php');
    $ControlCarta = new CartasController();
    $ControlCarta ->ActualizarFechaAprobacion();
    
}
else{
    echo "algo sucedió, vuelva a iniciar sesión";
}