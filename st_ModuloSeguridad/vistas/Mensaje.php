<?php

include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class Mensaje extends Pagina{
    
    public function MostrarMensaje($dataUser,$data){

        $data['titulo'] = "Mensaje";
        $data['js']     = "" ;
        $dataUser['menu'] = "Ticket";

        $this->MostrarHead($data);
        $this->MostrarHeader($dataUser);
        $this->MostrarMenu($dataUser);
        $this->MostrarPagina($data);
        $this->MostrarFooter();
        $this->MostrarControlesPage();
        $this->MostrarScripts($data);             
    }
    
    public function MostrarPagina($data){
        
        switch ($data['clase']){
        case 'success': $data['icon']='check';
                        $data['title']='Éxito';
                        break;
        case 'warning': $data['icon']='warning';
                        $data['title']='Observaciones en el registro';
                        break;
        case 'danger' : $data['icon']='ban';
                        $data['title']='Hubo un problema';
                        break;
        case 'info'   : $data['icon']='info';
                        $data['title']='Información';
                        break;
            default : $data['icon']='info';
        }
        
        ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

      <?php $this->MostrarTitulo($data)?>
      
    <!-- Main content -->
    <section class="content">
    
        <?php //$this->MostrarDatosDashboard()?>
        <?php //$this->MostrarInformacionAdicionalDashboard()?>
        
        <div class="row">
            <div class="col-md-6">
              <div class="box box-default">
                <div class="box-header with-border">
                  <i class="fa fa-letter"></i>

                  <h3 class="box-title">Mensaje</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="alert alert-<?php echo $data['clase']?> alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-<?php echo $data['icon']?>"></i> <?php echo $data['title']?>!</h4>
                    <?php echo $data['descripcion']?>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->            
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->      
            <?php
        
    }
    
}
