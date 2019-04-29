<?php

class MostrarResultadoBusquedaPartials{
    
    public function ResutladoBusqueda($data,$dataUser){
        //echo count($data);
        ?>
<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>--
<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>-->
<script>
    //var dato = $("#divDireccion").data("direccion");
    //console.log(dato)
    $("button[id=btnPersona]").on("click",function (){
        //alert($(this).data("id"));
        var persona = $(this).data("id");
        var nombre  = $(this).data("nombre");
        //alert(nombre);
        
        $("#CartasDeGarantia").html("<img height='100%' class='img img-responsive center-block' src='../st_includes/img/loading.gif' /> <p class='text-center'>Buscando cartas de: "+nombre+"</p><img class='img img-responsive center-block' src='../st_includes/img/logo_aliada.png'>");
            
            $.ajax({
                type:       'POST',
                dataType:   'html',
                url:        '../st_ModuloCartasDeGarantia/getCartas.php',
                data:       {buscar_carta_persona: 'buscar_carta_persona', persona:persona, nombre: nombre},
                success: function(wait_for_confirmation){
                    $("#resultado_buscar_paciente").html(wait_for_confirmation);
                }
            }); 
        
    });
    
                $(function() {
                    $('.pop').on('click', function() {
                        //$('.imagepreview').attr('src', $(this).find('img').attr('src'));
                        $('#imagemodal').modal('show');   
                    });		
                });
</script>
<!--<div id="divDireccion"
     data-direccion="Calle Lorenzo Higareda"
     data-numero="18"
     data-colonia="tetlan">
      Un div lleno de datas</div>-->

    <div id="resultado_buscar_carta">
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
                                  <button class="btn btn-success btn-xs" id="btnPersona" data-id="<?php echo $persona['persona']?>" data-nombre="<?php echo $persona['nombre']?>">
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

