<?php

@session_start();
    if($_SESSION['usuario_id']){
        include_once('../st_ModuloTicket/controles/TicketController.php');
        $TicketController = new TicketController;
        $TicketController -> MostrarTickets();
    }else{
        header('location: ../');
    }