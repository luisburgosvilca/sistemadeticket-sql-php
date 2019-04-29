<?php

session_start();
if(isset($_POST['mostrar_tickets']) && isset($_SESSION['usuario_id'])){
    //echo "Aliada";
        include_once('../st_ModuloTicket/controles/TicketController.php');
        $TicketController = new TicketController;
        $TicketController -> MostrarTicketsGrilla();
    
}
else if(isset($_POST['nuevo_ticket']) && isset($_SESSION['usuario_id'])){
    
    include_once('../st_ModuloTicket/controles/TicketController.php');
    $TicketController = new TicketController;
    $TicketController ->FormularioNuevoTicket();
    
}
else if(isset($_POST['registrar_ticket']) && isset($_SESSION['usuario_id'])){
    
    include_once ('../st_ModuloTicket/controles/TicketController.php');
    $TicketController = new TicketController();
    $TicketController-> RegistrarTicket();
    
}
else if(isset($_POST['ver_ticket']) && isset($_SESSION['usuario_id'])){
    
    include_once('../st_ModuloTicket/controles/TicketController.php');
    $TicketController = new TicketController();
    $TicketController -> DetalleTicket();
}

//elseif(isset($_POST['enviar_comentario']) && isset($_SESSION['usuario_id'])){
//    
//    include_once('../st_ModuloTicket/controles/TicketController.php');
//    $TicketController = new TicketController();
//    $TicketController -> RegistrarComentario();
//    
//}

elseif(isset($_POST['action']) && isset($_SESSION['usuario_id'])){
    
    include_once('../st_ModuloTicket/controles/TicketController.php');
    $TicketController = new TicketController();
    $TicketController -> MostrarComentarios();
}

elseif(isset($_POST['registrar_comentario']) && isset($_SESSION['usuario_id'])){

    include_once('../st_ModuloTicket/controles/TicketController.php');
    $TicketController = new TicketController();
    $TicketController -> RegistrarComentario();

}
//elseif(isset($_POST['admin_id*']) && isset($_SESSION['usuario_id'])){
//    
//    include_once('../st_ModuloTicket/controles/TicketController.php');
//    $TicketController = new TicketController();
//    $TicketController -> AsignarAdministradorATicket();    
//}
elseif(isset($_POST['admin_id']) && isset($_SESSION['usuario_id'])){
    
    include_once('../st_ModuloTicket/controles/TicketController.php');
    $TicketController = new TicketController();
    $TicketController -> AsignarAdministradorATicket2();    
}
//elseif(isset($_POST['confirmar_resuelto*']) && isset($_SESSION['usuario_id'])){
//    //echo "hola";
//    include_once('../st_ModuloTicket/controles/TicketController.php');
//    $TicketController = new TicketController();
//    $TicketController -> SolicitarConfirmacionDeResuelto();    
//}
elseif(isset($_POST['marcar_resuelto']) && isset($_SESSION['usuario_id'])){
    //echo "hola";
    include_once('../st_ModuloTicket/controles/TicketController.php');
    $TicketController = new TicketController();
    $TicketController -> SolicitarConfirmacionDeResuelto2();    
}
elseif(isset($_POST['confirmar_resuelto']) && isset($_SESSION['usuario_id'])){
    //echo $_POST['ticket_id'];
    include_once('../st_ModuloTicket/controles/TicketController.php');
    $TicketController = new TicketController();
    $TicketController -> ResolverTicekt();
}
elseif(isset($_POST['negar_resuelto']) && isset($_SESSION['usuario_id'])){
    include_once('../st_ModuloTicket/controles/TicketController.php');
    $TicketController = new TicketController();
    $TicketController -> NegarSolucionDeTicekt();
}
//////////////
else if(isset ($_POST['cambio_estado']) && isset ($_SESSION['usuario_id'])){
    //echo 'cambio de estado: '.$_POST['ticket_id'];
    include_once('../st_ModuloTicket/controles/TicketController.php');
    $TicketController = new TicketController();
    $TicketController ->EscucharCambioEstadoTicekt();
}///////////////
else if(isset ($_POST['estado_ticket_admin']) && isset ($_SESSION['usuario_id'])){

    include_once('../st_ModuloTicket/controles/TicketController.php');
    $TicketController = new TicketController();
    $TicketController ->VerEstadoDeTicekt();       
}
else{
    echo "Algo sucedió";
    //include_once('../st_ModuloSeguridad/logout.php');
}