<?php
include_once("../st_ModuloSeguridad/controles/RecursosController.php");
class CartasController extends RecursosController{
    
    public function RegistrarCarta(){
        
        include_once('../st_ModuloCartasDeGarantia/entidades/CartaEntity.php');
        $cartaEntity = new CartaEntity();
        
            $data['usuario']        = $_POST['usuario'];
            $data['paciente']       = $_POST['paciente'];
            $data['nombrePaciente'] = $_POST['nombrePaciente'];
            $data['IdEmpresaAseguradora']= $_POST['IdAseguradora'];
            $data['aseguradora']    = $_POST['aseguradora'];
            $data['fechaRegistro']  = $_POST['fechaRegistro'];
            $data['estado_id']      = $_POST['estado_id'];
            $data['nrocarta']       = $_POST['nrocarta'];
            $data['tratamiento']    = $_POST['tratamiento'];
            $data['esUrgente']      = $_POST['esUrgente'];
            $data['IdGarantia']     = $_POST['IdGarantia'];
        
        if($cartaEntity->Registrar($data)){
            //echo "Registrado";
            $this->MostrarCartasGrilla();
            

        }else{
            echo "Error al registrar";
        }
        
    }
    
    public function MostrarCartas(){
        
        $dataUser=$this->getUsuario();

//////////////////////////        
        include_once('../st_ModuloCartasDeGarantia/entidades/CartaEntity.php');
        $cartaEntity = new CartaEntity();   
        $data['estados'] = $cartaEntity->ObtenerEstadosDeCartas();
//////////////////////////
                       
        include_once('../st_ModuloCartasDeGarantia/vistas/CartasView.php');
        $CartasView = new TicketView();
        $CartasView ->MostrarCartas($data,$dataUser)    ;    
        
    }
    
    public function MostrarCartasGrilla(){
        
        $dataUser=$this->getUsuario();

        include_once('../st_ModuloCartasDeGarantia/entidades/CartaEntity.php');
        $cartaEntity = new CartaEntity();   
        
        $data['registros'] = $cartaEntity->ObtenerRegistros();
        $data['estados'] = $cartaEntity->ObtenerEstadosDeCartas();

        include_once('../st_ModuloCartasDeGarantia/vistas/partials/MostrarCartasDeGarantiaPartials.php');
        $MostrarCartasPartials = new MostrarCartasDeGarantiaPartials();
        $MostrarCartasPartials ->MostrarCartas($data,$dataUser);

    }
    
    public function BuscarPaciente(){
        
        $dataUser=$this->getUsuario();
 
        include_once('../st_ModuloCartasDeGarantia/entidades/CartaEntity.php');
        $cartaEntity = new CartaEntity();   
        
        $data = $cartaEntity ->BuscarPaciente(addslashes($_POST['nombre']), $dataUser);

        include_once('../st_ModuloCartasDeGarantia/vistas/partials/MostrarResultadoBusquedaPartials.php');
        $MostrarResultadoBusquedaPartials = new MostrarResultadoBusquedaPartials();
        $MostrarResultadoBusquedaPartials ->ResutladoBusqueda($data,$dataUser);
        
    }
    
    public function BuscarCartasDePaciente(){
        
        $dataUser = $this->getUsuario();
              
        include_once('../st_ModuloCartasDeGarantia/entidades/CartaEntity.php');
        $CartaEntity = new CartaEntity();
        $data['cartas'] = $CartaEntity->BuscarCartasDePaciente($_POST['paciente']);
        $data['paciente'] = $_POST['paciente'];
        $data['nombrePaciente']  = $_POST['nombrePaciente'];
        $data['fecha']   = date("Y-m-d H:i:s");
        
        include_once('../st_ModuloCartasDeGarantia/vistas/Partials/MostrarCartasDeGarantiaDePacientePartials.php');
        $MostrarCartasDeGarantiaPartials = new MostrarCartasDeGarantiaDePacientePartials();
        $MostrarCartasDeGarantiaPartials ->MostrarCartasDePaciente($data,$dataUser);
             
    }
    
    public function MostrarResultadosCartaPaciente(){
        
        $dataUser = $this->getUsuario();
        
        $data['IdAseguradora']  = $_REQUEST['IdAseguradora'];
        $data['aseguradora']    = $_REQUEST['aseguradora'];
        $data['nombrePaciente'] = $_REQUEST['nombrePaciente'];
        $data['paciente']       = $_REQUEST['paciente'];
        $data['IdGarantia']     = $_REQUEST['IdGarantia'];
        $data['fechaRegistro']  = $_REQUEST['fecha'];
        
        include_once('../st_ModuloCartasDeGarantia/vistas/partials/LlenarFormularioDeRegistroPartials.php');
        $FormReg = new LlenarFormularioDeRegistroPartials();
        $FormReg ->LlenarFormulario($data, $dataUser);

    }
    
    public function ActualizarEstadoCarta(){
        
        $dataUser = $this->getUsuario();        
        
        $data['id']         = $_REQUEST['id'];
        $data['nrocarta']   = $_REQUEST['new_nrocarta'];
        $data['estado_id']  = $_REQUEST['new_estado_id'];
        $data['fechaIngresado']= ($_REQUEST['new_fecha_ingresado']=='')?"fechaRegistro=NULL":"fechaRegistro='".$_REQUEST['new_fecha_ingresado']."'";
        $data['fechaAprobado']= ($_REQUEST['new_fecha_aprobado']=='')?"fechaAprobado=NULL":"fechaAprobado='".$_REQUEST['new_fecha_aprobado']."'";
        $data['tratamiento']= $_REQUEST['new_tratamiento'];
        $data['esUrgente']  = $_REQUEST['new_es_urgente'];
        //$data[]
        
        include_once('../st_ModuloCartasDeGarantia/entidades/CartaEntity.php');
        $cartaEntity = new CartaEntity();   
        
        $data = $cartaEntity ->ActualizarEstadoCarta($data, $dataUser);        
        
    }
    
    public function ActualizarFechaAprobación(){
        
        $dataUser = $this->getUsuario();  
        $data =$this->getDatosTransaccion($dataUser);
        
        $data['id']              = $_REQUEST['id'];
        $data['fechaAprobacion'] = $_REQUEST['fechaAprobacion'];
        
        include_once('../st_ModuloCartasDeGarantia/entidades/CartaEntity.php');
        $cartaEntity = new CartaEntity();   
        
        $cartaEntity ->ActualizarFechaAprobacionCarta($data, $dataUser);
        
        
    }
    
}