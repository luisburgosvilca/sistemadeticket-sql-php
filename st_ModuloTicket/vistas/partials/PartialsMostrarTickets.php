<?php

include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class PartialsMostrarTickets extends Pagina{
    
    public function MostrarTicekts($ticket,$dataUser){
        ?>
<style type="text/css">
  .tachado{text-decoration:line-through;}
</style>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Código</th>
                  <th>Acciones</th>
                  <?php if($dataUser['usuario_tipo']==1){?>                
                  <th>Lugar</th>
                  <th>Autor</th>
                  <?php }?>
                  <th>Asunto</th>
                  <th>Fecha de Registro</th>
                  <th>Estado</th>
                  <th>Asignado a</th>
                  <th>Fecha Atendido</th>
                  <th>Tiempo de resolución</th>
                  
                </tr>
                </thead>
                <tbody>
                    
                    <?php
                   
                        for($i=0;$i<count($ticket);$i++){                         
                        //var_dump($ticket);
                        if($ticket[$i]['asignado_a'] == "No asignado"){
                            
                            $p="<p class= 'tachado'> No asignado</p>";
                        }else{
                            $p= utf8_encode($ticket[$i]['asignado_a']);
                        }
                        if($ticket[$i]['fechaAtendido']){
                            $fechaAntendido = $this->FormatoFecha($ticket[$i]['fechaAtendido']).' | '.substr($ticket[$i]['fechaAtendido'],11,5);
                        }else{
                            $fechaAntendido= NULL;
                         }
                                                  
                         
//                        var_dump($this->FormatoFecha($ticket[$i]['fechaAtendido']) echo substr($ticket[$i]['fechaAtendido'],11,5));
//                        $fechaAtendido = $this->FormatoFecha($ticket[$i]['fechaAtendido']) echo substr($ticket[$i]['fechaAtendido'],11,5);
                        
                        switch ($ticket[$i]['estado_id']){
                        case 28: $estado='<span class="label label-danger">Registrado</span>';break;
                        case 29: $estado='<span class="label label-warning">Asignado</span>';break;
                        case 30: $estado='<span class="label bg-blue">Por confirmar</span>';break;
                        case 31: $estado='<span class="label label-success">Resuelto</span>';break;
                            default : $estado='<span class="label label-info">Hubo un error en el registro</span>';
                        }
                            
                            ?>
                <tr>
                  <td><?php echo $ticket[$i]['codigo']?></td>
                  <td>
                      <form name="ver_ticket" action="../st_ModuloTicket/getTicket.php" method="POST">
                          <button type="submit" class="btn btn-warning btn-xs" name="ver_ticket"><i class="fa fa-file-text-o"></i></button>
                          <input type="hidden" name="ticket_id" value="<?php echo $ticket[$i]['id']?>">
                          <input type="hidden" name="tipo_id" value="<?php echo $ticket[$i]['ticket_id']?>">
                          <input type="hidden" id="t" name="t" value="<?php echo $dataUser['t']?>" />
                          
                          <?php
                          if($dataUser['USUARIO']==$ticket[$i]['registrado_por_usuario_id']){
                              ?>
                            <!--<button type="submit" class="btn btn-primary btn-xs" name="editar_ticket"><i class="fa fa-pencil"></i></button>-->
                          <?php
                          }
                          ?>
                      </form>
                  </td>
                  <?php if($dataUser['usuario_tipo']==1){ ?>
                  <td><?php echo ($ticket[$i]['lugar'])?></td>
                  <td><?php echo utf8_encode($ticket[$i]['registrado_por'])?></td>                  
                  <?php }?>
                  <td><?php echo ($ticket[$i]['asunto'])?></td>
                  <td><?php echo $this->FormatoFecha($ticket[$i]['fechaRegistro'])?> | <?php echo substr($ticket[$i]['fechaRegistro'],11,5)?></td>
                  <td><?php echo $estado?></td>
                  <td><?php echo $p?></td>
                  <td><?php echo $fechaAntendido?></td>
                  <td><?php echo ($ticket[$i]['tiempo_solucion']==NULL)?'':$this->ObtenerTiempoSolucion($ticket[$i]['tiempo_solucion']) ?></td>
                  
                </tr>
                                   
                    <?php
                    }
                    ?>
                    

                </tbody>
                <tfoot>
                <tr>
                  <th>Código</th>
                  <th>Acciones</th>
                  <?php if($dataUser['usuario_tipo']==1){?>                
                  <th>Lugar</th>
                  <th>Autor</th>
                  <?php }?>                  
                  <th>Asunto</th>
                  <th>Fecha de Registro</th>
                  <th>Estado</th>
                  <th>Asignado </th>
                  <th>Fecha Atendido</th>
                  <th>Tiempo de resolución</th>
                </tr>
                </tfoot>
              </table>
            </div>     

<script>
  $(function () {
    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'order'       : [[ 1, "desc" ]]
      
    })
  })
</script>
            <?php
    }
    
}