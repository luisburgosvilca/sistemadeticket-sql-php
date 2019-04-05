<?php

session_start();
if(isset($_POST['nuevo_ticket']) && isset($_SESSION['usuario_id'])){
    
    include_once('../st_ModuloTicket/controles/TicketController.php');
    $TicketController = new TicketController;
    $TicketController ->FormularioNuevoTicket();
    
}
if(isset($_POST['registrar_ticket']) && isset($_SESSION['usuario_id'])){
    
    include_once ('../st_ModuloTicket/controles/TicketController.php');
    $TicketController = new TicketController();
    $TicketController-> RegistrarTicket();
    
}
if(isset($_POST['ver_ticket']) && isset($_SESSION['usuario_id'])){
    
    include_once('../st_ModuloTicket/controles/TicketController.php');
    $TicketController = new TicketController();
    $TicketController -> DetalleTicket();
}