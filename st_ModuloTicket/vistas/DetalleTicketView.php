<?php

include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class DetalleTicketView extends Pagina{

    public function MostrarDetalleTicketView($data,$dataUser){
        //var_dump($data);
        $data['titulo'] = "Detalle Ticket";
        $data['js']     = "select2";
        $dataUser['menu'] = "Ticket";

        $this->MostrarHead($data);
        ?>
<!--        <script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>-->

        <script src="http://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>
        
  
        <?php
        $this->MostrarHeader($dataUser);
        $this->MostrarMenu($dataUser);
        $this->MostrarPagina($data,$dataUser);
        $this->MostrarFooter();
        $this->MostrarControlesPage();

        $this->MostrarScripts($data);
        
        //$ticket_id = $data['id'];
        ?> 
        <!-- Latest compiled and minified CSS -->
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/css/bootstrap-select.min.css">
<!--        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->   

        <!--<script src="../st_includes/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>-->
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/js/bootstrap-select.min.js"></script>-->  
        
        
            <script>
                $(document).on('ready',function(){

                    var usuario_id = $("#usuario_id").val();
                    var ticket_id  = $("#ticket_id").val();
                        
                    CargarComentarios();

                    $("#registrar").click(function(){
                            
                            var comentario = CKEDITOR.instances.comentario.getData();
                             //var comentario = $("#comentario").val();
                             //console.log("Comentarios: "+comentario);
                             if((comentario)!=""){
                                $("#comentarios").html("<br><center><img class='img img-responsive' width='10%' src='../st_includes/img/loading.gif' /> Cargando comentarios</center>");
                                    $.ajax({
                                    type: "POST",
                                    dataType: 'html',
                                    url: "../st_ModuloTicket/getTicket.php",                               
                                    data: {registrar_comentario: 'registrar_comentario',"comentario":comentario,"ticket_id":ticket_id,"usuario_id":usuario_id},
                                    //data: "comentario="+comentario+"&ticket_id="+ticket_id+"&usuario_id="+usuario_id,
                                    success: function(resp){
                                        $('#comentarios').html(resp);
                                        CargarComentarios();
                                        LimpiarCajaComentarios();
                                    }
                                });
                             }else{
                                 alert("Debe escribir un comentario");
                             }

                    });
                    
                    $("#asignar_administrador").change(function () {
			
                            var admin_id    = $("#asignar_administrador").val();
                                usuario_id  = $("#usuario_id").val();
                                ticket_id   = $("#ticket_id").val();                                
                                //alert(admin_id);
                            $("#estado_ticket_admin").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loader.gif' /> Asignando administrador a ticket</center>");
                                $.ajax({
                                    type:       'POST',
                                    dataType:   'html',
                                    url:        '../st_ModuloTicket/getTicket.php',
                                    data:       {admin_id:admin_id, usuario_id: usuario_id,ticket_id:ticket_id},
                                    success: function(respuesta){
                                        $("#estado_ticket_admin").html(respuesta);
                                    }
                                });
                                CargarComentarios();
                            
			});                    


                    $("#marcar_como_resuelto").click(function(){
                        var usuario_id = $("#usuario_id").val();
                        var ticket_id = $("#ticket_id").val();
                        var confirmation = confirm("¿Desea Marcar este ticket como resuelto?");
                        if(confirmation){
                            $("#estado_ticket_admin").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loading_pacman.gif' /> Esperando confirmación de usuario</center>");
                                $.ajax({
                                    type:       'POST',
                                    dataType:   'html',
                                    url:        '../st_ModuloTicket/getTicket.php',
                                    data:       {marcar_resuelto:'marcar_resuelto', usuario_id: usuario_id,ticket_id:ticket_id},
                                    success: function(wait_for_confirmation){
                                        $("#estado_ticket_admin").html(wait_for_confirmation);
                                    }
                                });                                                  
                        }             
                    });
                    
                    $("#confirmar_solucion").click(function(){
                        var usuario_id = $("#usuario_id").val();
                        var ticket_id = $("#ticket_id").val();
                        var confirmation = confirm("¿Desea confirmar la solución de este Ticket?");
                        
                        if(confirmation){
                            $("#estado_ticket_admin").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loading_pacman.gif' /> Esperando confirmación de usuario</center>");
                                $.ajax({
                                    type:       'POST',
                                    dataType:   'html',
                                    url:        '../st_ModuloTicket/getTicket.php',
                                    data:       {confirmar_resuelto:'confirmar_resuelto', usuario_id: usuario_id,ticket_id:ticket_id},
                                    success: function(wait_for_confirmation){
                                        $("#estado_ticket_admin").html(wait_for_confirmation);
                                    }
                                });                            
                        }
                    });
                    
                    $("#negar_solucion").click(function(){
                        var usuario_id  = $("#usuario_id").val();
                        var ticket_id   = $("#ticket_id").val();
                        var codigo      = $("#codigo").val();
                        var asunto      = $("#asunto").val();
                        var descripcion = $("#descripcion").val();
                        var confirmation = confirm("¿Informar que no está resuelto el Ticket?");   
                        
                        if(confirmation){
                            $("#estado_ticket_admin").html("<center><img class='img img-responsive' width='80%' src='../st_includes/img/loading_pacman.gif' /> Esperando confirmación de usuario</center>");
                                $.ajax({
                                    type:       'POST',
                                    dataType:   'html',
                                    url:        '../st_ModuloTicket/getTicket.php',
                                    data:       {negar_resuelto:'negar_resuelto', usuario_id: usuario_id,ticket_id:ticket_id,codigo:codigo,asunto:asunto,descripcion:descripcion},
                                    success: function(wait_for_confirmation){
                                        $("#estado_ticket_admin").html(wait_for_confirmation);
                                    }
                                });                            
                        }                        
                    });                    
                    
                    function LimpiarCajaComentarios(){
                      
                      //document.getElementById("comentario").value = "";
                      CKEDITOR.instances.comentario.setData('');
                    } 

                    function CargarComentarios(){
                        var ticket_id = $("#ticket_id").val();
                        $("#comentarios").load("../st_Moduloticket/getTicket.php",{'action': 'MostrarComentarios','ticket_id':ticket_id});   
                    }                    

                    var intercal = setInterval(function()
                    {
                      CargarComentarios();
                      //VerEstadoTicekt();
                    },1000);
                    
                    
                    var interCall = setInterval(function(){
                        VerEstadoTicekt();
                    },5000);
                    
                    //Cambiar de estado:  Resuelto y no resuelto
                    function VerEstadoTicekt(){
                        var estado_id = $("#estado_id").val();
                            ticket_id = $("#ticket_id").val();
                        //$("#estado_resultado").load("../st_ModuloTicket/getTicket.php",{cambio_estado:'cambio_estado',ticket_id:ticket_id,estado_id:estado_id});
                        $("#estado_ticket_admin").load("../st_ModuloTicket/getTicket.php",{estado_ticket_admin:'estado_ticket_admin',ticket_id:ticket_id,estado_id:estado_id});
                    }

                    $(function() {
                        $('.pop').on('click', function() {
                                //$('.imagepreview').attr('src', $(this).find('img').attr('src'));
                                $('#imagemodal').modal('show');   
                        });
                    });  
               

                });               
            </script>
            
            <!--<script src="script.js"></script>-->         
            
        <?php 
      
    }
    
    public function MostrarPagina($data,$dataUser){
        //var_dump($data);
             //var_dump(mysqli_fetch_array($administradores));
        if(isset($data['adminAsignado'])){$admin_asignado  = $data['adminAsignado']; }

        ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

      <?php $this->MostrarTitulo($data)?>
      <hr>
    <!-- Main content -->
    <section class="content">
    
        <?php //$this->MostrarDatosDashboard()?>
        <?php //$this->MostrarInformacionAdicionalDashboard()?>
        
     <div class="row">
        <div class="col-md-8">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">#<?php echo $data['codigo']?></h3>
              <div class="box-tools pull-right">
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Previous"><i class="fa fa-chevron-left"></i></a>
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Next"><i class="fa fa-chevron-right"></i></a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="mailbox-read-info">
                <h3><?php echo $data['asunto']?></h3>
                <h5><i class="fa fa-user"></i> <?php echo utf8_encode($data['registrado_por']);//."->".var_dump(date_format($data['fechaRegistro'],"Y-m-d"))?>
                  <span class="mailbox-read-time pull-right"><?php echo $this->FormatoFecha(date_format($data['fechaRegistro'],"Y-m-d")).' | '. substr(date_format($data['fechaRegistro'],"Y-m-d H:i:s"), 11,5) ?></span></h5>
                </div>
              <div class="mailbox-read-message">                
                  <?php echo html_entity_decode(stripslashes($data['descripcion']))?>                
              </div>
            </div>
            <div class="box-footer">
                <?php
                //echo mysqli_num_rows($data['files']);
                //echo count($data['files']);
                if(count($data['files'])>0){                
                    $permitidos = array("png","jpg","jpeg","gif","xbm","xpm","wbmp","webp");
             
                    ?>
                        <ul class="mailbox-attachments clearfix">
                        <?php
                        
                        $j=0;
                        //var_dump($data['files'][0]['url_file']);
                        for($i=0;$i<count($data['files']);$i++){ 
                            $file[$i]['url_file'] = $data['files'][$i]['url_file'];
                            $file[$i]['nombre']   = $data['files'][$i]['nombre'];
                            $file[$i]['size_kb']  = $this->FileSizeConvert($data['files'][$i]['size_kb']);
                            $file[$i]['extension']= $data['files'][$i]['extension'];                        
                            //$file[$i]['extension']= $this->ObtenerExtensionDeArchivo($data['files'][$i]['extension']);
                         if(in_array(strtolower($data['files'][$i]['extension']), $permitidos) || strtolower($data['files'][$i]['extension']=="pdf")){
                             
                        ?>
                            <li>
                                <span class="mailbox-attachment-icon <?php echo ($data['files'][$i]['extension']=="pdf")?"":"has-img" ?>">
                                    <?php if($data['files'][$i]['extension']=="pdf"){
                                        $fa_icon="fa-file-pdf-o";?>
                                    <i class="fa fa-file-pdf-o"></i>
                                    <?php }else{
                                        $fa_icon="fa-camera";?>
                                    <a href="#" class="mailbox-attachment-icon has-img pop"><img src="<?php echo $data['files'][$i]['url_file']?>" alt="Attachment"></a>
                                    <?php }?>
                                </span>

                              <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name pop" data-target=".bs-example-modal-lg"><i class="fa <?php echo $fa_icon?>"></i> <?php echo $file[$i]['nombre']?></a>
                                    <span class="mailbox-attachment-size">
                                      <?php echo $file[$i]['size_kb']?>
                                      <a href="<?php echo $file[$i]['url_file']?>" class="btn btn-default btn-xs pull-right" download="<?php echo $file[$i]['nombre']?>"><i class="fa fa-cloud-download"></i></a>
                                    </span>
            </div>
                            </li>                            
                            
                        <?php                        
                        }else{
                          $otros_files[$j]=$i; 
                          $j++;
                        }
                        //$i++; 
                    }//fin de for
                    //var_dump($file[1]['url_file']);
                        ?>
                        </ul>
                        <ul class="mailbox-attachments clearfix">
                        <?php
                        if(isset($otros_files)){ if(count($otros_files)>0){
                            for($k=0;$k<count($otros_files);$k++){
                                $extension = strtolower($this->ObtenerExtensionDeArchivo($file[$otros_files[$k]]['url_file']));
                                switch ($extension){
                                    case "xls" :
                                    case "xlsx": $fa_icon="fa-file-excel-o";break;
                                    case "doc" :
                                    case "docx": $fa_icon="fa-file-word-o";break;
                                    case "ppt" :
                                    case "pptx": $fa_icon="fa-file-powerpoint-o";break;
                                    case "txt" :
                                    case "rtf" : $fa_icon="fa-file-text-o";break;
                                    case "7z"  :
                                    case "zip" :
                                    case "rar" :
                                    case "gz"  : $fa_icon="fa-file-zip-o";break;
                                    default    : $fa_icon="fa-file";break;
                                }
                            ?>
                            <li>
                                <span class="mailbox-attachment-icon">
                                    <i class="fa <?php echo $fa_icon?>"></i>
                                </span>                                                             
                              <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa <?php echo $fa_icon?>"></i> <?php echo $file[$otros_files[$k]]['nombre']?></a>
                                    <span class="mailbox-attachment-size">
                                      <?php echo $file[$otros_files[$k]]['size_kb']?>
                                      <a href="<?php echo $file[$otros_files[$k]]['url_file']?>" class="btn btn-default btn-xs pull-right" download="<?php echo $file[$otros_files[$k]]['nombre']?>"><i class="fa fa-cloud-download"></i></a>
                                    </span>
                              </div>                                
                            </li>       
                                <?php
                            }
                        }
                        }                        
                        ?>
                        </ul>
                
                        <div class="modal fade bs-example-modal-lg" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">              
                              <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                
                                <center>
                                    <?php
                                    //var_dump($file[0]['url_file']);
                                    foreach ($file as $value ) {                        
                                            //var_dump($value['extension']);
                                        if($value['extension']=="pdf"){?>
                                        <div style="text-align: center;">
                                            <iframe src="<?php echo $value['url_file']?>" 
                                        style="width:80%; height:500px;" frameborder="0"></iframe>
                                        </div>
                                        <hr>                                      
                                        <?php }elseif(in_array(strtolower($value['extension']),$permitidos)){?>
                                        <img class="img-responsive" src="<?php echo $value['url_file']?>" class="imagepreview">
                                        <hr> 
                                        <?php }
                                    }//fin de forach
                                    ?>
                                </center>
                             </div>
                            </div>
                          </div>
                        </div>                                
                            <?php
                    }//fin de num rows
                    
                ?>               
              
            </div>
            <div class="box-footer">
                    <form role="form" name="comentario" onsubmit="return false" action="return false">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Comentario</label>
                          <!-- id="editor" -->
                          <textarea  class="form-control" id="comentario" required="" name="comentario" placeholder="Añadir un comentario"></textarea>
                          <script>
                            CKEDITOR.replace('comentario', {
                               //removeButtons: 'Source,Save,NewPage,Preview,Print,Templates,document,Cut,Copy,Paste,PasteText,PasteFromWord,Find,Replace,SelectAll,Scayt,Subscript,Superscript,RemoveFormat,NumberedList,BulletedList,Outdent,Indent,Blockquote,CreateDiv,JustifyLeft,JustifyCenter,JustifyRight,JustifyBlock,BidiLtr,BidiRtl,Undo,Redo,Language,Link,Unlink,Image,Table,HorizontalRule,Styles,Format,Font,FontSize,TextColor,BGColor,UIColor,Maximize,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Anchor,Flash,PageBreak,Iframe,ShowBlocks,About',
                               toolbar: [
                                { name: 'document', items: [ 'Bold', 'Italic', 'Underline', 'Strike','Smiley' ] }	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
	                           ]
                            });                       
                          </script>
                        </div>

                    <!--    <div class="form-group">
                           
                                <label for="exampleInputFile">Adjuntar Archivo</label>
                                <input type="file" id="exampleInputFile">

                                <p class="help-block">opcional</p>                                

-->
                        <center>
                            <input type="hidden" id="usuario_id" value="<?php echo $dataUser['USUARIO']?>">
                            <input type="hidden" id="ticket_id"  value="<?php echo $data['id']?>">
                            <input type="hidden" id="codigo"     value="<?php echo $data['codigo']?>">
                            <input type="hidden" id="estado_id"  value="<?php echo $data['estado_id']?>">
                            <input type="hidden" id="asunto"     value="<?php echo utf8_encode($data['asunto'])?>">
                            <input type="hidden" id="descripcion" value="<?php echo utf8_encode($data['descripcion'])?>">
                            
                            <button id="registrar" name="enviar_comentario" class="btn btn-success">Enviar</button>
                        </center>

                    </form>
                 
                    <div id="comentarios">
                        
                    </div>
            </div><!-- /box-footer --> 

          </div><!-- box box-warning -->
        </div><!-- col-md-8 -->
        <div class="col-md-3">
            
                    <div class="box box-info">
                      <div class="box-header with-border">
                        <i class="fa fa-gears fa-spin"></i>

                        <h3 class="box-title">Información del Ticket</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <dl>
                          <dt>Lugar:</dt>
                          <dd><?php echo ($data['lugar'])?></dd>     
                          <?php //var_dump($dataUser['usuario_tipo']);
                          if($dataUser['usuario_tipo']==1){
                              ?>
                          <dt>Fecha de Registro:</dt>
                          <dd><?php echo $this->FormatoFecha(date_format($data['fechaRegistro'],"Y-m-d")).' | '. substr(date_format($data['fechaRegistro'],"Y-m-d H:i:s"), 11,5)?></dd>
                          <dt>Registrado desde la IP:</dt>
                          <dd><?php echo utf8_encode($data['ip_registro'])?></dd>    
                                  <?php
                          }
                          ?>
                        </dl>
                      </div>
                      <!-- /.box-body -->
                      
                    </div> 
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <i class="fa fa-users"></i>
                        <h3 class="box-title">Detalles de la solución:</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">            
                          <div id="estado_ticket_admin">
                            <dl> 
                          <?php //admin
                          if($dataUser['usuario_tipo']==1){
                             /////////////////////////////////////////////////////                        
                            $administradores = isset($data['administradores'])?$data['administradores']:NULL;   
                            //var_dump($administradores);
                            //var_dump($data['asignado_a_usuario_id']);
                            //var_dump($data['asignado_a_usuario_id']);
                            if($data['estado_id']==28){?>
                             
                                <dt>Asignar a:</dt>
                                    <?php //var_dump($administradores[0]['admin'])?>
                                <dd>    <select class="selectpicker show-tick" name="admin" id="asignar_administrador" data-size="6">
                                       <option value="0"> - - - </option>
                                        <?php 
                                           foreach($administradores as $value){?>
                                               <option value="<?php echo $value['USUARIO']?>"> <?php echo utf8_decode($value['admin'])?></option>
                                          <?php
                                              }
                                          ?>
                                   </select>
                                </dd>
                                <dt>Asignado a:</dt> 
                                <dd><span class="label label-danger">Aún no asignado.</span></dd>                                       
                            <?php }
                            else if($data['estado_id']==29){?>
                                <dt>Asignar a:</dt>
                                <dd>
                                    <select class="selectpicker show-tick" name="admin" id="asignar_administrador" data-size="6">
                                           <option value="0"> - - - </option>
                                           <?php  
                                           //while($admin = mysqli_fetch_array($data['administradores'])){ 
                                                foreach($administradores as $value){?>
                                               <option <?php echo ($data['asignado_a_usuario_id']==$value['USUARIO']?'selected="selected"':'')?> value="<?php echo $value['USUARIO']?>"> <?php echo utf8_encode($value['admin'])?></option>
                                               <?php
                                                   }
                                               ?>
                                    </select>
                                </dd>
                                <dt>Asignado a:</dt>  
                                <dd><?php echo "<p class='text-green'>".utf8_encode($data['asignado_a'])."</p>"?></dd>                                     
                                <dt>Fecha:</dt>
                                <dd><?php echo $this->FormatoFecha(date_format($data['fechaAsignado'], 'Y-m-d'))?> | <?php echo substr(date_format($data['fechaAsignado'], 'Y-m-d H:i:s'), 11,5)?></dd>
                                <dt>Estado:</dt>                                                         
                                <dd><span class="label label-warning">En progreso</span></dd>
                                     <br>
                                      <div class="progress progress-sm active">
                                        <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                          <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                      </div>
                                     <hr>
                                     <button style="width: 100%" id="marcar_como_resuelto" class="btn  btn-success">Marcar como resuelto</button>
                                     

                            <?php }
                            else if($data['estado_id']==30){
                                ?>                         
                                <dt>Atendido por:</dt>  
                                    <dd><?php echo "<p class='text-green'>".utf8_encode($data['asignado_a_usuario_id'])."</p>"?></dd>
                                <dt>Fecha atendido:</dt>
                                    <dd><?php echo $this->FormatoFecha(date_format($data['fechaAtendido'],"Y-m-d"))?> | <?php echo substr(date_format($data['fechaAtendido'],"Y-m-d H:i:s"), 11,5)?></dd>                    
                                <dt>Estado:</dt>
                                    <dd><span class="label bg-blue">Atendido</span></dd> 
                                    <br>
                                    <div class="alert alert-info">
                                      <h4><i class="icon fa fa-info"></i> Buen trabajo!</h4>
                                      Esperando confirmación del usuario.
                                    </div>                         
                                     <div class="progress progress-sm active">
                                       <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                         <span class="sr-only">90% Complete (success)</span>
                                       </div>
                                     </div>       

                                  <div class="form-group">
                                    <label class="col-sm-12 control-label">Confirmar la atención del Ticekt:</label>
                                  </div>

                                    <button id="negar_solucion" type="submit" class="btn btn-default">No, no está Resuelto</button>                        
                                    <button id="confirmar_solucion" type="submit" class="btn btn-success">Sí, está Resuelto</button>                        

                                <?php
                            }
                            else if($data['estado_id']==31){
                                ?>
                                    <dt>Resuelto por:</dt>       
                                        <dd><?php echo "<p class='text-green'>".utf8_encode($data['atendido_por_usuario_id'])."</p>"?></dd>                        
                                    <dt>Fecha atendido:</dt>
                                        <dd><?php echo $this->FormatoFecha(date_format($data['fechaAtendido'],"Y-m-d"))?> | <?php echo substr(date_format($data['fechaAtendido'],"Y-m-d H:i:s"), 11,5)?></dd>                    
                                    <dt>Estado:</dt>
                                        <dd><span class="label label-success">Resuelto</span></dd>
                                    <?php
                            } 
                            ?>
                            
                          
                                    <?php                              
                          //////////////////////////////////////////////////////////////////
                          
                          }else{//usuario
                             
                            if($data['estado_id']==28){?>    
                          
                                <dt>Asignado a:</dt> 
                                <dd><span class="label label-danger">Aún no asignado.</span></dd>                                       
                            <?php }
                            else if($data['estado_id']==29){?>
                                <dt>Asignado a:</dt>  
                                <dd><?php echo "<p class='text-green'>".utf8_encode($data['asignado_a_usuario_id'])."</p>"?></dd>                                     
                                <dt>Fecha:</dt>
                                <dd><?php echo $this->FormatoFecha(date_format($data['fechaAsignado'], 'Y-m-d H:i:s'))?> | <?php echo substr(date_format($data['fechaAsignado'],'Y-m-d H:i:a'), 11,5)?></dd>
                                <dt>Estado:</dt>                                                         
                                <dd><span class="label label-warning">En progreso</span></dd>
                                     <br>
                                      <div class="progress progress-sm active">
                                        <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                          <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                      </div>   
                            <?php }
                            else if($data['estado_id']==30){
                                ?>                         
                                <dt>Atendido por:</dt>  
                                    <dd><?php echo "<p class='text-green'>".utf8_encode($data['atendido_por_usuario_id'])."</p>"?></dd>
                                <dt>Fecha atendido:</dt>
                                    <dd><?php echo $this->FormatoFecha(date_format($data['fechaAtendido'],"Y-m-d"))?> | <?php echo substr(date_format($data['fechaAtendido'],"Y-m-d H:i:s"), 11,5)?></dd>                    
                                <dt>Estado:</dt>
                                    <dd><span class="label bg-blue">Atendido</span></dd> 
                                    <br>
                                    <div class="attachment-block">
                                      <h4><i class="icon fa fa-info-circle"></i> El administrador ha marcado el Ticket como resuelto!</h4>
                                      y espera confirme la solución, para que el Ticket sea cerrado.
                                    </div>                         
                                     <div class="progress progress-sm active">
                                       <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                         <span class="sr-only">90% Complete (success)</span>
                                       </div>
                                     </div>       

                                  <div class="form-group">
                                    <label class="col-sm-12 control-label">Confirmar la solución del Ticekt:</label>
                                  </div>
                                    <!-- agregar botón cancelar -->
                                    <button id="negar_solucion" type="submit" class="btn btn-default">No, no está Resuelto</button>  
                                    <button id="confirmar_solucion" type="submit" class="btn btn-success">Sí, está Resuelto</button>                        

                                <?php
                            }
                            else if($data['estado_id']==31){
                                ?>
                                    <dt>Resuelto por:</dt>       
                                        <dd><?php echo "<p class='text-green'>".utf8_encode($data['atendido_por_usuario_id'])."</p>"?></dd>                        
                                    <dt>Fecha atendido:</dt>
                                        <dd><?php echo $this->FormatoFecha(date_format($data['fechaAtendido'],"Y-m-d"))?> | <?php echo substr(date_format($data['fechaAtendido'],"Y-m-d H:i:s"), 11,5)?></dd>                    
                                    <dt>Estado:</dt>
                                        <dd><span class="label label-success">Resuelto</span></dd>
                                    <?php
                            } 

                         }//fin de vista usuario
                         ?>
                            </dl>
                        </div>
                      </div>
                      <!-- /.box-body -->
                    </div>                      
 
                </div>
              
       
     </div><!-- /row-->
    </section><!-- fin de section content-->    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->        
 
            <?php
    }
}

