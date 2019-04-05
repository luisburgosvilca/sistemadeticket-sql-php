<?php

class PartialsEsperarConfirmacionDeUsuario {
    
    public function MostrarMensajeEsperarConfirmacionDeUsuario(){
        ?>
            <div class="alert alert-info">
              
              <h4><i class="icon fa fa-info"></i> Buen trabajo!</h4>
              Esperando confirmación del usuario.
            </div>

              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-12 control-label">Confirmar la atención del Ticekt:</label>
                </div>

              </div>
              <!-- /.box-body -->
              
              <div class="box-footer pull-right">
                <button type="submit" id="btn_sin_resolver" class="btn btn-default">Sigue sin Resolver</button>
                <button type="submit" id="btn_resuelto"     class="btn btn-success">Sí, está Resuelto</button>
              </div>
                
              <!-- /.box-footer -->
            <?php
    }
    
    public function MostrarMensajeErrorAlMarcarComoResuelto(){
        ?>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Algo sucedió!</h4>
                Vuelve a intentarlo, si reincide contacta con el administrador.
              </div>            
            <?php
    }
    
}