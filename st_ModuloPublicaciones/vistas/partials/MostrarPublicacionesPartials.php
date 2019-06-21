<?php

class MostrarPublicacionesPartials{
    
    public function MostrarPublicaciones($data,$dataUser){
            //$cartas = $data['cartas'];
        //var_dump($data['fecha']);
        ?>

        <div class="box">
            <div class="box-header with-border">
                <form action="../st_ModuloPublicaciones/getPublicaciones.php" method="POST">                                    
                    <h3 class="box-title">Lista de publicaciones <button class="btn btn-warning" name="nueva_publicacion" title="Nueva publicación"> Nuevo</button></h3>
                    
                </form>  
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Título</th>
                  <th>Fecha Registro</th>
                  <th>Estado</th>
                  <th>Acciones</th>                  
                </tr>
                </thead>
                <tbody>
        <?php 
                if($count=count($data['registros'])>0){
                    
                    foreach ($data['registros'] as $dat){
                        ?>
                        <tr>
                          <td><?php echo ($dat['IdGarantia'])?></td>
                          <td><?php echo $dat['FechaInicioGarantia']?></td>
                          <td><?php echo ($dat['IdEmpresaAseguradora'])?></td>
                          <td><?php echo ($dat['aseguradora'])?></td>
                          <td><button id="btnAseguradora" class="btn btn-success btn-xs"
                                    data-id="<?php echo $dat['IdEmpresaAseguradora']?>"
                                    data-aseguradora="<?php echo ($dat['aseguradora'])?>"
                                    data-idgarantia="<?php echo ($dat['IdGarantia'])?>"                                    >
                                <i class="fa fa-hand-o-left"></i>
                              </button>
                          </td>
                        </tr>                    
                            <?php
                    }                               
                }else{
                    ?>
                        <tr align='center'>
                            <td colspan="5" ><strong>No hay registros</strong></td>
                        </tr>
                        <?php
                }
        ?>            
                <tfoot>
                <tr>
                  <th>#</th>
                  <th>Título</th>
                  <th>Fecha Registro</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
                </tfoot>
              </table>                   
            </div>
            <!-- /.box-body -->

          </div>

    <?php }
}?>
