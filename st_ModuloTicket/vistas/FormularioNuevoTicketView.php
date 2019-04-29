<?php

include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class FormularioNuevoTicketView extends Pagina{
    
    public function MostrarFormularioNuevoTicket($dataUser){
        
        $data['titulo'] = "Nuevo Ticket";
        $data['js']     = "jstree";
        $dataUser['menu'] = "Ticket";

        $this->MostrarHead($data);
        ?>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="../st_includes/jstree/_lib/jquery.js"></script>
	<script type="text/javascript" src="../st_includes/jstree/_lib/jquery.cookie.js"></script>
	<script type="text/javascript" src="../st_includes/jstree/_lib/jquery.hotkeys.js"></script>
	<script type="text/javascript" src="../st_includes/jstree/js/jquery.jstree.js"></script>
	<link type="text/css" rel="stylesheet" href="../st_includes/jstree/_docs/syntax/!style.css"/>
	<link type="text/css" rel="stylesheet" href="../st_includes/jstree/_docs/!style.css"/>
  <script type="text/javascript" src="../st_includes/jstree/_docs/syntax/!script.js"></script>
<script src="//cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>
<!--<script src="../st_includes/js/ckeditor.js"></script>-->
  
  
        <!-- daterange picker --
        <link rel="stylesheet" href="../st_includes/bower_components/bootstrap-daterangepicker/daterangepicker.css">-->
        <!-- bootstrap datepicker --
        <link rel="stylesheet" href="../st_includes/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">-->
        <!-- Select2 --
        <link rel="stylesheet" href="../st_includes/bower_components/select2/dist/css/select2.min.css">-->

        <style>
            .jstree > ul > li{
                font-size: 14px;
                
            }
            .transparente{
                visibility:hidden;
            }

        </style>

<?php
        $this->MostrarHeader($dataUser);
        $this->MostrarMenu($dataUser);
        $this->MostrarPagina($data);
        $this->MostrarFooter();
        $this->MostrarControlesPage();


        ?>
<!-- InputMask --
<script src="../st_includes/plugins/input-mask/jquery.inputmask.js"></script>
<script src="../st_includes/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../st_includes/plugins/input-mask/jquery.inputmask.extensions.js"></script>        
        <script type="text/javascript">--
        //$(document).ready(function () {
            //Disable part of page
        //    $("#demo").on("contextmenu",function(e){
        //        return false;
        //    });
        // });
        </script>       --> 
        <?php
        $this->MostrarScripts($data);              
    }
        
    function MostrarPagina($data){
        ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

      <?php $this->MostrarTitulo($data)?>
      
    <!-- Main content -->
    <section class="content">
    
        <?php //$this->MostrarDatosDashboard()?>
        <?php //$this->MostrarInformacionAdicionalDashboard()?>
        
       
        <div class="col-md-10">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Formulario Nuevo Ticket</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="getTicket.php" method="POST" enctype="multipart/form-data" autocomplete="off">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Asunto</label>
                  <input type="text" name="asunto" class="form-control" required="" placeholder="Indique motivo">
                </div>
                <div class="form-group">
                  <label>Descripción</label>
                  <textarea class="form-control" id="editor1" name="descripcion" required=""  placeholder="Detalle datos del problema"></textarea>
                    <script>
                        CKEDITOR.replace('editor1', {
                            removeButtons: 'Save,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Anchor,Language,Flash,PageBreak,Iframe,ShowBlocks,About'
//                          width: '70%',
//                          height: 500
                        });
                      </script>                  
                </div>
                <div class="form-group">
<!--                  <label >Lugar</label><input type="text" name="lugar_id" class="form-control" required="" placeholder="Indique Lugar"><br>-->
<!--////////////////////////////////////////////////////-->
<!-- the tree container (notice NOT an UL node) -->
<!--<div id="demo" class="demo" style="height:200px;"></div>-->

<input type="hidden" 	name="lugar_id" class="lugar_id" 	value="node_6">

  <script type="text/javascript" class="source below">
    $(function () {

  $("#demo")
    .bind("before.jstree", function (e, data) {
      $("#alog").append(data.func + "<br/>");
    

    })
    .jstree({ 
      // List of active plugins

      "plugins" : [ 
        "themes","json_data","ui","crrm","cookies","dnd","search","types","hotkeys","contextmenu" 
      ],

      // I usually configure the plugin that handles the data first
      // This example uses JSON as it is most common
      "json_data" : {
        // This tree is ajax enabled - as this is most common, and maybe a bit more complex
        // All the options are almost the same as jQuery's AJAX (read the docs)
        "ajax" : {
          // the URL to fetch the data
          "url" : "../st_includes/jstree/server.php",
          // the `data` function is executed in the instance's scope
          // the parameter is the node being loaded 
          // (may be -1, 0, or undefined when loading the root nodes)
          "data" : function (n) { 
            // the result is fed to the AJAX request `data` option
            return { 
              "operation" : "get_children", 
              "id" : n.attr ? n.attr("id").replace("node_","") : 1 
            }; 
          }
        }
      },
      // Configuring the search plugin
      "search" : {
        // As this has been a common question - async search
        // Same as above - the `ajax` config option is actually jQuery's AJAX object
        "ajax" : {
          "url" : "../st_includes/jstree/server.php",
          // You get the search string as a parameter
          "data" : function (str) {
            return { 
              "operation" : "search", 
              "search_str" : str 
            }; 
          }
        }
      },
      // Using types - most of the time this is an overkill
      // read the docs carefully to decide whether you need types
      "types" : {
        // I set both options to -2, as I do not need depth and children count checking
        // Those two checks may slow jstree a lot, so use only when needed
        "max_depth" : -2,
        "max_children" : -2,
        // I want only `drive` nodes to be root nodes 
        // This will prevent moving or creating any other type as a root node
        "valid_children" : [ "drive" ],
        "types" : {
          // The default type
          "default" : {
            // I want this type to have no children (so only leaf nodes)
            // In my case - those are files
            "valid_children" : "none",
            // If we specify an icon for the default type it WILL OVERRIDE the theme icons
            "icon" : {
              "image" : "../st_includes/jstree/img/consultorio.png"
            }
          },
          // The `folder` type
          "folder" : {
            // can have files and other folders inside of it, but NOT `drive` nodes
            "valid_children" : [ "default", "folder" ],
            "icon" : {
              "image" : "../st_includes/jstree/img/casa.png"
            }
          },
          // The `drive` nodes 
          "drive" : {
            // can have files and folders inside, but NOT other `drive` nodes
            "valid_children" : [ "default", "folder" ],
            "icon" : {
              "image" : "../st_includes/jstree/img/clinica.png"
            },
            // those prevent the functions with the same name to be used on `drive` nodes
            // internally the `before` event is used
            "start_drag" : false,
            "move_node" : false,
            "delete_node" : false,
            "remove" : false
          }
        }
      },
      // UI & core - the nodes to initially select and open will be overwritten by the cookie plugin

      // the UI plugin - it handles selecting/deselecting/hovering nodes
      "ui" : {
        // this makes the node with ID node_4 selected onload
        "initially_select" : [ "node_4" ]
      },
      // the core plugin - not many options here
      "core" : { 
        // just open those two nodes up
        // as this is an AJAX enabled tree, both will be downloaded from the server
        "initially_open" : [ "node_2" , "node_3" ] 
      }
    })
  });
  </script>

<!--////////////////////////////////////////////////////////////////////////////////////////////////////////-->

   <!--               <input type="text" name="lugar" class="form-control transparente" placeholder="Lugar de atención">-->
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Adjuntar archivo</label>
                  <input type="file" id="exampleInputFile" multiple="" name="archivo[]"><!-- accept="image/*,video/*,.pdf,.csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel,application/msword,application/vnd.ms-powerpoint,text/plain" -->

                    <!--<p class="help-block">Limite: 8 mb</p>-->
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                  <button type="submit" name="registrar_ticket" class="btn btn-primary">Registrar</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

          <!-- Form Element sizes -->

        </div>            
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
    }
    
}