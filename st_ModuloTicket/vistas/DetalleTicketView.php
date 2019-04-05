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
        
        //$ticket_id = $data['id'];
        ?> 
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/css/bootstrap-select.min.css">
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
                                
                            $("#estado_ticket_admin").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loader.gif' /> Asignando administrador a ticket</center>");
                                $.ajax({
                                    type:       'POST',
                                    dataType:   'html',
                                    url:        '../st_ModuloTicket/getTicket.php',
                                    data:       {admin_id:admin_id, usuario_id: usuario_id,ticket_id:ticket_id},
                                    success: function(respuesta){
                                        $("#estado_ticket_admin").html(respuesta);
                                    }
                                });                          
                            
			});                    


                    $("#marcar_como_resuelto").click(function(){
                        var usuario_id = $("#usuario_id").val();
                        var ticket_id = $("#ticket_id").val();
                        var confirmation = confirm("¿Desea Marcar este ticket como resuelto?");
                        if(confirmation){
                            $("#estado_ticket_admin").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loading_pacman.gif' /> Esperando confirmación de usuario</center>");
                                $.ajax({
                                    type:       'POST',
                                    dataType:   'html',
                                    url:        '../st_ModuloTicket/getTicket.php',
                                    data:       {marcar_resuelto:'marcar_resuelto', usuario_id: usuario_id,ticket_id:ticket_id},
                                    success: function(wait_for_confirmation){
                                        $("#estado_ticket_admin").html(wait_for_confirmation);
                                    }
                                });                                                  
                        }             
                    });
                    
                    $("#confirmar_solucion").click(function(){
                        var usuario_id = $("#usuario_id").val();
                        var ticket_id = $("#ticket_id").val();
                        var confirmation = confirm("¿Desea confirmar la solución de este Ticket?");
                        
                        if(confirmation){
                            $("#estado_ticket_admin").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loading_pacman.gif' /> Esperando confirmación de usuario</center>");
                                $.ajax({
                                    type:       'POST',
                                    dataType:   'html',
                                    url:        '../st_ModuloTicket/getTicket.php',
                                    data:       {confirmar_resuelto:'confirmar_resuelto', usuario_id: usuario_id,ticket_id:ticket_id},
                                    success: function(wait_for_confirmation){
                                        $("#estado_ticket_admin").html(wait_for_confirmation);
                                    }
                                });                            
                        }
                    });
                    
                    function LimpiarCajaComentarios(){
                      
                      document.getElementById("comentario").value = "";
                    } 

                    function CargarComentarios(){
                        var ticket_id = $("#ticket_id").val();
                        $("#comentarios").load("../st_Moduloticket/getTicket.php",{'action': 'MostrarComentarios','ticket_id':ticket_id});   
                    }                    

                    var intercal = setInterval(function()
                    {
                      CargarComentarios();
                      //VerEstadoTicekt();
                    },1000);
                    
                    
                    var interCall = setInterval(function(){
                        VerEstadoTicekt();
                    },7000);
                    
                    //Cambiar de estado:  Resuelto y no resuelto
                    function VerEstadoTicekt(){
                        var estado_id = $("#estado_id").val();
                            ticket_id = $("#ticket_id").val();
                        //$("#estado_resultado").load("../st_ModuloTicket/getTicket.php",{cambio_estado:'cambio_estado',ticket_id:ticket_id,estado_id:estado_id});
                        $("#estado_ticket_admin").load("../st_ModuloTicket/getTicket.php",{estado_ticket_admin:'estado_ticket_admin',ticket_id:ticket_id,estado_id:estado_id});
                    }

                });
               
            </script>
            
            <!--<script src="script.js"></script>-->         
            
        <?php 
      
    }
    
    public function MostrarPagina($data,$dataUser){
        //var_dump($data['administradores']);
        $administradores = isset($data['administradores'])?$data['administradores']:NULL;        //var_dump(mysqli_fetch_array($administradores));
        //if(isset($data['adminAsignado'])){$admin_asignado  = $data['adminAsignado']; }
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
                          <dd><?php echo $this->FormatoFecha(date_format($data['fechaRegistro'], 'Y-m-d H:i:s')).' | '. substr(date_format($data['fechaRegistro'], 'Y-m-d H:i:s'), 11,5) ?></dd>                          
                          <dt>Código de Ticket:</dt>
                          <dd><?php echo $data['codigo']?></dd>
                          <dt>Descripción:</dt>
                          <dd><?php echo utf8_encode($data['descripcion'])?></dd>
                          <dt>Lugar:</dt>
                          <dd><?php echo ($data['lugar'])?></dd>     
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
                          <div id="estado_ticket_admin">
                            <dl> 
                          <?php //admin
                          if($dataUser['usuario_tipo']==1){
                             /////////////////////////////////////////////////////                        
    
                            if($data['estado_id']==1){;?>
                             
                                <dt>Asignar a:</dt><?php //echo (json_decode($administradores)[0]->id)?>
                                <dd>    <select class="selectpicker show-tick" name="admin" id="asignar_administrador" data-size="6">
                                       <option value="0"> - - - </option>
                                       <?php 
                                       //while($admin = sqlsrv_fetch_array($data['administradores'])){
                                            for($i=0;$i<count($administradores);$i++){?>
                                       <option value="<?php echo $administradores[$i]['id']?>"> <?php echo utf8_decode($administradores[$i]['admin'])?></option>
                                           <?php
                                               }
                                           ?>
                                   </select>
                                </dd>
                                <dt>Asignado a:</dt> 
                                <dd><span class="label label-danger">Aún no asignado.</span></dd>                                       
                            <?php }
                            else if($data['estado_id']==2){?>
                                <dt>Asignar a:</dt>
                                <dd>
                                    <select class="selectpicker show-tick" name="admin" id="asignar_administrador" data-size="6">
                                           <option value="0"> - - - </option>
                                           <?php 
                                           //while($admin = mysqli_fetch_array($data['administradores'])){ 
                                                for($i=0;$i<count($administradores);$i++){?>
                                               <option <?php echo ($data['asignado_a_usuario_id']==$administradores[$i]['id']?'selected="selected"':'')?> value="<?php echo $administradores[$i]['id']?>"> <?php echo utf8_encode($administradores[$i]['admin'])?></option>
                                               <?php
                                                   }
                                               ?>
                                    </select>
                                </dd>
                                <dt>Asignado a:</dt>  
                                <dd><?php echo "<p class='text-green'>".utf8_encode($data['administrador'])."</p>"?></dd>                                     
                                <dt>Fecha:</dt>
                                <dd><?php echo $this->FormatoFecha(date_format($data['fechaAsignado'], 'Y-m-d H:i:s'))?> | <?php echo substr(date_format($data['fechaAsignado'], 'Y-m-d H:i:s'), 11,5)?></dd>
                                <dt>Estado:</dt>                                                         
                                <dd><span class="label label-warning">En progreso</span></dd>
                                     <br>
                                      <div class="progress progress-sm active">
                                        <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                          <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                      </div>   
                                      <hr> 

                                      <button style="width: 100%" id="marcar_como_resuelto" class="btn  btn-success">Marcar como resuelto</button>

                            <?php }
                            else if($data['estado_id']==3){
                                ?>                         
                                <dt>Atendido por:</dt>  
                                    <dd><?php echo "<p class='text-green'>".utf8_encode($data['administrador_atendio'])."</p>"?></dd>
                                <dt>Fecha atendido:</dt>
                                <dd><?php echo $this->FormatoFecha(date_format($data['fechaAtendido'], 'Y-m-d H:i:s'))?> | <?php echo substr(date_format($data['fechaAtendido'], 'Y-m-d H:i:s'), 11,5)?></dd>                    
                                <dt>Estado:</dt>
                                    <dd><span class="label bg-blue">Atendido</span></dd> 
                                    <br>
                                    <div class="alert alert-info">
                                      <h4><i class="icon fa fa-info"></i> Buen trabajo!</h4>
                                      Esperando confirmación del usuario.
                                    </div>                         
                                     <div class="progress progress-sm active">
                                       <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                         <span class="sr-only">90% Complete (success)</span>
                                       </div>
                                     </div>       

                                  <div class="form-group">
                                    <label class="col-sm-12 control-label">Confirmar la atención del Ticekt:</label>
                                  </div>

                                    <button id="confirmar_solucion" type="submit" class="btn btn-success">Sí, está Resuelto</button>                        

                                <?php
                            }
                            else if($data['estado_id']==4){
                                ?>
                                    <dt>Resuelto por:</dt>       
                                        <dd><?php echo "<p class='text-green'>".utf8_encode($data['administrador_atendio'])."</p>"?></dd>                        
                                    <dt>Fecha atendido:</dt>
                                    <dd><?php echo $this->FormatoFecha(date_format($data['fechaAtendido'], 'Y-m-d Y:i:s'))?> | <?php echo substr(date_format($data['fechaAtendido'], 'Y-m-d H:i:s'), 11,5)?></dd>                    
                                    <dt>Estado:</dt>
                                        <dd><span class="label label-success">Resuelto</span></dd>
                                    <?php
                            } 
                            ?>
                            
                          
                                    <?php                              
                          //////////////////////////////////////////////////////////////////
                          
                          }else{//usuario
                             
                            if($data['estado_id']==1){?>    
                          
                                <dt>Asignado a:</dt> 
                                <dd><span class="label label-danger">Aún no asignado.</span></dd>                                       
                            <?php }
                            else if($data['estado_id']==2){?>
                                <dt>Asignado a:</dt>  
                                <dd><?php echo "<p class='text-green'>".utf8_encode($data['administrador'])."</p>"?></dd>                                     
                                <dt>Fecha:</dt>
                                <dd><?php echo $this->FormatoFecha(date_format($data['fechaAsignado'], 'Y-m-d H:i:s'))?> | <?php echo substr(date_format($data['fechaAsignado'],'Y-m-d H:i:a'), 11,5)?></dd>
                                <dt>Estado:</dt>                                                         
                                <dd><span class="label label-warning">En progreso</span></dd>
                                     <br>
                                      <div class="progress progress-sm active">
                                        <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                          <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                      </div>   
                                      <hr> 

                                      <button style="width: 100%" id="marcar_como_resuelto" class="btn  btn-success">Marcar como resuelto</button>

                            <?php }
                            else if($data['estado_id']==3){
                                ?>                         
                                <dt>Atendido por:</dt>  
                                    <dd><?php echo "<p class='text-green'>".utf8_encode($data['administrador_atendio'])."</p>"?></dd>
                                <dt>Fecha atendido:</dt>
                                <dd><?php echo $this->FormatoFecha(date_format($data['fechaAtendido'],'Y-m-d H:i:s'))?> | <?php echo substr(date_format($data['fechaAtendido'], 'Y-m-d H:i:s'), 11,5)?></dd>                    
                                <dt>Estado:</dt>
                                    <dd><span class="label bg-blue">Atendido</span></dd> 
                                    <br>
                                    <div class="attachment-block">
                                      <h4><i class="icon fa fa-info-circle"></i> El administrador ha marcado el Ticket como resuelto!</h4>
                                      y espera confirme la solución, para que el Ticket sea cerrado.
                                    </div>                         
                                     <div class="progress progress-sm active">
                                       <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                         <span class="sr-only">90% Complete (success)</span>
                                       </div>
                                     </div>       

                                  <div class="form-group">
                                    <label class="col-sm-12 control-label">Confirmar la solución del Ticekt:</label>
                                  </div>
                                    <!-- agregar botón cancelar -->
                                    <button id="confirmar_solucion" type="submit" class="btn btn-success">Sí, está Resuelto</button>                        

                                <?php
                            }
                            else if($data['estado_id']==4){
                                ?>
                                    <dt>Resuelto por:</dt>       
                                        <dd><?php echo "<p class='text-green'>".utf8_encode($data['administrador_atendio'])."</p>"?></dd>                        
                                    <dt>Fecha atendido:</dt>
                                    <dd><?php echo $this->FormatoFecha(date_format($data['fechaAtendido'], 'Y-m-d H:i:s'))?> | <?php echo substr(date_format($data['fechaAtendido'],'Y-m-d H:i:s'), 11,5)?></dd>                    
                                    <dt>Estado:</dt>
                                        <dd><span class="label label-success">Resuelto</span></dd>
                                    <?php
                            } 

                         }//fin de vista usuario
                         ?>
                            </dl>
                        </div>
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
 
            <?php
    }
}

