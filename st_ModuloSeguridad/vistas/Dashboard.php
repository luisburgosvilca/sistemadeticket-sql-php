<?php

/**
 * 
 */
include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class Dashboard extends Pagina
{
	function MostrarDashboard($dataUser){

            $data['titulo'] = "Bienvenidos";
            $data['js']     ="";
            $dataUser['menu'] = "Dashboard";

            $this->MostrarHead($data);
            $this->MostrarHeader($dataUser);
            $this->MostrarMenu($dataUser);
            $this->MostrarPagina($data,$dataUser);
            $this->MostrarFooter();
            $this->MostrarControlesPage();
            $this->MostrarScripts($data);

	}
        
	function MostrarPagina($data,$dataUser){

		?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

      <?php $this->MostrarTitulo($data)?>
      
    <!-- Main content -->
    <section class="content">
    
        <?php 
            include_once('../st_ModuloSeguridad/controles/UsuarioController.php');
            $usuario_ticket = new UsuarioController();    
            
            $this->MostrarDatosDashboard($usuario_ticket->ObtenerResumenTickets())?>
        <?php //$this->MostrarInformacionAdicionalDashboard()?>
        
        <div class="row">
            
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

		<?php

	}
}


?>