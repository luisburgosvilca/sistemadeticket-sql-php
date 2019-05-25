<?php

class MostrarResultadoBusquedaPartials{
    
    public function ResutladoBusqueda($data,$dataUser){
        // Resultado de Búsqueda de paciente
        ?>
<script>

    $("button[id=btnPersona]").bind("click",function (){
        //alert($(this).data("id"));
        var paciente = $(this).data("paciente");
        var nombrePaciente  = $(this).data("nombrepaciente");
        //alert(paciente);
        
        $("#resultado_buscar_paciente").html("<img height='100%' class='img img-responsive center-block' src='../st_includes/img/loading.gif' /> <p class='text-center'>Buscando cartas de: "+nombrePaciente+"</p><img class='img img-responsive center-block' src='../st_includes/img/logo_aliada.png'>");
            
            $.ajax({
                type:       'POST',
                dataType:   'html',
                url:        '../st_ModuloCartasDeGarantia/getCartas.php',
                data:       {buscar_carta_persona: 'buscar_carta_persona', paciente:paciente, nombrePaciente: nombrePaciente},
                success: function(wait_for_confirmation){
                    $("#resultado_buscar_paciente").html(wait_for_confirmation);
                }
            }); 
    });
    
</script>

    <div id="resultado_buscar_paciente">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Resultados de búsqueda: <?php echo count($data)?> resultados</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                  <thead class="fixed">
                      <tr>
                        <th>Persona</th>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Sexo</th>
                        <th>F. Nacimiento</th>
                        <th>Edad</th>
                        <th>Seleccionar</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php 
                      
                      if(!is_null($data)){
                          $i=0;
                        foreach ($data as $persona) {
                            ?>
                            <tr>
                              <td><?php echo $persona['persona']?></td>
                              <td><?php echo $persona['documento']?></td>
                              <td><?php echo $persona['nombre']?></td>
                              <td><?php echo $persona['sexo']?></td>
                              <td><?php echo $persona['fechanacimiento']?></td>
                              <td><?php echo $persona['edad']?></td>
                              <td>
                                  <button class="btn btn-success btn-xs" id="btnPersona" 
                                          data-paciente="<?php echo $persona['persona']?>" 
                                          data-nombrepaciente="<?php echo $persona['nombre']?>">
                                      <i class="fa fa-hand-o-left"></i>
                                  </button>
                              </td>
                            </tr>                      
                                    <?php
                                $i++;
                        }//fin de for                          
                      }else{
                          ?>
                        <tr align="center">
                            <td colspan="7">No se encontraron resultados</td>                                                        
                        </tr>
                        <tr>
                            <td colspan="7">
                                <img class='img img-responsive center-block' src='../st_includes/img/logo_aliada.png'>
                            </td>
                        </tr>
                              <?php
                      }
                      ?>
                
                  </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </div>  

            <?php
        
    }
    
}

