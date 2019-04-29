<?php

include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class TicketView extends Pagina{
    
    public function MostrarCartas($dataUser){
        
        $data['titulo'] = "Cartas";
        $data['js']     = "tabla-dinamica datepicker";
        $data['dataUser'] = $dataUser;
        $dataUser['menu'] = "CartasDeGarantia";

        $this->MostrarHead($data);
        ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="../st_includes/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<!--  <script src="../st_includes/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>-->
  <style>
      .modal-body{
        max-height: calc(100vh - 210px);
        overflow-y: auto;
      }
  </style>
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
                
                CargarCartasDeGarantia();                
                
                $("#registrar").click(function() {

                    var usuario = $("#usuario").val();
                        nombre  = $("#nombre").val();
                        seguro  = $("#seguro").val();
                        fecha   = $("#datepicker").val();
                        estado  = $("#estado").val();
                        carta   = $("#carta").val();
                   //console.log(usuario);

                        LimpiarCampos();

                    $("#CartasDeGarantia").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loading.gif' /> Registrando</center>");
                        $.ajax({
                            type:       'POST',
                            dataType:   'html',
                            url:        '../st_ModuloCartasDeGarantia/getCartas.php',
                            data:       {registrar_carta:'registrar_carta', usuario: usuario, nombre:nombre, seguro:seguro, fecha:fecha, estado: estado, carta:carta},
                            success: function(wait_for_confirmation){
                                $("#CartasDeGarantia").html(wait_for_confirmation);
                            }
                        }); 
                });     
                
                function CargarCartasDeGarantia(){
                    //console.log(1);
                   $("#CartasDeGarantia").load("../st_ModuloCartasDeGarantia/getCartas.php",{'mostrar_cartas': 'mostrar_cartas',usuario_id:usuario_id});
                }
                
        
                function LimpiarCampos(){

                    document.getElementById("usuario").value="";
                    document.getElementById("nombre").value="";
                    document.getElementById("seguro").value="";
                    document.getElementById("datepicker").value="";
                    document.getElementById("estado").value="";
                    document.getElementById("carta").value="";

                }                
                
                var intercal = setInterval(function()
                {
                 CargarCartasDeGarantia();
                },10000);   
//                
//                $(function(){
//                    //Date picker
//                    $('#datepicker').datepicker({ format: 'yyyy-mm-dd', autoclose: true})
//                })
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $(function() {
                    $('.pop').on('click', function() {
                        //$('.imagepreview').attr('src', $(this).find('img').attr('src'));
                        $('#imagemodal').modal('show');   
                    });		
                });
                
                $("#buscar_paciente").click(function(){
                    var nombre = $("#buscar_nombre").val();
                    //alert(codigo);
                    $("#resultado_buscar_paciente").html("<img height='100%' class='img img-responsive center-block' src='../st_includes/img/loading.gif' /> <p class='text-center'>Buscando: "+nombre+" </p><img class='img img-responsive center-block' src='../st_includes/img/logo_aliada.png'>");
                        $.ajax({
                            type:       'POST',
                            dataType:   'html',
                            url:        '../st_ModuloCartasDeGarantia/getCartas.php',
                            data:       {buscar_paciente:'buscar_paciente', nombre: nombre},
                            success: function(wait_for_confirmation){
                                $("#resultado_buscar_paciente").html(wait_for_confirmation);
                            }
                        }); 
                });

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
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-2 ">
                         <div class="form-group">                             
                            <button type="submit" id="buscar" class="btn btn-info pop">Buscar</button>
                         </div>
                        </div>
                    </div>
                    <div class="row">                                                                         
                      <div class="col-xs-1">
                         <div class="form-group">
                          <label>Usuario</label>
                          <input readonly="" type="text" class="form-control" id="usuario" placeholder="Usuario">
                         </div>
                      </div>
                      <div class="col-xs-2">
                        <div class="form-group">
                          <label>Nombre</label>                          
                          <input readonly="" type="text" class="form-control"  id="nombre" placeholder="Nombre y Apellido">
                        </div>
                      </div>
                      <div class="col-xs-2">
                         <div class="form-group">
                          <label>Seguro</label>                          
                        <input readonly="" type="text" class="form-control" id="seguro" placeholder="Compañia de Seguro">
                         </div>
                      </div>
                      <div class="col-xs-2">
                         <div class="form-group">
                          <label>Fecha Registro</label>
                          <input type="text" class="form-control pull-right" placeholder="Fecha de Registro" id="datepicker">                          
                         </div>
                      </div>
                      <div class="col-xs-2">
                        <div class="form-group">
                          <label>Estado</label>
                          <select id="estado" class="form-control">
                            <option value="1">Aprobado</option>
                            <option value="2">Observado</option>
                            <option value="3">Rechazado</option>
                          </select>
                        </div>                                                    
                      </div>
                      <div class="col-xs-2">
                        <div class="form-group">
                          <label>N° Carta</label>                          
                          <input type="text" class="form-control" id="carta" placeholder="N° Carta">
                        </div>
                        </div>
                        <div class="col-xs-1 ">
                         <div class="form-group">
                             <label style="color:white"> . </label> 
                            <button type="submit" id="registrar" class="btn btn-warning">Registrar</button>
                         </div>
                        </div>                        
                    </div>                     
                </div>              
            </div>
            <!-- /.box-header -->
            <!-- form start -->
     
              <div class="box-body">
                <div id="CartasDeGarantia"></div>                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                  
              </div>
           
          </div>
          <!-- /.box -->
          
                        <div class="modal fade bs-example-modal-lg" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">  
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <br>
                                    <div class="col-xs-3 col-xs-offset-1">
                                        <div class="form-group">
                                            <h4 class="modal-title text-right" id="gridSystemModalLabel"><u>Buscar Paciente: </u></h4>    
                                        </div>
                                            
                                    </div>
                                    
                                    <div class="col-xs-5">
                                        <div class="form-group">
                                            
                                            <input type="text" class="form-control" required="required" id="buscar_nombre">
                                        </div>
                                    </div>
                                    <div class="col-xs-2 ">
                                        <div class="form-group">
                                            <button id="buscar_paciente" class="btn btn-success">Buscar</button>
                                        </div>
                                    </div>  
                                
                            </div>                                
                            <div class="modal-body">

                                <div id="resultado_buscar_paciente">
                                    <img class="img img-responsive center-block" src="../st_includes/img/logo_aliada.png">
                                </div>
                               
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              <!--<button type="button" class="btn btn-primary">Asignar</button>-->
                            </div>                                
                            </div>
                          </div>
                        </div>             

        </div>
        <!--/.col (left) -->
        
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
            <?php
        
    }
    
}