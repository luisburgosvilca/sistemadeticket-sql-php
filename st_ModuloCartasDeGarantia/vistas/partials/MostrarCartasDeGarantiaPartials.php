<?php

class MostrarCartasDeGarantiaPartials{
    
    function MostrarCartas($data){
    
        ?>

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Usuario</th>
                  <th>Paciente</th>
                  <th>Compañía</th>
                  <th>Fecha Ingreso</th>
                  <th>Estado</th>
                  <th>N° Carta</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                    if($count=count($data)>0){

                        for($i=0;$i<$count;$i++){
                            ?>
                            <tr>
                              <td><?php echo utf8_encode($data[$i]['usuario'])?></td>
                              <td><?php echo utf8_encode($data[$i]['nombre'])?></td>
                              <td><?php echo utf8_encode($data[$i]['seguro'])?></td>
                              <td><?php echo substr($data[$i]['fecha'],0,10)?></td>
                              <td><?php echo utf8_encode($data[$i]['estado'])?></td>
                              <td><?php echo utf8_encode($data[$i]['carta'])?></td>
                            </tr>                    
                                <?php
                        }                               
                    }else{
                        ?>
                            <tr align='center'>
                                <td colspan="6" ><strong>No hay registros</strong></td>
                            </tr>
                            <?php
                    }
                ?>            
               <tfoot>
                <tr>
                  <th>Usuario</th>
                  <th>Paciente</th>
                  <th>Compañía</th>
                  <th>Fecha Ingreso</th>
                  <th>Estado</th>
                  <th>N° Carta</th>
                </tr>
                </tfoot>
              </table>            

        <?php
        
    }
}