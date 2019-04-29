<?php

class MostrarCartasDeGarantiaDePacientePartials{
    
    public function MostrarCartasDePaciente($data,$dataUser){
            //$cartas = $data['cartas'];
        ?>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="../st_includes/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script>

    $("button[id=btnAseguradora]").on("click",function (){
        //alert($(this).data("id"));
        var IdAseguradora = $(this).data("id");
        var aseguradora   = $(this).data("nombre");
        alert(aseguradora);
        var nombrepaciente= <?php echo $data['nombre']?>
        var idPaciente    = <?php echo $data['persona']?>
        alert('->'+IdAseguradora);
        
//        $("#resultado_buscar_carta").html("<img height='100%' class='img img-responsive center-block' src='../st_includes/img/loading.gif' /> <p class='text-center'>Buscando cartas de: "+nombre+"</p><img class='img img-responsive center-block' src='../st_includes/img/logo_aliada.png'>");
//            
//            $.ajax({
//                type:       'POST',
//                dataType:   'html',
//                url:        '../st_ModuloCartasDeGarantia/getCartas.php',
//                data:       {buscar_carta_persona: 'buscar_carta_persona', persona:persona, nombre: nombre},
//                success: function(wait_for_confirmation){
//                    $("#resultado_buscar_carta").html(wait_for_confirmation);
//                }
//            }); 


        
    });
</script>

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Paciente: <?php echo $data['nombre']?> | IdPaciente: <?php echo $data['persona']?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>IdGarantia</th>
                  <th>Fecha de Incio de Garantía</th>
                  <th>Id Empresa Aseguradora</th>
                  <th>Aseguradora</th>
                  <th>Elegir</th>
                </tr>
                </thead>
                <tbody>
        <?php 
                if($count=count($data['cartas'])>0){
                    
                    for($i=0;$i<$count;$i++){
                        ?>
                        <tr>
                          <td><?php echo utf8_encode($data['cartas'][$i]['IdGarantia'])?></td>
                          <td><?php echo date_format($data['cartas'][$i]['FechaInicioGarantia'],"Y-m-d")?></td>
                          <td><?php echo utf8_encode($data['cartas'][$i]['IdEmpresaAseguradora'])?></td>
                          <td><?php echo utf8_encode($data['cartas'][$i]['aseguradora'])?></td>
                          <td><button id="btnAseguradora" class="btn btn-success btn-xs"
                                data-id="<?php echo $data['cartas'][$i]['IdEmpresaAseguradora']?>"
                                data-nombre="<?php echo utf8_encode($data['cartas'][$i]['aseguradora'])?>">
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
                  <th>IdGarantia</th>
                  <th>Fecha de Incio de Garantía</th>
                  <th>Id Empresa Aseguradora</th>
                  <th>Aseguradora</th>
                  <th>Elegir</th>
                </tr>
                </tfoot>
              </table>                   
            </div>
            <!-- /.box-body -->

          </div>
       

            <?php
        
    }
    
}