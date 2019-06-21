<?php


@session_start();
    if($_SESSION['USUARIO']){
        include_once('../st_ModuloPublicaciones/controles/PublicacionesController.php');
        $PublicacionesController = new PublicacionesController();
        $PublicacionesController -> MostrarPublicaciones();
    }else{
        header('location: ../');
    }