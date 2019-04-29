<?php

session_start();
if(isset($_REQUEST['registrar_carta']) && isset($_SESSION['usuario_id'])){
    //echo "bien";
    include_once('../st_ModuloCartasDeGarantia/controles/CartasController.php');
    $ControlCarta = new CartasController();
    $ControlCarta -> RegistrarCarta();
    
}
elseif(isset($_REQUEST['mostrar_cartas']) && isset($_SESSION['usuario_id'])){
    include_once('../st_ModuloCartasDeGarantia/controles/CartasController.php');
    $ControlCarta = new CartasController();
    $ControlCarta ->MostrarCartasGrilla();
    
}

elseif(isset($_REQUEST['buscar_paciente']) && isset($_SESSION['usuario_id'])){
    //echo "buscar código";
    include_once('../st_ModuloCartasDeGarantia/controles/CartasController.php');
    $ControlCarta = new CartasController();
    $ControlCarta ->BuscarPaciente();
}
elseif(isset($_REQUEST['buscar_carta_persona']) && isset($_SESSION['usuario_id'])){
    //echo $_POST['persona'];
    include_once('../st_ModuloCartasDeGarantia/controles/CartasController.php');
    $ControlCarta = new CartasController();
    $ControlCarta ->BuscarCartasDePaciente();
}
else{
    echo "algo sucedió";
}