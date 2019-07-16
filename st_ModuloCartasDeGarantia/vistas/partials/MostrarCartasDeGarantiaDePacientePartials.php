<?php

class MostrarCartasDeGarantiaDePacientePartials{
    
    public function MostrarCartasDePaciente($data,$dataUser){
            //$cartas = $data['cartas'];
        //var_dump($data['fecha']);
        ?>

<!--<script src="../st_includes/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->
<script>

    $("button[id=btnAseguradora]").bind("click",function (){
        //alert($(this).data("id"));
        
        LimpiarCampos();
        
        var IdAseguradora = $(this).data("id");
        var aseguradora   = $(this).data("aseguradora");
        var CodigoOA    = $(this).data("codigooa"); 
        //alert(CodigoOA);
        var nombrePaciente  = '<?php echo $data['nombrePaciente']?>';
        var paciente        = <?php echo $data['paciente']?>;
        var fecha           = '<?php echo $data['fecha']?>';
               
        //console.log(fecha);
        //alert(fecha);
        
        $("#resultado_buscar_carta").html("<img height='100%' class='img img-responsive center-block' src='../st_includes/img/loading.gif' /> <p class='text-center'>Buscando cartas de: "+nombrePaciente+"</p><img class='img img-responsive center-block' src='../st_includes/img/logo_aliada.png'>");
            
            $.ajax({
                type:       'POST',
                dataType:   'html',
                url:        '../st_ModuloCartasDeGarantia/getCartas.php',
                data:       {mostrar_resultados: 'mostrar_resultados', IdAseguradora:IdAseguradora, aseguradora:aseguradora, CodigoOA: CodigoOA, nombrePaciente:nombrePaciente,paciente:paciente,fecha:fecha},
                success: function(datos_paciente){
                    //$("#resultado_buscar_carta").html(wait_for_confirmation);
                var datos = JSON.parse(datos_paciente);
        
        $.fn.appendVal = function( TextToAppend ) {
		return $(this).val(
			$(this).val() + TextToAppend
		);
	};                    
                    LimpiarCampos();        
                    //alert(datos.fechaRegistro);
                    $('#usuario').appendVal(datos.usuario);
                    $('#paciente').appendVal(datos.paciente);
                    $('#nombrePaciente').appendVal(datos.nombrePaciente);
                    $('#aseguradora').appendVal(datos.aseguradora);
                    $('#IdAseguradora').appendVal(datos.IdAseguradora);
                    $('#CodigoOA').appendVal(datos.CodigoOA);
                    $('#fechaRegistro').appendVal(datos.fechaRegistro);//
                }
            }); 
    
            $('#imagemodal').modal('hide');
            
            return false;
        
    });
    
    function LimpiarCampos(){
        //document.getElementById("usuario").value = "";
        document.getElementById("nombrePaciente").value = "";
        document.getElementById("aseguradora").value = "";
        document.getElementById("IdAseguradora").value = "";
        document.getElementById("paciente").value="";
        document.getElementById("CodigoOA").value="";
        document.getElementById("fechaRegistro").value="";
        
    }
    
    //////////////////
</script>

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Paciente: <?php echo $data['nombrePaciente']?> | IdPaciente: <?php echo $data['paciente']?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>OA</th>
                  <th>Fecha Preparación</th>
                  <th>Fecha Vencimiento</th>                 
                  <th>Aseguradora</th>
                  <th>Elegir</th>
                </tr>
                </thead>
                <tbody>
        <?php 
                if($count=count($data['cartas'])>0){
                    
                    foreach ($data['cartas'] as $dat){
                        ?>
                        <tr>
                          <td><?php echo ($dat['CodigoOA'])?></td>
                          <td><?php echo $dat['FechaInicio']?></td>
                          <td><?php echo ($dat['FechaFinal'])?></td>
                          <td><?php echo ($dat['aseguradora'])?></td>
                          <td><button id="btnAseguradora" class="btn btn-success btn-xs"
                                    data-id="<?php echo $dat['IdEmpresaAseguradora']?>"
                                    data-aseguradora="<?php echo ($dat['aseguradora'])?>"
                                    data-codigooa="<?php echo ($dat['CodigoOA'])?>"                                    >
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
                  <th>OA</th>
                  <th>Fecha Preparación</th>
                  <th>Fecha Vencimiento</th>
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