<?php
include_once("../st_ModuloSeguridad/controles/RecursosController.php");
class TicketController extends RecursosController{
       
    public function EsAdmin($persona,$dataUser){
        
        include_once('../st_ModuloSeguridad/entidades/Usuario.php');
        $Usuario = new Usuario();
        $user = $Usuario->EsAdministrador($persona, $dataUser);
        
        return $user['sistema_id'];
    }
    
    public function MostrarTickets($t){
        
        $dataUser=$this->getUsuario();
        $dataUser['t']=$t;
        
        $dataUser['sistema_id'] = $this->EsAdmin($dataUser['Persona'],$dataUser);
        
        include_once('../st_ModuloTicket/vistas/TicketView.php');
        $TicketView = new TicketView();
        $TicketView -> MostrarTickets($dataUser);
    }
    
    public function MostrarTicketsGrilla(){
        
        $dataUser = $this->getUsuario();
        $dataUser['t'] = $_REQUEST['t'];
        
        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity;
        
        if($dataUser['usuario_tipo']==1){
            $tickets = $TicketEntity->ObtenerTickets($dataUser['t']);
        }else{
            $tickets = $TicketEntity->ObtenerTicketsUsuario($dataUser);
        }   
        
        include_once('../st_ModuloTicket/vistas/partials/PartialsMostrarTickets.php');
        $PartialsMostrarTickets = new PartialsMostrarTickets();
        $PartialsMostrarTickets ->MostrarTicekts($tickets,$dataUser);
        
    }
    
    public function FormularioNuevoTicket(){
        
        $dataUser=$this->getUsuario();
        $dataUser['t'] = $_REQUEST['t'];
        
        include_once ('../st_ModuloTicket/vistas/FormularioNuevoTicketView.php');
        $FormularioNuevoTicketView = new FormularioNuevoTicketView;
        $FormularioNuevoTicketView -> MostrarFormularioNuevoTicket($dataUser);        
        
    }
    
