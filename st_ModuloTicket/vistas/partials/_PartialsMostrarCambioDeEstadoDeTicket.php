<?php

include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class PartialsMostrarCambioDeEstadoDeTicket extends Pagina{
    
    public function MostrarCambioDeEstadoDeTicket($data,$dataUser){
        
        if($data['cambio']!=0){
            ?>
              <!--<center><img class='img img-responsive' width='80%' src='../st_includes/img/loader.gif' /> mostrar mensaje.</center>-->
                <?php
        }
        
        if($data['ticket']['estado_id']==28){?>                          
           <dd><span class="label label-danger">Aún no ha sido asignado</span></dd>
                       <?php
               }
               elseif($data['ticket']['estado_id']>=29 && $data['ticket']['estado_id']<=31){?>                          
               <dd><?php echo "<p class='text-green'>".utf8_encode($data['ticket']['asignado_a'])."</p>"?></dd>                         
               <dt>Fecha:</dt>
                 <dd><?php echo $this->FormatoFecha($data['ticket']['fechaAsignado'])?> | <?php echo substr($data['ticket']['fechaAsignado'], 11,5)?></dd>                                            
                 <dt>Estado de la solución:</dt>                                     
                       <?php if($data['ticket']['estado_id']==2){
                           ?>
                             <dd><span class="label label-warning">En progreso</span></dd>
                             <br>
                             <div class="progress progress-sm active">
                               <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                 <span class="sr-only">40% Complete (success)</span>
                               </div>
                             </div>   
                               <?php
                       }else if($data['ticket']['estado_id']==3){?>
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
                        else if($data['ticket']['estado_id']==4){?>
                            <dd><span class="label label-success">Resuelto</span></dd>
                        <?php  } 
               }
                                    
        
    }
    
}
