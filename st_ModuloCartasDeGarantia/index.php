<?php

@session_start();
    if($_SESSION['usuario_id']){
        include_once('../st_ModuloCartasDeGarantia/controles/CartasController.php');
        $CartasController = new CartasController();
        $CartasController -> MostrarCartas();
    }else{
        header('location: ../');
    }