    public function RegistrarTicket(){
        
        $dataUser=$this->getUsuario();
        $data=$this->getDatosTransaccion($dataUser);
        
        //$ticket_id = $_POST['ticket_id'];
        
        $data['asunto']     = addslashes($_POST['asunto']);
        $data['descripcion']= htmlspecialchars(addslashes($_POST['descripcion']));
        $data['lugar_id']   = substr($_POST['lugar_id'], 5);//settype(substr($_POST['lugar_id'], 5), INTEGER);
        $data['tipo_id']    = $_REQUEST['tipo_id'];
        //die($_REQUEST['tipo_id']);
        include_once('../st_ModuloSeguridad/vistas/Mensaje.php');
        $Mensaje = new Mensaje();
        //var_dump($data);
        //var_dump($data);
        include_once ('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity;
        //registrar imagen
        if($data['ticket_id'] = $TicketEntity -> RegistrarTicket($data,$dataUser)){
            //echo $data['ticket_id'];
            $data['codigo'] = $TicketEntity->RegistrarCodigo($data['ticket_id']);           
            
            /////////////////////////
            ///Acción 1: RegistrarComentario de Inicio
            $data['comentario'] = '<p>
                                    <span class="label label-primary" style="width:100%; font-size:14px;">He regitrado un Ticket</span>
                                   </p>';
            $TicketEntity->RegistrarComentario($data, $dataUser);
            ///Acción 3: Notificar vía Mail
            $data['usuario_nombre'] = $dataUser['usuario_nombre'];
            //$this->EnviarEmail($data);
            ///Acción 4: Registrar para Notificar a Administradores
            /////////////////////////
            $data['count'] = count($_FILES['archivo']['tmp_name']);
            if($data['count']>0){
             
                $resultado = $this->RegistrarArchivo($data,$dataUser);
                //var_dump($resultado);
                if($resultado==TRUE){
            $mensaje['descripcion'] = "Se registró el ticket satisfactoriamente.";
            $mensaje['clase']       = "success";
        }else{
            $mensaje['descripcion'] = $resultado;
            $mensaje['clase']       = "warning";
        }
            }else{
                $mensaje['descripcion'] = "Se registró el ticket satisfactoriamente.";
                $mensaje['clase']       = "success";
            }           

        }else{
            $mensaje['descripcion'] = "Hubo un error al registrar el Ticket, si persiste, comuníquese con el administrador, o envíe un correo a: luis.burgos@aliada.com.pe, buen día, Dios lo bendiga";
            $mensaje['clase']       = "danger";
        }           
        $Mensaje -> MostrarMensaje($dataUser,$mensaje);
    }
    
    public function DetalleTicket(){
        
        $dataUser = $this->getUsuario();
        $dataUser['t'] = $_REQUEST['t'];
        
        $ticket_id = $_POST['ticket_id'];
        
        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
        $data = $TicketEntity-> DetalleTicket($ticket_id,$dataUser);
        //var_dump($data);
//        $data['adminAsignado'] = $TicketEntity->ObtenerDatosPersonalesAdministratorAsignado($ticket_id);
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
        
        $data['files'] = $TicketEntity->ObtenerArchivosAdjuntos($ticket_id);
        
        if($dataUser['usuario_tipo']==1){            
            $data['administradores'] = $TicketEntity->ObtenerAdministradores($dataUser['t']);            
        }
        //var_dump($data['files'][0]['extension']);
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
                
        include_once ('../st_ModuloTicket/vistas/Partials/PartialsComentarios.php');
        $TicketView = new PartialsComentarios();
        $TicketView -> MostrarComentarios($comentarios,$dataUser);
        
    }

    public function RegistrarComentario(){

        $dataUser = $this->getUsuario();
        $data=$this->getDatosTransaccion($dataUser);

        $data['comentario'] = ($_POST['comentario']); //trim($this->ValidarTexto($_POST['comentario']));

        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
        $TicketEntity -> RegistrarComentario($data,$dataUser);

    }
    
//    public function AsignarAdministradorATicket(){
//        
//        $dataUser = $this->getUsuario();
//        $data=$this->getDatosTransaccion($dataUser);
//        
//        $data['admin_id']   = $_POST['admin_id'];
//        
//        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
//        $TicketEntity = new TicketEntity();
//        if($TicketEntity -> AsignarAdministradorATicket($data,$dataUser)){
//
//            $dataAdmin = $TicketEntity->ObtenerDatosPersonalesAdministratorAsignado($data['ticket_id']);
//            
//            if($dataAdmin!=NULL){
//               $mensaje['descripcion']  = "<p class='text-green'>".utf8_encode($dataAdmin['nombre'].' '.$dataAdmin['apellido'])."</p>";
//               $mensaje['fecha']        = $dataAdmin['fechaAsignado'];
//               $mensaje['ticket_id']    = $data['ticket_id'];
//               $mensaje['usuario_id']   = $dataUser['usuario_id'];
//            }else{
//                $mensaje = "<dd><span class='label label-danger'>Aún no asignado.</span></dd>";
//            }
//           
//            /////
//            if($dataUser['usuario_tipo']==1){            
//            $mensaje['administradores'] = $TicketEntity->ObtenerAdministradores();   
//            $mensaje['admin_id'] = $data['admin_id'];
//        }   
//            /////
//            
//        }else{
//            $mensaje = "<p class='text-red'>Hubo un error en asignar ticket, vuelva a intentarlo</p>";
//        }
//        
//        include_once('../st_ModuloTicket/vistas/partials/PartialsAdminAssignedToTicket.php');
//        $PartialsAdminAssignedToTicket = new PartialsAdminAssignedToTicket();
//        $PartialsAdminAssignedToTicket ->MostrarResultadoAdministradorAsignado($mensaje);
//        
//    }
    
    public function AsignarAdministradorATicket2(){
        
        $dataUser = $this->getUsuario();
        $data = $this->getDatosTransaccion($dataUser);
        
        $dataUser['t'] = $_REQUEST['sistema_id'];
        
        //var_dump($dataUser['sistema_id']);
        $data['admin_id']   = $_POST['admin_id'];
        //var_dump($data['admin_id']);
        //var_dump($data['estado_id']);
        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
        if($TicketEntity -> AsignarAdministradorATicket($data,$dataUser)){
            //echo $data['admin_id'].'-'.$dataUser['USUARIO'];
            /////////////////////////////////
            //Informar Asignacion de Ticekt
            //1. Registrar Comentario marcado
            
            $data['comentario'] = '<p>
                        <span class="label label-info" style="width:100%; font-size:14px;">'.$data['admin_id'].' resolverá este Ticket</span>
                       </p>';
            $TicketEntity->RegistrarComentario($data, $dataUser);
            
            //2.Notificar via Email
            // 
            ///////////////////////////////////
            
            

            $data = $TicketEntity ->DetalleTicket($data['ticket_id'], $dataUser);
            $data['administradores'] = $TicketEntity->ObtenerAdministradores($dataUser['sistema_id']);            
        
        include_once('../st_ModuloTicket/vistas/partials/PartialsMostrarEstadoTicket.php');
        $PartialsAdminAssignedToTicket = new PartialsMostrarEstadoTicket();
        $PartialsAdminAssignedToTicket ->MostrarEstadoDeTicketAdmin($data,$dataUser);
        
        }
    
    }
    
//    public function SolicitarConfirmacionDeResuelto(){
//        
//        $dataUser = $this->getUsuario();
//        $data = $this->getDatosTransaccion($dataUser);
//        
//        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
//        $TicketEntity = new TicketEntity();
//       
//            include_once('../st_ModuloTicket/vistas/partials/PartialsEsperarConfirmacionDeUsuario.php');
//            $PartialsEsperarConfirmacionDeUsuario = new PartialsEsperarConfirmacionDeUsuario();
//        
//        if($TicketEntity ->MarcarComoResuelto($data,$dataUser)){
//            
//            $PartialsEsperarConfirmacionDeUsuario ->MostrarMensajeEsperarConfirmacionDeUsuario();
//        }else{
//            $PartialsEsperarConfirmacionDeUsuario->MostrarMensajeErrorAlMarcarComoResuelto();
//        }        
//    }

    public function SolicitarConfirmacionDeResuelto2(){
        
        $dataUser = $this->getUsuario();
        $data=$this->getDatosTransaccion($dataUser);
        
        $dataUser['t'] = $_REQUEST['sistema_id'];

        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
       
        include_once('../st_ModuloTicket/vistas/partials/PartialsMostrarEstadoTicket.php');
        $PartialsMostrarEstadoTicket = new PartialsMostrarEstadoTicket();
        
        if($TicketEntity ->MarcarComoResuelto($data,$dataUser)){
            
            $data['administradores'] = $TicketEntity->ObtenerAdministradores($dataUser['sistema_id']);    //
            ///Acciones:
            //1. Registrar Comentario marcado
            $data['comentario'] = '<p>
                                    <span class="label label-warning" style="width:100%; font-size:14px;">'.$dataUser['USUARIO'].' ha resuelto el Ticket, esperando confirmación.</span>
                                   </p>';  
            $TicketEntity->RegistrarComentario($data, $dataUser);
            //2. Enviar Email
            
            $data = $TicketEntity ->DetalleTicket($data['ticket_id'], $dataUser);
            $PartialsMostrarEstadoTicket ->MostrarEstadoDeTicketAdmin($data, $dataUser);
        }else{
            $PartialsMostrarEstadoTicket->MostrarMensajeErrorAlMarcarComoResuelto();
        }        
    }    
    
    public function ResolverTicekt(){
        
        $dataUser = $this->getUsuario();
        $data = $this->getDatosTransaccion($dataUser);
        
        $dataUser['t'] = $_REQUEST['sistema_id'];
        
        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
        if($TicketEntity->TicketResuelto($data, $dataUser)){

            ///Acciones:
            //1. Registrar Comentario marcado
            $data['comentario'] = '<p>
                                    <span class="label label-success" style="width:100%; font-size:14px;">'.$dataUser['USUARIO'].' ha confirmado la solución del Ticket.</span>
                                   </p>';  
            $TicketEntity->RegistrarComentario($data, $dataUser);
            //2. Enviar Email            
            
        
            $data = $TicketEntity->DetalleTicket($data['ticket_id'], $dataUser);
            
            include_once('../st_ModuloTicket/vistas/partials/PartialsMostrarEstadoTicket.php');
            $PartialsMostrarEstadoTicket = new PartialsMostrarEstadoTicket();
            $PartialsMostrarEstadoTicket ->MostrarEstadoDeTicketAdmin($data, $dataUser);
            
        }       
    }
    
    public function NegarSolucionDeTicekt(){
        
        $dataUser = $this->getUsuario();        
        $data = $this->getDatosTransaccion($dataUser);
        
        $dataUser['t'] = $_REQUEST['sistema_id'];
        
        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
        
           
        
        //en esta parte resolver para que el administrador pueda ver el estado de cada ticket
        $data['codigo'] = $_POST['codigo'];
        $data['asunto'] = $_POST['asunto'];
        $data['descripcion'] = $_POST['descripcion'];
        
        if($TicketEntity->NegarSolucionTicket($data,$dataUser)){
            
            ///Acciones:
            //1. Registrar Comentario marcado
            $data['comentario'] = '<p>
                                    <span class="label label-danger" style="width:100%; font-size:14px;">'.$dataUser['USUARIO'].' indica que hay observaciones en la solución del Ticket.</span>
                                   </p>';  
            $TicketEntity->RegistrarComentario($data, $dataUser);
            //2. Enviar Email                  
         
            $data = $TicketEntity->DetalleTicket($data['ticket_id'], $dataUser);
            $data['administradores'] = $TicketEntity->ObtenerAdministradores($dataUser['sistema_id']);     
            
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
        
        $dataUser['t'] = $_REQUEST['sistema_id'];
        
        $data['ticket_id'] = $_POST['ticket_id'];
        $data['estado_id'] = $_POST['estado_id'];
        
        include_once('../st_ModuloTicket/entidades/TicketEntity.php');
        $TicketEntity = new TicketEntity();
        $data = $TicketEntity->DetalleTicket($data['ticket_id'], $dataUser);   
        
        $data['administradores']= $TicketEntity->ObtenerAdministradores($dataUser['t']);
        
        include_once('../st_ModuloTicket/vistas/partials/PartialsMostrarEstadoTicket.php');
        $PartialsMostrarCambioDeEstadoDeTicket = new PartialsMostrarEstadoTicket();
        $PartialsMostrarCambioDeEstadoDeTicket ->MostrarEstadoDeTicketAdmin($data,$dataUser);             
        
    }
}