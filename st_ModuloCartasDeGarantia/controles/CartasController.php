<?php
include_once("../st_ModuloSeguridad/controles/RecursosController.php");
class CartasController extends RecursosController{
    
    public function RegistrarCarta(){
        
        include_once('../st_ModuloCartasDeGarantia/entidades/CartaEntity.php');
        $cartaEntity = new CartaEntity();
        
            $data['usuario']    = $_POST['usuario'];
            $data['nombre']     = $_POST['nombre'];
            $data['seguro']     = $_POST['seguro'];
            $data['fecha']      = $_POST['fecha'];
            $data['estado']     = $_POST['estado'];
            $data['carta']      = $_POST['carta'];   
        
        if($cartaEntity->Registrar($data)){
            
             $this->MostrarRegistros();
            

        }else{
            echo "Error al registrar";
        }
        
    }
    
    public function MostrarCartas(){
        
        $dataUser=$this->getUsuario();
                       
        include_once('../st_ModuloCartasDeGarantia/vistas/CartasView.php');
        $CartasView = new TicketView();
        $CartasView ->MostrarCartas($dataUser)    ;    
        
    }
    
    public function MostrarCartasGrilla(){
        
        $dataUser=$this->getUsuario();

        include_once('../st_ModuloCartasDeGarantia/entidades/CartaEntity.php');
        $cartaEntity = new CartaEntity();   
        
        $data = $cartaEntity->ObtenerRegistros();

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
        $data['cartas'] = $CartaEntity->BuscarCartasDePaciente($_POST['persona']);
        $data['persona'] = $_POST['persona'];
        $data['nombre']  = $_POST['nombre'];        
        
        include_once('../st_ModuloCartasDeGarantia/vistas/Partials/MostrarCartasDeGarantiaDePacientePartials.php');
        $MostrarCartasDeGarantiaPartials = new MostrarCartasDeGarantiaDePacientePartials();
        $MostrarCartasDeGarantiaPartials ->MostrarCartasDePaciente($data,$dataUser);
             
    }
    
}