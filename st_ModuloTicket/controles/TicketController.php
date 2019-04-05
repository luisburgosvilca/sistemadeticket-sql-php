<?php
include_once("../st_ModuloSeguridad/controles/RecursosController.php");
class TicketController extends RecursosController{
    
    public function getUsuario(){
        
        $dataUser['usuario_nombre'] = $_SESSION['usuario_nombre'];
        $dataUser['usuario_id']     = $_SESSION['usuario_id'];
        $dataUser['usuario_tipo']   = $_SESSION['usuaruio_tipo'];
        
        return $dataUser;
    }
    
    public function MostrarTickets(){
        
        $dataUser=$this->getUsuario();
                       
        include_once('../st_ModuloTicket/vistas/TicketView.php');
        $TicketView = new TicketView();
        $TicketView -> MostrarTickets($dataUser);
    }
    
    public function MostrarTicketsGrilla(){
        
        $dataUser = $this->getUsuario();
        
        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity;        
        
        if($dataUser['usuario_tipo']==1){
            $tickets = $TicketEntity->ObtenerTickets();    
        }else{
            $tickets = $TicketEntity->ObtenerTicketsUsuario($dataUser);
        }   
        
        include_once('../st_ModuloTicket/vistas/partials/PartialsMostrarTickets.php');
        $PartialsMostrarTickets = new PartialsMostrarTickets();
        $PartialsMostrarTickets ->MostrarTicekts($tickets,$dataUser);
        
    }
    
    public function FormularioNuevoTicket(){
        
        $dataUser=$this->getUsuario();
        
        include_once ('../st_ModuloTicket/vistas/FormularioNuevoTicketView.php');
        $FormularioNuevoTicketView = new FormularioNuevoTicketView;
        $FormularioNuevoTicketView -> MostrarFormularioNuevoTicket($dataUser);        
        
    }
    
