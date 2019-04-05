<?php 

include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class PartialsComentarios extends Pagina {
    
    public function MostrarComentarios($comentario,$dataUser){    
        ?>
      <!-- row -->
      <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
              <?php
              
              if(!is_null($comentario)){
                  
                  ////////////////////
              $i=0;
              //while($comentario = mysqli_fetch_array($comentarios)){
              for($i==0;$i<count($comentario); $i++){
                  $fecha[$i] = $this->FormatoFecha($comentario[$i]['fechaRegistro']);
                  if($i==0){                  
                  ?>
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-red">
                    <?php echo $fecha[$i];?>
                  </span>
            </li>
            <!-- /.timeline-label -->                 
                  <?php }else{
     //var_dump($fecha[$i]);
                      if(isset($fecha[$i-1]) && $fecha[$i]!=$fecha[$i-1]){
                          ?>
                    <!-- timeline time label -->
                    <li class="time-label">
                          <span class="bg-red">
                            <?php echo $fecha[$i] = $this->FormatoFecha($comentario[$i]['fechaRegistro']);?>
                          </span>
                    </li>
                    <!-- /.timeline-label -->              
            <?php
                      }
                  }
                  
                  
                  ?>
                        <!-- timeline item -->
            <li>
              <i class="fa fa-user <?php echo $fa=($comentario[$i]['tipo_id']=='1'?'bg-orange':'bg-blue')?>"></i>

              <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> <?php echo substr($comentario[$i]['fechaRegistro'], 11,5)?></span>

                  <h3 class="timeline-header"><a href="#"><?php echo $comentario[$i]['nombre']." ".utf8_encode($comentario[$i]['apellido'])?></a> comentó</h3>

                <div class="timeline-body">
                    <?php echo utf8_encode($comentario[$i]['comentario'])?>
                </div>
                <!--    
                <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs">Read more</a>
                  <a class="btn btn-danger btn-xs">Delete</a>
                </div>-->
              </div>
            </li>
            <!-- END timeline item -->
            <?php
                           
              }//fin de for                  
                  ///////////////////
                  
              }
                            
              ?>

          </ul>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->        
            <?php
        
    }
}

?>
