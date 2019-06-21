<?php

include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class TicketView extends Pagina{
    
    public function MostrarCartas($data,$dataUser){
        
        $data['titulo'] = "Cartas de Garantía";
        $data['js']     = "tabla-dinamica datepicker";
        $data['dataUser'] = $dataUser;
        $dataUser['menu'] = "CartasDeGarantia";

        $this->MostrarHead($data);
        ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="../st_includes/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
  <link rel="stylesheet" href="../st_includes/css/CartasView.css">  
  
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<!--  <script src="../st_includes/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
  <script src="../st_includes/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
  
  

<?php
        $this->MostrarHeader($dataUser);
        $this->MostrarMenu($dataUser);
        $this->MostrarPagina($data);
        $this->MostrarFooter();
        $this->MostrarControlesPage();
        $this->MostrarScripts($data);
        ?>
  
  <script src="../st_includes/js/CartasView.js"></script>    
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
          <div class="box">
            <div class="box-header with-border">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-2 ">
                         <div class="form-group">                             
                             <button id="form_buscar_paciente" class="btn btn-info" title="Buscar paciente"><i class="fa fa-search-plus"></i> Buscar Paciente</button>
                         </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        
                      <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label>Fecha de Ingreso</label>
                            <div class='input-group date'>
                                <input type='text' data-date-format="YYYY-MM-DD HH:mm" placeholder="YYYY-MM-DD HH:mm" class="form-control" id="fechaRegistro" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                      </div>                        

                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label>Paciente</label>
                          <div class='input-group'>
                            <input readonly="" required="" type="text" class="form-control"  id="nombrePaciente" placeholder="Nombre y Apellido">
                            <span class="input-group-addon glyphicon-disabled">
                                <span class="fa fa-user-plus"></span>
                            </span>  
                          </div>
                         </div>
                      </div>
                      <div class="col-md-5 col-sm-6">
                         <div class="form-group">
                          <label>Seguro</label>
                          <div class='input-group'>
                          <input readonly="" type="text" required="" class="form-control" id="aseguradora" placeholder="Compañia de Seguro">
                            <span class="input-group-addon glyphicon-disabled">
                                <span class="fa fa-ambulance"></span>
                            </span>                            
                          </div>
                         </div>
                      </div>
 
                      <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                          <label>Estado</label>
                          <div class='input-group'>
                            <select id="estado_id" class="form-control">
                                <?php 
                                    foreach ($data['estados'] as $estado){
                                        //if($estado['estado_id']==4 && $estado['estado_id'])
                                            {
                                        ?>
                                      <option value="<?php echo $estado['estado_id']?>"><?php echo $estado['descripcion']?></option>
                                        <?php
                                        }
                                    }
                                ?>
                            </select>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-scale"></span>
                            </span>                              
                          </div>
                        </div>                                                    
                      </div>
                      <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label>Fecha Aprobado</label>
                            <div class='input-group date'>
                                <input type='text' data-date-format="YYYY-MM-DD HH:mm" placeholder="YYYY-MM-DD HH:mm" class="form-control" id="fechaAprobado" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                      </div>                           
                      <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                          <label>N° Carta</label> 
                          <div class='input-group'>
                            <input type="text" class="form-control" id="nrocarta" placeholder="N° Carta">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-file"></span>
                            </span>                             
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                          <label>Tratamiento</label> 
                          <div class='input-group'>
                            <input type="text" class="form-control" id="tratamiento" placeholder="Tratamiento">
                            <span class="input-group-addon">
                                <span class="fa fa-medkit"></span>
                            </span>                             
                          </div>
                        </div>
                      </div>
                      <div class="col-md-1 col-sm-6">
                        <div class="form-group">
                          <label>Es Urgente</label> 
                          <div class="checkbox">
                            <label>
                                <input id="esUrgente" type="checkbox">Urgente
                            </label>
                          </div>
                        </div>
                        </div>                        
                        <div class="col-md-2 col-sm-6 ">
                         <div class="form-group">
                             <label style="color:white"> . </label> 
                             <input type="hidden" name="IdAseguradora" id="IdAseguradora" value=""/> 
                             <input type="hidden" name="paciente" id="paciente" value="">
                             <input type="hidden" id="usuario" value="<?php echo $dataUser['USUARIO']?>">
                             <input type="hidden" name="IdGarantia" id="IdGarantia" value="">
                             <br>
                             <button type="submit" id="registrar" class="btn btn-primary btn-block" title="Registrar carta de paciente"><i class="fa fa-h-square"></i> Registrar</button>
                         </div>
                        </div>                        
                    </div>                     
                </div>              
            </div>
            <!-- /.box-header -->
          </div>
        </div>
      </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
            
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

                                <input type="text" id="buscar_nombre" class="form-control" autofocus="" required="required" >
                            </div>
                        </div>
                        <div class="col-xs-2 ">
                            <div class="form-group">
                                <button id="buscar_paciente" class="btn btn-success"><i class="fa fa-search-plus"></i> Buscar</button>
                            </div>
                        </div>  

                </div>                                
                <div class="modal-body">                                      

                    <div id="resultado_buscar_paciente">
                        <img class="img img-responsive center-block" src="../st_includes/img/logo_aliada.png">
                    </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
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