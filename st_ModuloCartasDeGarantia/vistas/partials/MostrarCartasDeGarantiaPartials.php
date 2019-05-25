<?php

class MostrarCartasDeGarantiaPartials{
    
    function MostrarCartas($data){
    
        ?>
    <script src="../st_includes/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
            <div class="table-responsive">
                
                <div class="options clearfix">
                    <div class="ck-button">
                        <label><input type="checkbox" value="1" name="acciones" checked="checked"><span>Acciones</span></label>
                    </div>
                    <div class="ck-button">
                        <label><input type="checkbox" value="1" name="usuario" checked="checked"><span>Usuario</span></label>
                    </div>
                    <div class="ck-button">
                        <label><input type="checkbox" value="1" name="paciente" checked="checked"><span>Nombre Paciente</span></label>
                    </div>
                    <div class="ck-button">
                        <label><input type="checkbox" value="1" name="aseguradora" checked="checked"><span>Aseguradora</span></label>
                    </div>
                    <div class="ck-button">
                        <label><input type="checkbox" value="1" name="tratamiento" checked="checked"><span>Tratamiento</span></label>
                    </div>
                    <div class="ck-button">
                        <label><input type="checkbox" value="1" name="fechaingreso" checked="checked"><span>Fecha Ingreso</span></label>
                    </div>
                    <div class="ck-button">
                        <label><input type="checkbox" value="1" name="estado" checked="checked"><span>Estado</span></label>
                    </div>
                    <div class="ck-button">
                        <label><input type="checkbox" value="1" name="fechaaprobado" checked="checked"><span>Fecha Aprobado</span></label>
                    </div>
                    <div class="ck-button">
                        <label><input type="checkbox" value="1" name="nrocarta" checked="checked"><span>N° Carta</span></label>
                    </div>
                    <div class="ck-button">
                        <label><input type="checkbox" value="1" name="urgente" checked="checked"><span>Urgente</span></label>
                    </div>
                </div>                    
              <table id="example1" class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th class="acciones">Acciones</th>
                        <th class="usuario">Usuario</th>                 
                        <th class="paciente">Nombre Paciente</th>                  
                        <th class="aseguradora">Aseguradora</th>
                        <th class="tratamiento">Tratamiento</th>
                        <th class="fechaingreso">Fecha Ingreso</th>
                        <th class="estado">Estado</th>        
                        <th class="fechaaprobado">Fecha Aprobado</th>
                        <th class="tiempoaprobado">Tiempo Aprobación</th>
                        <th class="nrocarta">N° Carta</th>
                        <th class="urgente">Urgente</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                //echo count($data);
                    if($count=count($data['registros'])>0){

                        //for($i=0;$i<$count;$i++)
                        foreach ($data['registros'] as $d){
                            //echo $i;
                            switch ($d['estado_id']){
                            case 4: $estado='<span class="label label-default">Pendiente</span>';   break;//Pendiente    
                            case 8: $estado='<span class="label label-success">Aprobado</span>';    break;//Aprobado
                            case 27: $estado='<span class="label label-warning">Observado</span>';  break;//Observado
                            case 33: $estado='<span class="label label-danger">Rechazado</span>';   break;//Rechazado
                                default : $estado='<span class="label label-info">Hubo un error en el registro</span>';
                            }                            
                            
                            
                            ?>
                            <tr>
                              <td class="acciones" align='center'>
                                                  
                                  <button class="btn bg-orange btn-xs view_activo" id="btnEditPaciente"
                                    data-id="<?php echo $d['id']?>"
                                    data-paciente="<?php  echo $d['paciente']?>"
                                    data-nombrepaciente="<?php echo $d['nombrePaciente']?>"
                                    data-aseguradora="<?php echo $d['aseguradora']?>"
                                    data-nrocarta="<?php echo $d['nrocarta']?>"
                                    data-estado_id="<?php echo $d['estado_id']?>"
                                    data-fecharegistro="<?php echo substr($d['fechaRegistro'],0,16)?>"
                                    data-fechaAprobado="<?php echo $d['fechaAprobado']?>"
                                    data-estado="<?php echo htmlentities($estado)?>"
                                    data-tratamiento="<?php echo utf8_encode($d['tratamiento'])?>"
                                    data-esurgente="<?php echo $cadena = str_replace(' ', '', $d['esUrgente']);?>">                                      
                                      <i class="fa fa-edit"></i>
                                  </button>

                              </td>  
                              <td class="usuario">      <?php echo utf8_encode($d['usuario'])?></td>                             
                              <td class="paciente">     <?php echo utf8_encode($d['nombrePaciente'])?></td>                              
                              <td class="aseguradora">  <?php echo ($d['aseguradora'])?></td>    
                              <td class="tratamiento">  <?php echo utf8_encode($d['tratamiento'])?></td>    
                              <td class="fechaingreso"> <?php echo substr($d['fechaRegistro'],0,16)?></td>
                              <td class="estado">       <?php echo $estado?></td>               
                              <td class="fechaaprobado"><?php if($d['fechaAprobado']==""){
                                  ?>
                                   <button class="btn btn-xs btn-default btn-block" id="btnAprobarCarta"
                                        data-id="<?php echo $d['id']?>"
                                        data-nombrepaciente="<?php echo $d['nombrePaciente']?>">
                                       Aprobar
                                   </button>
                                      <?php
                              }else{
                                  echo substr($d['fechaAprobado'],0,16);
                                  
                              }?>
                              </td>
                              <td class="tiempoaprobado">

                              </td>
                              <td class="nrocarta">     <?php echo utf8_encode($d['nrocarta'])?></td>
                              <td class="urgente text-red" align="center"><?php echo $icono = $cadena=='true'?'<span class="glyphicon glyphicon-alert"></span>':'' ?></td>
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
                        <th class="acciones">Acciones</th>
                        <th class="usuario">Usuario</th>                 
                        <th class="paciente">Nombre Paciente</th>                  
                        <th class="aseguradora">Aseguradora</th>
                        <th class="tratamiento">Tratamiento</th>
                        <th class="fechaingreso">Fecha Ingreso</th>
                        <th class="estado">Estado</th>      
                        <th class="fechaaprobado">Fecha Aprobado</th>
                        <th class="tiempoaprobado">Tiempo Aprobación</th>
                        <th class="nrocarta">N° Carta</th>
                        <th class="urgente">Urgente</th>
                    </tr>
                </tfoot>
              </table> 
              
            </div>
            
            <div class="modal fade bs-example-modal-lg" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                <div class="modal-content">  
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          
<!--                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <h4 class="modal-title" id="gridSystemModalLabel"><u>Datos Paciente: </u></h4>    
                            </div>
                        </div>-->
<!-- ///////////////////////////////////////////////////// -->
                <div class="col-xs-12 col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Paciente</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <strong><i class="fa fa-user-plus margin-r-5"></i> Nombre</strong>

                      <p class="text-muted" id="nombrePacienteModal">                
                      </p>

                      <hr>

                      <strong><i class="fa fa-ambulance margin-r-5"></i> Aseguradora</strong>

                      <p class="text-muted" id="aseguradoraModal"></p>

                      <hr>

                      <strong><i class="fa fa-dashboard margin-r-5"></i> Estado de Carta</strong>

                      <p id="estadoModal"></p>

                    </div>
                    <!-- /.box-body -->
                  </div>           
                </div>

<!-- ///////////////////////////////////////////////////// -->
                    

                </div>                                
                <div class="modal-body">
                    
                    <form>   
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                              <label>Estado</label>
                              <div class='input-group'>
                                <select id="new_estado_id" class="form-control">
                                    <?php 
                                        foreach ($data['estados'] as $estado){

                                            ?>
                                          <option value="<?php echo $estado['estado_id']?>"><?php echo $estado['descripcion']?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-scale"></span>
                                </span>                              
                              </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">    
                            <div class="form-group">
                              <label>N° Carta</label> 
                              <div class='input-group'>
                                <input type="text" class="form-control" id="new_nrocarta" placeholder="N° Carta">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-file"></span>
                                </span>                             
                              </div>
                            </div>
                        </div>                          

                        <div class="col-md-6 col-sm-6">
                          <div class="form-group">
                              <label>Fecha de Ingreso</label>
                              <div class='input-group'>
                                  <input type='text' data-date-format="YYYY-MM-DD HH:mm" placeholder="Fecha ingreso" class="form-control" id="fechaIngresado" />
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                              </div>
                          </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-6">
                          <div class="form-group">
                              <label>Fecha de Aprobación</label>
                              <div class='input-group'>
                                  <input type='text' data-date-format="YYYY-MM-DD HH:mm" placeholder="Fecha ingreso" class="form-control" id="fechaAprobado" />
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                              </div>
                          </div>
                        </div>  

                        <div class="col-md-6 col-sm-6">    
                            <div class="form-group">
                              <label>Tratamiento</label> 
                              <div class='input-group'>
                                <input type="text" class="form-control" id="new_tratamiento" placeholder="Tratamiento">
                                <span class="input-group-addon">
                                    <span class="fa fa-medkit"></span>
                                </span>                             
                              </div>
                            </div>   
                        </div>                           
                        
                        <div class="col-md-6 col-sm-6">    
                            <div class="form-group">
                              <label>Es Urgente</label> 
                              <div class="checkbox">
                                <label>
                                    <input id="new_es_urgente"  type="checkbox">Urgente
                                </label>
                              </div>
                            </div>
                        </div>                         
                        

                    </form>                    

                    <div id="resultado_actualizar_estado_carta_paciente"></div>                                    
                    
                </div>
                    
                <div class="modal-footer">
                    <input type="hidden" id="id_registro" value="">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                  <button type="button" class="btn btn-primary" id="updateEstadoCarta">Actualizar</button>
                </div>                                
                </div>
              </div>
            </div>      

            <div class="modal fade bs-example-modal-lg" id="modalAprobar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                <div class="modal-content">  
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <h4 class="modal-title" id="gridSystemModalLabel"><u>Indicar fecha de Aprobación </u></h4>    
                            </div>

                        </div>
                <div class="col-xs-12 col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Paciente</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <strong><i class="fa fa-user-plus margin-r-5"></i> Nombre</strong>

                      <p class="text-muted" id="nombrePacienteModalUpdate">                
                      </p>

                    </div>
                    <!-- /.box-body -->
                  </div>           
                </div>                  

                </div>                                
                <div class="modal-body">
                    
                    <form>
                        
                      <div class="col-md-6 col-sm-8 col-sm-offset-2 col-md-offset-3">
                        <div class="form-group">
                            <label>Fecha de Aprobación</label>
                            <div class='input-group date fechaAprobacionModal'>
                                <input type='text' data-date-format="YYYY-MM-DD HH:mm" placeholder="Fecha Aprobación" class="form-control" id="fechaAprobacionModalUpdate" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                          <script>
                                $('#fechaAprobacionModalUpdate').datetimepicker();
                                var nuevoCSS = { "padding-bottom": '260px', "font-weight" : 'bold' };
                                $('.fechaAprobacionModal').css(nuevoCSS);

//                                $('#fechaAprobacionModal input').click(function(){
//                                    $('#fechaAprobacionModal').data("DateTimePicker").show();
//                                 });                           
                                 
                                 $('.fechaAprobacionModalUpdate').datetimepicker();
                          </script>

                          
                      </div>
    
                    </form>          
                    
                    <div id="resultadoActualizarFechaAprobacion"></div>
                    
                </div>
                    
                <div class="modal-footer">
                    <input type="hidden" id="registroAprobar" value="">
                  <button type="button" class="btn btn-default fecha_update" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                  <button type="button" class="btn btn-primary" id="btnAprobarCartaUpdate">Guardar</button>
                </div>                                
                </div>
              </div>
            </div>   

        <script>
            ///// Calendarios de PopUp
            $('#fechaIngresado').datetimepicker();
            $('#fechaAprobado').datetimepicker({
                useCurrent: false //Important! See issue #1075
            });

            $("#fechaIngresado").on("dp.change", function (e) {
                $('#fechaAprobado').data("DateTimePicker").minDate(e.date);
            });
            $("#fechaAprobado").on("dp.change", function (e) {
                $('#fechaIngresado').data("DateTimePicker").maxDate(e.date);
            });
            
            ///// 1. Ocultar / Mostrar Columnas
            $("input:checkbox:not(:checked)").each(function() {
                var column = "table ." + $(this).attr("name");
                $(column).hide();
            });

            $("input:checkbox").click(function(){
                var column = "table ." + $(this).attr("name");
                $(column).toggle();
            });                

            ///// 2. Activar DataTable
          $(function () {
            var table = $('#example1').DataTable({
              'colReorder'  : true,
              'paging'      : true,
              'lengthChange': true,
              'searching'   : true,
              'ordering'    : true,
              'info'        : true,
              'autoWidth'   : true,
              'order'       : [[ 5, "desc" ]]   
            })
          })
          
          ///// 3. Editar Carta de Paciente
            //$("button[id=btnEditPaciente]").on("click",function (){
             $('body').on("click", "button[id=btnEditPaciente]", function(e) {
                //alert($(this).data("id"));
                var id              = $(this).data("id");
                var estado_id       = $(this).data("estado_id");
                var estado          = $(this).data("estado");
                var fechaIngresado  = $(this).data("fecharegistro");
                var fechaAprobado   = $(this).data("fechaaprobado");
                var nombrePaciente  = $(this).data("nombrepaciente");
                var aseguradora     = $(this).data("aseguradora");
                var nrocarta        = $(this).data('nrocarta');
                var tratamiento     = $(this).data("tratamiento");
                var esUrgente       = $(this).data("esurgente");
                var check           = esUrgente==true?true:false;
                //alert(fechaAprobado);

//                $('body').on("click", ".view_activo", function(e) {
//                  e.preventDefault();
//                  $('#modal-edit').modal('show');
//                });
                
               $('#modal-edit').modal('show');
                  //alert(id);
                  $("#id_registro").val(id);
                  $("#nombrePacienteModal").html(nombrePaciente);
                  $("#aseguradoraModal").html(aseguradora);
                  $("#new_nrocarta").val(nrocarta);
                  $("#new_tratamiento").val(tratamiento);
                  $("#new_estado_id").val(estado_id);
                  $("#fechaIngresado").val(fechaIngresado);
                  $("#fechaAprobado").val(fechaAprobado);
                  $("#estadoModal").html(estado);
                  $("#new_es_urgente").prop("checked", check);                 
                  
            });    
                        
          ///// 4. Guardar los datos  
            $("#updateEstadoCarta").bind("click",function (){
               var id = $("#id_registro").val(); 
               var new_nrocarta     = $("#new_nrocarta").val();
               var new_estadocarta  = $("#new_estadocarta").val();
               var new_estado_id    = $("#new_estado_id").val();
               var new_fecha_ingresado = $("#fechaIngresado").val();
               var new_fecha_aprobado = $("#fechaAprobado").val();
               var new_tratamiento  = $("#new_tratamiento").val();
               var new_es_urgente   = document.getElementById("new_es_urgente").checked;//$("#new_es_urgente").val();
               //console.log(new_fecha_ingresado);
               
                $("#resultado_actualizar_estado_carta_paciente").html("<center><img height='100%' class='img img-responsive center-block' src='../st_includes/img/loading.gif' /></center>");
                    $.ajax({
                        type:       'POST',
                        dataType:   'html',
                        url:        '../st_ModuloCartasDeGarantia/getCartas.php',
                        data:       {actualizar_estado_carta:'actualizar_estado_carta', id: id, new_nrocarta: new_nrocarta, new_estadocarta: new_estadocarta, new_estado_id:new_estado_id, new_tratamiento:new_tratamiento,new_es_urgente:new_es_urgente, new_fecha_ingresado:new_fecha_ingresado,new_fecha_aprobado:new_fecha_aprobado},
                        success: function(wait_for_confirmation){
                            $("#resultado_actualizar_estado_carta_paciente").html(wait_for_confirmation);
                            CargarCartasDeGarantia();                    
                            //$('#modal-backdrop').modal('hide');
                            $('.modal-backdrop').hide();
                           
                        }
                    });                  
               
            });
            
            ///// 5. Aprobar Carta de Garantía
            $('body').on("click", "button[id=btnAprobarCarta]", function(e) {
                
                var idRegistroAprobar = $(this).data("id");
                var nombrePaciente      = $(this).data("nombrepaciente");
                
                $('#modalAprobar').modal("show");
                    $("#registroAprobar").val(idRegistroAprobar);
                    $("#nombrePacienteModalUpdate").html(nombrePaciente);                                               
                    
            });
            
            ///// 6. Actualizar fecha de aprobación de carta de Garantía
            
            $("#btnAprobarCartaUpdate").on("click", function(){
                var id              = $("#registroAprobar").val();
                var fechaAprobacion = $("#fechaAprobacionModalUpdate").val();
                
                //alert(fechaAprobacion);
                
                $("#resultadoActualizarFechaAprobacion").html("<center><img height='100%' class='img img-responsive center-block' src='../st_includes/img/loading.gif' /></center>");
                    $.ajax({
                        type:       'POST',
                        dataType:   'html',
                        url:        '../st_ModuloCartasDeGarantia/getCartas.php',
                        data:       {actualizarFechaAprobacion:'actualizarFechaAprobacion', id: id, fechaAprobacion: fechaAprobacion},
                        success: function(wait_for_confirmation){
                            $("#resultadoActualizarFechaAprobacion").html(wait_for_confirmation);
                            CargarCartasDeGarantia();                    
                            //$('#modal-backdrop').modal('hide');
                            $('.modal-backdrop').hide();
                           
                        }
                    });                 
                
                
            });
            
          
        </script>
        
        
        <?php
        
    }
}