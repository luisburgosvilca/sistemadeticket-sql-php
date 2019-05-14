<?php
include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class PartialsMostrarEstadoTicket extends Pagina{

    public function MostrarEstadoDeTicketAdmin($data,$dataUser){
        //var_dump($data);
        $formato = "Y-m-d H:i:s";
        ?>
    <input type="hidden" id="usuario_id" value="<?php echo $data['asignado_a_usuario_id']?>">
    <input type="hidden" id="ticket_id"  value="<?php echo $data['id']?>">
    <input type="hidden" id="sistema_id" value="<?php echo $dataUser['sistema_id']?>"><!-- t: Menu; sistema_id: valor de administrador -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/css/bootstrap-select.min.css">
    <script>
        $("#asignar_administrador").change(function () {
            var admin_id =$(this).val();
                usuario_id = $("#usuario_id").val();
                ticket_id= $("#ticket_id").val();
                sistema_id= $("#sistema_id").val();
                //alert(sistema_id);

            $("#estado_ticket_admin").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loader.gif' /> Asignando administrador a ticket</center>");
                $.ajax({
                    type:       'POST',
                    dataType:   'html',
                    url:        '../st_ModuloTicket/getTicket.php',
                    data:       {admin_id:admin_id, usuario_id: usuario_id,ticket_id:ticket_id, sistema_id:sistema_id},
                    success: function(respuesta){
                        $("#estado_ticket_admin").html(respuesta);
                    }
                });                          

        });
        $("#marcar_como_resuelto").click(function(){
            var ticket_id = $("#ticket_id").val();
            var usuario_id = $("#usuario_id").val();
            var sistema_id= $("#sistema_id").val();
            //console.log(ticket_id);
             confirmation = confirm("¿Desea Marcar este ticket como resuelto?");
            if(confirmation){
                //console.log(ticket_id);
                $("#estado_ticket_admin").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loading_pacman.gif' /> Esperando confirmación de usuario</center>");
                    $.ajax({
                        type:       'POST',
                        dataType:   'html',
                        url:        '../st_ModuloTicket/getTicket.php',
                        data:       {marcar_resuelto:'marcar_resuelto', usuario_id: usuario_id,ticket_id:ticket_id,sistema_id:sistema_id},
                        success: function(wait_for_confirmation){
                            $("#estado_ticket_admin").html(wait_for_confirmation);
                        }
                    });                          

            }

        });
        $("#confirmar_solucion").click(function(){
            var usuario_id = $("#usuario_id").val();
            var ticket_id = $("#ticket_id").val();
            var sistema_id= $("#sistema_id").val();
            var confirmation = confirm("¿Desea confirmar la solución de este Ticket?");

            if(confirmation){
                $("#estado_ticket_admin").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loading_pacman.gif' /> Esperando confirmación de usuario</center>");
                    $.ajax({
                        type:       'POST',
                        dataType:   'html',
                        url:        '../st_ModuloTicket/getTicket.php',
                        data:       {confirmar_resuelto:'confirmar_resuelto', usuario_id: usuario_id,ticket_id:ticket_id,sistema_id:sistema_id},
                        success: function(wait_for_confirmation){
                            $("#estado_ticket_admin").html(wait_for_confirmation);
                        }
                    });                            
            }
        });            
        
        $("#negar_solucion").click(function(){
            var usuario_id  = $("#usuario_id").val();
            var ticket_id   = $("#ticket_id").val();
            var codigo      = $("#codigo").val();
            var asunto      = $("#asunto").val();
            var descripcion = $("#descripcion").val();
            var sistema_id= $("#sistema_id").val();
            
            var confirmation = confirm("¿Informar que no está resuelto el Ticket?");   

            if(confirmation){
                $("#estado_ticket_admin").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loading_pacman.gif' /> Esperando confirmación de usuario</center>");
                    $.ajax({
                        type:       'POST',
                        dataType:   'html',
                        url:        '../st_ModuloTicket/getTicket.php',
                        data:       {negar_resuelto:'negar_resuelto', usuario_id: usuario_id,ticket_id:ticket_id,codigo:codigo,asunto:asunto,descripcion:descripcion,sistema_id:sistema_id},
                        success: function(wait_for_confirmation){
                            $("#estado_ticket_admin").html(wait_for_confirmation);
                        }
                    });                            
            }                        
        });                 
        
        
    </script>
            <?php if($dataUser['usuario_tipo']==1 && ($dataUser['t']==$dataUser['sistema_id'])){
                $administradores = isset($data['administradores'])?$data['administradores']:NULL;
                //var_dump($administradores);
                ?>
            <dl>               
                <?php 
                if($data['estado_id']==28){?>
                <dt>Asignar a:</dt><?php //echo $admin_asignado['texto_estado']?>
                    <dd>    <select class="" name="admin" id="asignar_administrador" data-size="6">
                           <option value="0"> - - - </option>
                           <?php 
                                for($i=0;$i<count($administradores);$i++){?>
                                    <option value="<?php echo $administradores[$i]['USUARIO']?>"> <?php echo utf8_decode($administradores[$i]['admin'])?></option>
                               <?php
                                   }
                               ?>
                       </select>
                    </dd>
                    <dt>Asignado a:</dt> 
                    <dd><span class="label label-danger">Aún no asignado.</span></dd>                                       
                <?php }
                else if($data['estado_id']==29){?>
                    <dt>Asignar a:</dt>
                    <dd>
                        <select class="" name="admin" id="asignar_administrador">
                               <option value="0"> - - - </option>
                               <?php 
                              foreach($administradores as $value){?>
                                   <option <?php echo ($data['asignado_a_usuario_id']==$value['USUARIO']?'selected="selected"':'')?> value="<?php echo $value['USUARIO']?>"> <?php echo utf8_encode($value['admin'])?></option>
                                   <?php
                                       }
                                   ?>
                        </select>
                    </dd>
                        <dt>Asignado a:</dt>  
                        <dd><?php echo "<p class='text-green'>".($data['asignado_a'])."</p>"?></dd>                    
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
                else if($data['estado_id']==30){
                    ?>                         
                    <dt>Atendido por:</dt>  
                        <dd><?php echo "<p class='text-green'>".($data['asignado_a'])."</p>"?></dd>
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
                        <button id="negar_solucion" type="submit" class="btn btn-default">No, no está Resuelto</button>
                        <button id="confirmar_solucion" type="submit" class="btn btn-success">Sí, está Resuelto</button>                        
                        
                    <?php
                }
                else if($data['estado_id']==31){
                    ?>
                        <dt>Resuelto por:</dt>       
                            <dd><?php echo "<p class='text-green'>".($data['atendido_por'])."</p>"?></dd>                        
                        <dt>Fecha atendido:</dt>
                            <dd><?php echo $this->FormatoFecha(date_format($data['fechaAtendido'],"Y-m-d"))?> | <?php echo substr(date_format($data['fechaAtendido'],"Y-m-d H:i:s"), 11,5)?></dd>                    
                        <dt>Estado:</dt>
                            <dd><span class="label label-success">Resuelto</span></dd>
                        <?php
                } 
                ?>                           

            
            <?php }else{//usuario
                             
                            if($data['estado_id']==28){?>    
                          <div id="estado_ticket_usuario">  
                                <dt>Asignado a:</dt> 
                                <dd><span class="label label-danger">Aún no asignado.</span></dd>                                       
                            <?php }
                            else if($data['estado_id']==29){?>
                                <dt>Asignado a:</dt>  
                                <dd><?php echo "<p class='text-green'>".($data['asignado_a'])."</p>"?></dd>                                     
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

                                      <!--<button style="width: 100%" id="marcar_como_resuelto" class="btn  btn-success">Marcar como resuelto</button>-->

                            <?php }
                            else if($data['estado_id']==30){//var_dump($data['atendido_por_usuario_id']);
                                ?>                         
                                <dt>Atendido por:</dt>  
                                    <dd><?php echo "<p class='text-green'>".($data['atendido_por'])."</p>"?></dd>
                                <dt>Fecha atendido:</dt>
                                <dd><?php echo $this->FormatoFecha(date_format($data['fechaAtendido'], $formato))?> | <?php echo substr(date_format($data['fechaAtendido'], $formato), 11,5)?></dd>                    
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
                                    <button id="negar_solucion" type="submit" class="btn btn-default">No, no está Resuelto</button>
                                    <button id="confirmar_solucion" type="submit" class="btn btn-success">Sí, está Resuelto</button>                        

                                <?php
                            }
                            else if($data['estado_id']==31){
                                ?>
                                    <dt>Resuelto por:</dt>       
                                        <dd><?php echo "<p class='text-green'>".($data['atendido_por'])."</p>"?></dd>                        
                                    <dt>Fecha atendido:</dt>
                                    <dd><?php echo $this->FormatoFecha(date_format($data['fechaAtendido'], 'Y-m-d H:i:s'))?> | <?php echo substr(date_format($data['fechaAtendido'], 'Y-m-d H:i:s'), 11,5)?></dd>                    
                                    <dt>Estado:</dt>
                                        <dd><span class="label label-success">Resuelto</span></dd>
                                    <?php
                            }             
             }?></dl>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/js/bootstrap-select.min.js"></script>
            <?php
    }
}

