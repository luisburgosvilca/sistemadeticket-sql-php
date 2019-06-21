<?php
include_once('../st_ModuloSeguridad/vistas/Pagina.php');
class FormularioNuevaPublicacion extends Pagina{
    
    public function MostrarFormularioNuevaPublicacion($dataUser){
       
        $data['titulo'] = "Nueva Publicación";
        $data['js']     = "";
        $data['dataUser'] = $dataUser;
        $dataUser['menu'] = "Publicaciones";

        $this->MostrarHead($data);
        ?>
        <script src="https://cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>
            <?php
        $this->MostrarHeader($dataUser);
        $this->MostrarMenu($dataUser);
        $this->MostrarPagina($data);
        $this->MostrarFooter();
        $this->MostrarControlesPage();
        $this->MostrarScripts($data);         
        
    }
    
    public function MostrarPagina($data){
        $dataUser = $data['dataUser'];
    ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

      <?php $this->MostrarTitulo($data)?>
      
    <!-- Main content -->
    <section class="content">
        <div class="col-md-10">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Formulario Nueva Publicación</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="getPublicaciones.php" method="POST" enctype="multipart/form-data" autocomplete="off">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Título</label>
                  <input type="text" name="asunto" autofocus="" class="form-control" required="" placeholder="Indique motivo">
                </div>
                <div class="form-group">
                  <label>Resumen</label>
                  <textarea class="form-control" id="editor1" name="descripcion" required=""  placeholder="Descripción"></textarea>
                    <script>
                        CKEDITOR.replace('editor1', {
                            removeButtons: 'Save,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Anchor,Language,Flash,PageBreak,Iframe,ShowBlocks,About'
//                          width: '70%',
//                          height: 500
                        });
                      </script>                  
                </div>
                <div class="form-group">

<!--////////////////////////////////////////////////////////////////////////////////////////////////////////-->

   <!--               <input type="text" name="lugar" class="form-control transparente" placeholder="Lugar de atención">-->
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Adjuntar archivo</label>
                  <input type="file" id="exampleInputFile" multiple="" name="archivo[]" accept="image/*"><!-- accept="image/*,video/*,.pdf,.csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel,application/msword,application/vnd.ms-powerpoint,text/plain" -->

                    <!--<p class="help-block">Limite: 8 mb</p>-->
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                  <button type="submit" name="registrar_publicacion" class="btn btn-primary">Registrar</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

          <!-- Form Element sizes -->

        </div>
        
    </section>
  </div>    
        <?php
        
    }
    
}