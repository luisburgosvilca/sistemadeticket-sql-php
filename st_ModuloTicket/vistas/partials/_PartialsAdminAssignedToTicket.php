<?php

include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class PartialsAdminAssignedToTicket extends Pagina{
    
    public function MostrarResultadoAdministradorAsignado($mensaje){
        
        if(is_array($mensaje)){
            ?>
<!--            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/css/bootstrap-select.min.css">-->
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
            <script>
                    $("#marcar_como_resuelto").click(function(){
                        var ticket_id = <?php echo $mensaje['ticket_id']?>;
                        var usuario_id = <?php echo $mensaje['usuario_id']?>;
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
                    
                    $("#asignar_administrador").change(function () {	 
			
                            var admin_id =$(this).val();
                                usuario_id = <?php echo $mensaje['usuario_id']?>;
                                ticket_id= <?php echo $mensaje['ticket_id']?>;
                                
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
            </script>
            <!-- Latest compiled and minified JavaScript --
            <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.1/dist/js/bootstrap-select.min.js"></script>-->            
            <dt>Asignar a:<br>
                <select class="" name="admin" id="asignar_administrador">
                     <option value="0"> - - - </option>
                     <?php 
                     while($admin = mysqli_fetch_array($mensaje['administradores'])){ ?>
                         <option <?php echo ($mensaje['admin_id']==$admin['id']?'selected="selected"':'')?> value="<?php echo $admin['id']?>"> <?php echo utf8_encode($admin['admin'])?></option>
                         <?php
                             }
                         ?>
                </select>                    
                <input type="hidden" id="ticket_idp" value="<?php echo $mensaje['ticket_id']?>">
                <dt>Asignado a:</dt>
                <dd><?php echo $mensaje['descripcion']?></dd>
                <dt>Fecha:</dt>
                <dd><?php echo $this->FormatoFecha($mensaje['fecha'])?> | <?php echo substr($mensaje['fecha'], 11,5)?></dd>
                <dt>Estado de la solución:</dt>
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
                <?php
        }else{
            ?>
                <dt>Asignado a:</dt>
                <dd><?php echo $mensaje?></dd>                
                <?php
        }
        ?>
                         
            <!-- Latest compiled and minified JavaScript -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/js/bootstrap-select.min.js"></script>
             
            <?php
        
    }
    
}