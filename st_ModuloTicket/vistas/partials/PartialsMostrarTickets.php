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
                        if($ticket[$i]['administrador'] == "No asignado"){
                            
                            $p="<p class= 'tachado'> No asignado</p>";
                        }else{
                            $p= utf8_encode($ticket[$i]['administrador']);
                        }
                        
                        switch ($ticket[$i]['estado_id']){
                        case 1: $estado='<span class="label label-danger">Registrado</span>';break;
                        case 2: $estado='<span class="label label-warning">Asignado</span>';break;
                        case 3: $estado='<span class="label bg-blue">Por confirmar</span>';break;
                        case 4: $estado='<span class="label label-success">Resuelto</span>';break;
                            default : $estado='<span class="label label-info">Hubo un error en el registro</span>';
                        }
                            
                            ?>
                <tr>
                  <td><?php echo ($i+1)?></td>
                  <td>
                      <form name="ver_ticket" action="../st_ModuloTicket/getTicket.php" method="POST">
                          <button type="submit" class="btn btn-warning btn-xs" name="ver_ticket"><i class="fa fa-file-text-o"></i></button>
                          <input type="hidden" name="ticket_id" value="<?php echo $ticket[$i]['id']?>">
                          
                          <?php
                          if($dataUser['usuario_id']==$ticket[$i]['registrado_por_usuario_id']){
                              ?>
                          <button type="submit" class="btn btn-primary btn-xs" name="editar_ticket"><i class="fa fa-pencil"></i></button>
                          <?php
                          }
                          ?>
                      </form>
                  </td>
                  <?php if($dataUser['usuario_tipo']==1){ ?>
                  <td><?php echo ($ticket[$i]['lugar'])?></td>
                  <td><?php echo utf8_encode($ticket[$i]['autor'])?></td>                  
                  <?php }?>
                  <td><?php echo utf8_decode($ticket[$i]['asunto'])?></td>
                  <td><?php echo $this->FormatoFecha($ticket[$i]['fechaRegistro'])?> | <?php echo substr($ticket[$i]['fechaRegistro'],11,5)?></td>
                  <td><?php echo $estado?></td>
                  <td><?php echo $p?></td>
                  <td><?PHP ECHO $ticket[$i]['id']?></td>
                  <td></td>
                  
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
      'autoWidth'   : true
    })
  })
</script>
            <?php
    }
    
}