    public function RegistrarTicket(){
        
        $dataUser=$this->getUsuario();
        
        $data['asunto']     = $_POST['asunto'];
        $data['descripcion']= utf8_decode($_POST['descripcion']);
        $data['lugar_id']   = substr($_POST['lugar_id'], 5);//settype(substr($_POST['lugar_id'], 5), INTEGER);
        $data['ip']         = $this->getUserIpAddr();
        $data['hostname']   = $this->getHostName();
        $data['so']         = $this->getSistemaOperativo();
       
        include_once('../st_ModuloSeguridad/vistas/Mensaje.php');
        $Mensaje = new Mensaje();
        
        //var_dump($data);
        include_once ('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity;
        if($TicketEntity -> RegistrarTicket($data,$dataUser)){
            $mensaje['descripcion'] = "Se registró el ticket satisfactoriamente.";
            $mensaje['clase']       = "success";
        }else{
            $mensaje['descripcion'] = "Hubo un error al registrar el Ticket, si persiste, comuníquese con el administrador, o envíe un correo a: luis.burgos@aliada.com.pe, buen día, Dios lo bendiga";
            $mensaje['clase']       = "warning";
        }     
        $Mensaje -> MostrarMensaje($dataUser,$mensaje);
    }
    
    public function DetalleTicket(){
        
        $dataUser = $this->getUsuario();
        
        $ticket_id = $_POST['ticket_id'];
        
        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
        $data = $TicketEntity-> DetalleTicket($ticket_id,$dataUser);
        //var_dump($data);
        //$data['adminAsignado'] = $TicketEntity->ObtenerDatosPersonalesAdministratorAsignado($ticket_id);
//        switch ($data['adminAsignado']['estado_id']){
//            case 1: $data['adminAsignado']['texto_estado']='Asignado a:';
//                    break;
//            case 2: $data['adminAsignado']['texto_estado']='Asignado a:';
//                    break;
//            case 3: $data['adminAsignado']['texto_estado']='Atendido por:';
//                    break;
//            case 4: $data['adminAsignado']['texto_estado']='Resuelto por:';
//                    break;
//            default : $data['adminAsignado']['texto_estado']='Asignado a:';
//        }
      //var_dump($data);          
        if($dataUser['usuario_tipo']==1){            
            $data['administradores'] = $TicketEntity->ObtenerAdministradores();            
        
            //echo json_encode($data['administradores']);
        }
        
//        for($i=0;$i<count($data['administradores']);$i++){
//            echo $data['administradores'][$i]['admin']."<br>";
//        }
        include_once('../st_ModuloTicket/vistas/DetalleTicketView.php');
        $DetalleTicketView = new DetalleTicketView();
        $DetalleTicketView -> MostrarDetalleTicketView($data,$dataUser);
        
    }
     
    
    public function MostrarComentarios(){
        
        $dataUser = $this->getUsuario();
        $ticket_id = $_POST['ticket_id'];
        
        include_once ('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
        $comentarios = $TicketEntity -> ObtenerComentariosTicket($ticket_id,$dataUser);
        
        //var_dump($comentarios);
        
        include_once ('../st_ModuloTicket/vistas/Partials/PartialsComentarios.php');
        $TicketView = new PartialsComentarios();
        $TicketView -> MostrarComentarios($comentarios,$dataUser);
        
    }

    public function RegistrarComentario(){

        $dataUser = $this->getUsuario();

        $data['comentario'] = utf8_decode($_POST['comentario']); //trim($this->ValidarTexto($_POST['comentario']));
        $data['usuario_id'] = $_POST["usuario_id"];
        $data['ticket_id']  = $_POST["ticket_id"];

        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
        $TicketEntity -> RegistrarComentario($data,$dataUser);

    }
    
    public function AsignarAdministradorATicket(){
        
        $dataUser = $this->getUsuario();
        
        $data['admin_id']   = $_POST['admin_id'];
        $data['usuario_id'] = $_POST['usuario_id'];
        $data['ticket_id']  = $_POST['ticket_id'];
        
        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
        if($TicketEntity -> AsignarAdministradorATicket($data,$dataUser)){

            $dataAdmin = $TicketEntity->ObtenerDatosPersonalesAdministratorAsignado($data['ticket_id']);
            
            if($dataAdmin!=NULL){
               $mensaje['descripcion']  = "<p class='text-green'>".utf8_encode($dataAdmin['nombre'].' '.$dataAdmin['apellido'])."</p>";
               $mensaje['fecha']        = $dataAdmin['fechaAsignado'];
               $mensaje['ticket_id']    = $data['ticket_id'];
               $mensaje['usuario_id']   = $dataUser['usuario_id'];
            }else{
                $mensaje = "<dd><span class='label label-danger'>Aún no asignado.</span></dd>";
            }
           
            /////
            if($dataUser['usuario_tipo']==1){            
            $mensaje['administradores'] = $TicketEntity->ObtenerAdministradores();   
            $mensaje['admin_id'] = $data['admin_id'];
        }   
            /////
            
        }else{
            $mensaje = "<p class='text-red'>Hubo un error en asignar ticket, vuelva a intentarlo</p>";
        }
        
        include_once('../st_ModuloTicket/vistas/partials/PartialsAdminAssignedToTicket.php');
        $PartialsAdminAssignedToTicket = new PartialsAdminAssignedToTicket();
        $PartialsAdminAssignedToTicket ->MostrarResultadoAdministradorAsignado($mensaje);
        
    }
    
    public function AsignarAdministradorATicket2(){
        
        $dataUser = $this->getUsuario();
        
        $data['admin_id']   = $_POST['admin_id'];
        $data['usuario_id'] = $_POST['usuario_id'];
        $data['ticket_id']  = $_POST['ticket_id'];
        
        $data['hostname_asigna']  = $this->getHostName();
        $data['so_asigna']        = $this->getSistemaOperativo();
        
        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
        if($TicketEntity -> AsignarAdministradorATicket($data,$dataUser)){

            $data = $TicketEntity ->DetalleTicket($data['ticket_id'], $dataUser);
            $data['administradores'] = $TicketEntity->ObtenerAdministradores();            
        
        include_once('../st_ModuloTicket/vistas/partials/PartialsMostrarEstadoTicket.php');
        $PartialsAdminAssignedToTicket = new PartialsMostrarEstadoTicket();
        $PartialsAdminAssignedToTicket ->MostrarEstadoDeTicketAdmin($data,$dataUser);
        
        }
    
    }
    
    public function SolicitarConfirmacionDeResuelto(){
        
        $dataUser = $this->getUsuario();
        
        $data['usuario_id'] = isset($_POST['usuario_id'])?$_POST['usuario_id']:$dataUser['usuario_id'];
        $data['ticket_id']  = $_POST['ticket_id'];
        $data['hostname_atendido']  = $this->getHostName();
        $data['so_atendido']        = $this->getSistemaOperativo();

        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
       
            include_once('../st_ModuloTicket/vistas/partials/PartialsEsperarConfirmacionDeUsuario.php');
            $PartialsEsperarConfirmacionDeUsuario = new PartialsEsperarConfirmacionDeUsuario();
        
        if($TicketEntity ->MarcarComoResuelto($data,$dataUser)){
            
            $PartialsEsperarConfirmacionDeUsuario ->MostrarMensajeEsperarConfirmacionDeUsuario();
        }else{
            $PartialsEsperarConfirmacionDeUsuario->MostrarMensajeErrorAlMarcarComoResuelto();
        }        
    }

    public function SolicitarConfirmacionDeResuelto2(){
        
        $dataUser = $this->getUsuario();
        
        $data['usuario_id'] = isset($_POST['usuario_id'])?$_POST['usuario_id']:$dataUser['usuario_id'];
        $data['ticket_id']  = $_POST['ticket_id'];
        $data['hostname_atendido']  = $this->getHostName();
        $data['so_atendido']        = $this->getSistemaOperativo();

        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
       
        include_once('../st_ModuloTicket/vistas/partials/PartialsMostrarEstadoTicket.php');
        $PartialsMostrarEstadoTicket = new PartialsMostrarEstadoTicket();
        
        if($TicketEntity ->MarcarComoResuelto($data,$dataUser)){
            
            $data = $TicketEntity ->DetalleTicket($data['ticket_id'], $dataUser);
            $PartialsMostrarEstadoTicket ->MostrarEstadoDeTicketAdmin($data, $dataUser);
        }else{
            $PartialsMostrarEstadoTicket->MostrarMensajeErrorAlMarcarComoResuelto();
        }        
    }    
    
    public function ResolverTicekt(){
        
        $dataUser = $this->getUsuario();
        
        $data['usuario_id'] = $dataUser['usuario_id'];
        $data['ticket_id']  = $_POST['ticket_id'];
        $data['hostname_confirmado'] = $this->getHostName();
        $data['so_confirmado']= $this->getSistemaOperativo();
        $data['ip_confirmado']= $this->getUserIpAddr();
        
        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
        if($TicketEntity->TicketResuelto($data, $dataUser)){
        
            $data = $TicketEntity->DetalleTicket($data['ticket_id'], $dataUser);
            
            include_once('../st_ModuloTicket/vistas/partials/PartialsMostrarEstadoTicket.php');
            $PartialsMostrarEstadoTicket = new PartialsMostrarEstadoTicket();
            $PartialsMostrarEstadoTicket ->MostrarEstadoDeTicketAdmin($data, $dataUser);
            
        }       
    }
    //////////////////////
    public function EscucharCambioEstadoTicekt(){
        
        $dataUser = $this->getUsuario();
        
        $data['ticket_id'] = $_POST['ticket_id'];
        $data['estado_id'] = $_POST['estado_id'];
        
        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
        $data['ticket'] = $TicketEntity->DetalleTicket($data['ticket_id'], $dataUser);
        
        $data['cambio'] = $data['estado_id']==$data['ticket']['estado_id']?0:$data['ticket']['estado_id'];                     
        
        include_once('../st_ModuloTicket/vistas/partials/PartialsMostrarCambioDeEstadoDeTicket.php');
        $PartialsMostrarCambioDeEstadoDeTicket = new PartialsMostrarCambioDeEstadoDeTicket();
        $PartialsMostrarCambioDeEstadoDeTicket ->MostrarCambioDeEstadoDeTicket($data,$dataUser);             
        
    }
    ///////////////////////
        public function VerEstadoDeTicekt(){
        
        $dataUser = $this->getUsuario();
        
        $data['ticket_id'] = $_POST['ticket_id'];
        $data['estado_id'] = $_POST['estado_id'];
        
        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
        $data = $TicketEntity->DetalleTicket($data['ticket_id'], $dataUser);   
        
        if($dataUser['usuario_tipo']==1){            
            $data['administradores'] = $TicketEntity->ObtenerAdministradores();            
        }
        
        include_once('../st_ModuloTicket/vistas/partials/PartialsMostrarEstadoTicket.php');
        $PartialsMostrarCambioDeEstadoDeTicket = new PartialsMostrarEstadoTicket();
        $PartialsMostrarCambioDeEstadoDeTicket ->MostrarEstadoDeTicketAdmin($data,$dataUser);             
        
    }
}