<?php

@session_start();
    if($_SESSION['USUARIO']){
        
        $t = isset($_REQUEST['t']) ? $_REQUEST['t']:1;
        //var_dump($t);
        include_once('../st_ModuloTicket/controles/TicketController.php');
        $TicketController = new TicketController;
        $TicketController -> MostrarTickets($t);
    }else{
        header('location: ../');
    }