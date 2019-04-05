<?php

class Principal {
    public function MostrarDashboard(){
        
        include_once('as_Vistas/Home.php');
        $ObjViewHome = new Home;
        $ObjViewHome -> MostrarHome();
        
    }

    public function PanelAutenticacion(){

    	include_once('st_ModuloSeguridad/vistas/FormularioAutenticacion.php');
    	$ObjView = new FormularioAutenticacion;
    	$ObjView -> MostrarFormularioAutenticacion();

    }
}

