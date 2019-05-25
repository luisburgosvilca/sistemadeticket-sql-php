<?php

@session_start();
    if($_SESSION['USUARIO']){
        include_once('../st_ModuloCartasDeGarantia/controles/CartasController.php');
        $CartasController = new CartasController();
        $CartasController -> MostrarCartas();
    }else{
        header('location: ../');
    }