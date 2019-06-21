<?php
include_once("../st_ModuloSeguridad/controles/RecursosController.php");
class PublicacionesController extends RecursosController{
    
    public function MostrarPublicaciones(){
        
        $dataUser=$this->getUsuario();

        include_once('../st_ModuloPublicaciones/entidades/PublicacionEntity.php');
        $PublicacionEntity = new PublicacionEntity(); 
        $data['registros'] = $PublicacionEntity->ObtenerRegistros();
                       
        include_once('../st_ModuloPublicaciones/vistas/PublicacionesView.php');
        $PublicacionView = new PublicacionesView();
        $PublicacionView ->MostrarPublicaciones($data,$dataUser);    
        
    }
    
//    public function MostrarPublicacionesGrilla(){
//        
//        $dataUser=$this->getUsuario();
//
//        include_once('../st_ModuloPublicaciones/entidades/PublicacionesEntity.php');
//        $PublicacionesEntity = new PublicacionesEntity();   
//        
//        $data['registros'] = $PublicacionesEntity->ObtenerRegistros();
//        //$data['estados'] = $cartaEntity->ObtenerEstadosDeCartas();
//
//        include_once('../st_ModuloPublicaciones/vistas/partials/MostrarPublicacionesPartials.php');
//        $MostrarPublicacionesPartials = new MostrarPublicacionesPartials();
//        $MostrarPublicacionesPartials ->MostrarPublicaciones($data,$dataUser);
//
//    }
    
    public function FormularioNuevaPublicacion(){
        
        $dataUser=$this->getUsuario();
        
        include_once('../st_ModuloPublicaciones/vistas/FormularioNuevaPublicacion.php');
        $FormularioNuevaPublicacion = new FormularioNuevaPublicacion();
        $FormularioNuevaPublicacion ->MostrarFormularioNuevaPublicacion($dataUser);
        
    }
    
    public function RegistrarPublicacion(){
        
        $dataUser=$this->getUsuario();
        $data=$this->getDatosTransaccion($dataUser);
        
        //$ticket_id = $_POST['ticket_id'];
        
        $data['titulo']     = addslashes($_POST['asunto']);
        $data['descripcion']= htmlspecialchars(addslashes($_POST['descripcion']));
        include_once('../st_ModuloSeguridad/vistas/Mensaje.php');
        $Mensaje = new Mensaje();
        //var_dump($data);
        //var_dump($data);
        $data['titulo_url'] = $this->url_amigable($data['titulo']);
        //34 Publico
        //35 No Público
        $data['estado_id']=34;
        include_once ('../st_ModuloPublicaciones/entidades/PublicacionEntity.php');
        $PublicacionEntity = new PublicacionEntity();
        //registrar imagen
        if($data['publicacion_id'] = $PublicacionEntity -> RegistrarPublicacion($data,$dataUser)){
            echo $data['publicacion_id'];
            //$data['codigo'] = $TicketEntity->RegistrarCodigo($data['ticket_id']);           
            
            $data['count'] = count($_FILES['archivo']['tmp_name']);
//            if($data['count']>0){
//             
//                $resultado = $this->RegistrarArchivo($data,$dataUser);
//                //var_dump($resultado);
//                if($resultado==TRUE){
//                $mensaje['descripcion'] = "Se registró el ticket satisfactoriamente.";
//                $mensaje['clase']       = "success";
//                }else{
//                    $mensaje['descripcion'] = $resultado;
//                    $mensaje['clase']       = "warning";
//                }
//            }else{
//                $mensaje['descripcion'] = "Se registró el ticket satisfactoriamente.";
//                $mensaje['clase']       = "success";
//            }           

        }else{
            $mensaje['descripcion'] = "Hubo un error al registrar el Ticket, si persiste, comuníquese con el administrador, o envíe un correo a: luis.burgos@aliada.com.pe, buen día, Dios lo bendiga";
            $mensaje['clase']       = "danger";
        }           
//        $Mensaje -> MostrarMensaje($dataUser,$mensaje);
        
        
    }
    
}
