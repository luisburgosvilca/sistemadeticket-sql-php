<?php

include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class TicketView extends Pagina{
    
    public function MostrarTickets($dataUser){
        
        $data['titulo'] = "Tickets";
        $data['js']     = "tabla-dinamica";
        $data['dataUser'] = $dataUser;
        $dataUser['menu'] = "Ticket";

        $this->MostrarHead($data);
        ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="../st_includes/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<?php
        $this->MostrarHeader($dataUser);
        $this->MostrarMenu($dataUser);
        $this->MostrarPagina($data);
        $this->MostrarFooter();
        $this->MostrarControlesPage();
        $this->MostrarScripts($data);
        ?>
        <script>
            $(document).ready(function(){
                var usuario_id = $("#usuario_id").val();
                
                CargarTickets();
                
                function CargarTickets(){
                    //console.log(1);
                   $("#tickets").load("../st_Moduloticket/getTicket.php",{'mostrar_tickets': 'mostrar_tickets',usuario_id:usuario_id});
                }
                
                    var intercal = setInterval(function()
                    {
                     CargarTickets();
                    },10000);                 
            });
        </script>            
        <?php        
        
    }
    
    public function MostrarPagina($data){
        $dataUser = $data['dataUser'];
        ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

      <?php $this->MostrarTitulo($data)?>
      
    <!-- Main content -->
    <section class="content">
    
        <?php          
            include_once('../st_ModuloSeguridad/controles/UsuarioController.php');
            $usuario_ticket = new UsuarioController();    
            $this->MostrarDatosDashboard($usuario_ticket->ObtenerResumenTickets($dataUser))
                    ?>
        <?php //$this->MostrarInformacionAdicionalDashboard()?>
        
        
            
          <div class="box">
            <div class="box-header">
                <form name="nuevo_ticket" action="../st_ModuloTicket/getTicket.php" method="POST">       
                    <input type="hidden" id="usuario_id" value="<?php echo $dataUser['usuario_id']?>" />
                    <h3 class="box-title">Tickets Registrados <input type="submit" name="nuevo_ticket" value="Nuevo" class="btn btn-warning"></h3>
                </form>
            </div>
            <!-- /.box-header -->
            <div id="tickets">                
            </div>
            <!-- /.box-body -->
          </div>            
           
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
            <?php
        
    }
    
}