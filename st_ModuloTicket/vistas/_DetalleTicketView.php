<?php

include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class DetalleTicketView extends Pagina{

    public function MostrarDetalleTicketView($data,$dataUser){
        //var_dump($data);
        $data['titulo'] = "Detalle Ticket";
        $data['js']     = "select2";
        $dataUser['menu'] = "Ticket";

        $this->MostrarHead($data);
        ?>
<!--        <script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>-->
        <?php
        $this->MostrarHeader($dataUser);
        $this->MostrarMenu($dataUser);
        $this->MostrarPagina($data,$dataUser);
        $this->MostrarFooter();
        $this->MostrarControlesPage();

        $this->MostrarScripts($data);
        
        $ticket_id = $data['id'];
        ?>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
            <script>
                $(document).on('ready',function(){

                    var usuario_id = $("#usuario_id").val();
                    var ticket_id  = $("#ticket_id").val();
                        
                    CargarComentarios();

                    $("#registrar").click(function(){
                            
                             var comentario = $("#comentario").val();

                            $("#comentarios").html("<br><center><img class='img img-responsive' width='10%' src='../st_includes/img/loading.gif' /> Cargando comentarios</center>");
                                $.ajax({
                                type: "POST",
                                dataType: 'html',
                                url: "../st_ModuloTicket/getTicket.php",                               
                                data: {"comentario":comentario,"ticket_id":ticket_id,"usuario_id":usuario_id},
                                //data: "comentario="+comentario+"&ticket_id="+ticket_id+"&usuario_id="+usuario_id,
                                success: function(resp){
                                    $('#comentarios').html(resp);
                                    CargarComentarios();
                                    LimpiarCajaComentarios();
                                }
                            });

                    });
                    
                    $("#asignar_administrador").change(function () {	 
			
                            var admin_id =$(this).val();
                                usuario_id = $("#usuario_id").val();
                                ticket_id= $("#ticket_id").val();
                                
                            $("#resultado_asignar_admin_to_ticket").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loader.gif' /> Asignando administrador a ticket</center>");
                                $.ajax({
                                    type:       'POST',
                                    dataType:   'html',
                                    url:        '../st_ModuloTicket/getTicket.php',
                                    data:       {admin_id:admin_id, usuario_id: usuario_id,ticket_id:ticket_id},
                                    success: function(respuesta){
                                        $("#resultado_asignar_admin_to_ticket").html(respuesta);
                                    }
                                });                          
                            
			});                    


                    $("#marcar_como_resuelto").click(function(){
                        var ticket_id = $("#ticket_id").val();
                        var usuario_id = $("#usuario_id").val();
                    var confirmation = confirm("¿Desea Marcar este ticket como resuelto?");
                        if(confirmation){
                            $("#esperar_confirmacion").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loading_pacman.gif' /> Esperando confirmación de usuario</center>");
                                $.ajax({
                                    type:       'POST',
                                    dataType:   'html',
                                    url:        '../st_ModuloTicket/getTicket.php',
                                    data:       {confirmar_resuelto:'confirmar_resuelto', usuario_id: usuario_id,ticket_id:ticket_id},
                                    success: function(wait_for_confirmation){
                                        $("#esperar_confirmacion").html(wait_for_confirmation);
                                    }
                                });                          
                        
                        }
             
                    });
                    
                    function LimpiarCajaComentarios(){
                      
                      document.getElementById("comentario").value = "";
                    } 

                    function CargarComentarios(){
                        $("#comentarios").load("../st_Moduloticket/getTicket.php",{'action': 'MostrarComentarios','ticket_id':'<?php echo $ticket_id?>'});   
                    }                    

                    var intercal = setInterval(function()
                    {
                      CargarComentarios();
                      VerEstadoTicekt();
                    },1000);          
                    
                    //Cambiar de estado:  Resuelto y no resuelto
                    function VerEstadoTicekt(){
                        var estado_id = $("#estado_id").val();
                            ticket_id = $("#ticket_id").val();
                        //$("#estado_resultado").load("../st_ModuloTicket/getTicket.php",{cambio_estado:'cambio_estado',ticket_id:ticket_id,estado_id:estado_id});
                        $("#estado_ticket").load("../st_ModuloTicket/getTicket.php",{estado_ticket:'estado_ticket',ticket_id:ticket_id,estado_id:estado_id});
                    }
                    
                    function 
                    $("#btn_resuelto").click(function(){
                        var ticket_id = $("#ticket_id").val();
                        var usuario_id = $("#usuario_id").val();
                        
                        confirmado = confirm('¿Está seguro de marcar este Ticket como resuelto?');
                        
                        if(confirmado){
                            $("#estado_resultado").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loader.gif' /> Cerrando Ticket.</center>");
                                $.ajax({
                                    type:       'POST',
                                    dataType:   'html',
                                    url:        '../st_ModuloTicket/getTicket.php',
                                    data:       {btn_resuelto:'btn_resuelto', usuario_id: usuario_id,ticket_id:ticket_id},
                                    success: function(wait_the_solution){
                                        $("#estado_resultado").html(wait_the_solution);
                                    }
                                });                         
                        }
                        
                    });
                });
               
            </script>
            
            <!--<script src="script.js"></script>-->         
            
        <?php 
      
    }
    
    public function MostrarPagina($data,$dataUser){
        //var_dump($data);
        $administradores = isset($data['administradores'])?$data['administradores']:NULL;        //var_dump(mysqli_fetch_array($administradores));
        if(isset($data['adminAsignado'])){$admin_asignado  = $data['adminAsignado']; }
        ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

      <?php $this->MostrarTitulo($data)?>
      <hr>
    <!-- Main content -->
    <section class="content">
    
        <?php //$this->MostrarDatosDashboard()?>
        <?php //$this->MostrarInformacionAdicionalDashboard()?>
        
     <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $data['asunto']?></h3>

              <!--
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>-->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                    <!--<p class="text-center">
                    <strong>Comentarios</strong>
                    </p>-->
                    <form role="form" name="comentario" onsubmit="return false" action="return false">
                      <div class="box-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Comentario</label>
                          <!-- id="editor" -->
                          <textarea  class="form-control" id="comentario" name="comentario" placeholder="Añadir un comentario"></textarea>
                              <!--
                                <script>
                                    ClassicEditor
                                        .create( document.querySelector( '#editor' ), {
                                            cloudServices: {
                                                tokenUrl: 'https://38087.cke-cs.com/token/dev/bCf6jRWU7AS6Wv8YwGP3VMwORVJPZECIYrVYHu9rdNdhre68qzxVmgoqN4Q2',
                                                uploadUrl: 'https://38087.cke-cs.com/easyimage/upload/'
                                            }
                                        } )
                                        .catch( error => {
                                            console.error( error );
                                        }  );                                    
                                </script>-->
                        </div>

                    <!--    <div class="form-group">
                           
                                <label for="exampleInputFile">Adjuntar Archivo</label>
                                <input type="file" id="exampleInputFile">

                                <p class="help-block">opcional</p>                                

                        </div>-->

                      </div>
                      <!-- /.box-body -->

                      <div class="box-footer">
                        <center>
                            <input type="hidden" id="usuario_id" value="<?php echo $dataUser['usuario_id']?>">
                            <input type="hidden" id="ticket_id"  value="<?php echo $data['id']?>">
                            <input type="hidden" id="estado_id"  value="<?php echo $data['estado_id']?>">
                            
                            <button id="registrar" name="enviar_comentario" class="btn btn-success">Enviar</button>
                        </center>
                      </div>
                    </form>
                 
                    <div id="comentarios">
                        
                    </div>

            
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                    <div class="box box-solid">
                      <div class="box-header with-border">
                        <i class="fa fa-gears fa-spin"></i>

                        <h3 class="box-title">Información del Ticket</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <dl>
                          <dt>Registrado por:</dt>
                          <dd><?php echo utf8_encode($data['autor'])?></dd>
                          <dt>Fecha:</dt>
                          <dd><?php echo $this->FormatoFecha($data['fechaRegistro']).' | '. substr($data['fechaRegistro'], 11,5) ?></dd>                          
                          <dt>Código de Ticket:</dt>
                          <dd><?php echo $data['codigo']?></dd>
                          <dt>Descripción:</dt>
                          <dd><?php echo utf8_encode($data['descripcion'])?></dd>
                          <dt>Lugar:</dt>
                          <dd><?php echo utf8_encode($data['lugar'])?></dd>     
                          <?php
                          if($dataUser['usuario_tipo']==1){
                              ?>
                          <dt>Registrado desde la IP:</dt>
                          <dd><?php echo utf8_encode($data['ip_registro'])?></dd>    
                                  <?php
                          }
                          ?>
                        </dl>
                      </div>
                      <!-- /.box-body -->
                      
                    </div> 
                    <div class="box box-solid">
                      <div class="box-header with-border">
                        <i class="fa fa-user"></i>

                        <h3 class="box-title">Detalles de la solución:</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                          <?php
                                                    
                          if($dataUser['usuario_tipo']==1){//admin
                             /////////////////////////////////////////////////////                        
                                if(!is_null($administradores)){
                                    ?>
                          <div id="resultado_asignar_admin_to_ticket">
                                <dl>
                                  <?php 
                                  if($data['estado_id']==1 || $data['estado_id']==2){?>
                                  <dt>Asignar a:<br><?php //echo $admin_asignado['texto_estado']?>
                                      <?php
                                      if(isset($data['asignado_a_usuario_id'])){
                                          ?>
                                            <select class="selectpicker show-tick" name="admin" id="asignar_administrador" data-size="6">
                                                 <option value="0"> - - - </option>
                                                 <?php 
                                                 while($admin = mysqli_fetch_array($administradores)){ ?>
                                                     <option <?php echo ($data['asignado_a_usuario_id']==$admin['id']?'selected="selected"':'')?> value="<?php echo $admin['id']?>"> <?php echo utf8_encode($admin['admin'])?></option>
                                                     <?php
                                                         }
                                                     ?>
                                            </select>                                              
                                              <?php
                                      }else{
                                          ?>
                                            <select class="selectpicker show-tick" name="admin" id="asignar_administrador" data-size="6">
                                                   <option value="0"> - - - </option>
                                                   <?php 
                                                   while($admin = mysqli_fetch_array($administradores)){ ?>
                                                       <option value="<?php echo $admin['id']?>"> <?php echo utf8_encode($admin['admin'])?></option>
                                                       <?php
                                                           }
                                                       ?>
                                               </select>                                                 
                                              <?php
                                      }                                      
                                      ?>
                                  </dt><?php }?>
                                  <div id="resultado_asignar_admin_to_ticket">
                                      <dt><?php echo $admin_asignado['texto_estado']?></dt>
                                      <?php                                       
                                      if($data['estado_id']==1){?>
                                      <dd><span class="label label-danger">Aún no asignado.</span></dd><?php
                                      }else{?>                                
                                      <dd><?php echo "<p class='text-green'>".utf8_encode($data['administrador'])."</p>"?></dd>
                                      <dt>Fecha:</dt>
                                      <dd><?php echo $this->FormatoFecha($admin_asignado['fechaAsignado'])?> | <?php echo substr($admin_asignado['fechaAsignado'], 11,5)?></dd>
                                      <dt>Estado de la solución:</dt>                                
                                            <?php if($data['estado_id']==2){?>
                                      <dd><span class="label label-warning">En progreso</span></dd>
                                           <br>
                                            <div class="progress progress-sm active">
                                              <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                <span class="sr-only">40% Complete (success)</span>
                                              </div>
                                            </div>   
                                            <hr>
                                            <div id="esperar_confirmacion">                                                                 
                                                <button style="width: 100%" id="marcar_como_resuelto" class="btn  btn-success">Marcar como resuelto</button>
                                            </div>
                                            <?php }
                                            else if($data['estado_id']==3){
                                                ?>

                                                <div class="alert alert-info">
                                                  <h4><i class="icon fa fa-info"></i> Buen trabajo!</h4>
                                                  Esperando confirmación del usuario.
                                                </div> 
         
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-12 control-label">Confirmar la atención del Ticekt:</label>
                </div>

              </div>
              <!-- /.box-body -->
              
              <div class="box-footer pull-right">
                <button type="submit" class="btn btn-default">Sigue sin Resolver</button>
                <button type="submit" class="btn btn-success">Sí, está Resuelto</button>
              </div>
                
              <!-- /.box-footer -->
                                            

                                            <?php
                                            }
                                            else if($data['estado_id']==4){
                                                ?>
                                            <dd><span class="label label-success">Resuelto</span></dd>
                                                    <?php
                                            }
                                      }
                                      ?>
                                  </div>

                              </dl>           
                              </div>
                                        <?php
                                }else{                              
                                    ?>
                                <dl>
                                    <dt>Asigar a: </dt>
                                    <dd><span class="label label-danger">No hay administradores registrados</span></dd>                              
                                </dl>                          
                                        <?php                              
                                }
                          //////////////////////////////////////////////////////////////////
                          
                          }else{//usuario
                              
                              ?>
                          <dl>
                              <div id="detalle_solucion"></div>                              
                                <dt><?php echo $admin_asignado['texto_estado']?></dt>
                                 <div id="estado_resultado">
                                  <?php if($data['estado_id']==1){?>                          
                                <dd><span class="label label-danger">Aún no ha sido asignado</span></dd>
                                            <?php
                                    }
                                    elseif($data['estado_id']>=2 && $data['estado_id']<=4){?>                          
                                    <dd><?php echo "<p class='text-green'>".utf8_encode($data['atendido_por_usuario_id']!=$data['asignado_a_usuario_id']?$data['administrador_atendio']:$data['administrador'])."</p>"?></dd>                         
                                    <dt>Fecha:</dt>    
                                            <?php if($data['estado_id']==2){
                                                ?>                                    
                                      <dd><?php echo $this->FormatoFecha($admin_asignado['fechaAsignado'])?> | <?php echo substr($admin_asignado['fechaAsignado'], 11,5)?></dd>                                            
                                      <dt>Estado de la solución:</dt>                                                                         
                                                  <dd><span class="label label-warning">En progreso</span></dd>
                                                  <br>
                                                  <div class="progress progress-sm active">
                                                    <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                      <span class="sr-only">40% Complete (success)</span>
                                                    </div>
                                                  </div>   
                                                    <?php
                                            }else if($data['estado_id']==3){?>                                    
                                      <dd><?php echo $this->FormatoFecha($admin_asignado['fechaAtendido'])?> | <?php echo substr($admin_asignado['fechaAtendido'], 11,5)?></dd>                                            
                                      <dt>Estado de la solución:</dt>                                                                                       
                                                  <dd><span class="label label-primary">Atendido</span></dd>
                                                  <dd class="attachment-block">El Administrador ha marcado el ticket como resuelto.</dd>
                                                  <div class="progress progress-sm active">
                                                    <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                                      <span class="sr-only">95% Complete (success)</span>
                                                    </div>
                                                  </div>  
                                                  
                                                   <!-- //////////////////////////////// -->
                                                      <div class="box-body">
                                                        <div class="form-group">
                                                          <label class="col-sm-12 control-label">Confirmar la atención del Ticekt, por favor:</label>
                                                        </div>

                                                      </div>
                                                      <!-- /.box-body -->

                                                      <div class="box-footer pull-right">
                                                          <button type="submit" id="btn_sin_resolver" class="btn btn-default">Sigue sin Resolver</button>
                                                          <button type="submit"   id="btn_resuelto"  class="btn btn-success">Sí, está Resuelto</button>
                                                      </div>
                                                      <!-- /.box-footer -->
                                                   <!-- ///////////////////////////////// -->                                       
                                                <?php }
                                             else if($data['estado_id']==4){?>
                                                 <dd><span class="label label-success">Resuelto</span></dd>
                                             <?php  } 
                                    }
                                    ?>
                                      </div><!-- fin de estado resultado -->
                                     </dl>   
                                        <?php 
                                }
                                ?>
                         
                      </div>
                      <!-- /.box-body -->
                    </div>                      
 
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
      <!-- row -->
      <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
              
              <div id="comentarios"></div>
       
          </ul>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->                
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>   
        
 

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->        
  
  <script>
  
  </script>
            <?php
    }
}

