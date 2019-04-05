<?php

class FormularioAccesoDenegado{
    
    public function MostrarMensajeAutenticacionDenegada($mensaje){
        ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Lockscreen</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../st_includes/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../st_includes/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../st_includes/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../st_includes/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
      <a href="#"><img src="../st_includes/img/logo.jpg" class="img img-responsive"></a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name"><?php echo $user = isset($mensaje['nombre_usuario'])?$mensaje['nombre_usuario']:'<br><br>' ?></div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image" style="<?php echo $estilo = !isset($mensaje['nombre_usuario'])? 'left: -34px;top: -14px;':'' ?>">
        <img src="<?php echo $mensaje['foto']?>" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <?php if(isset($mensaje['nombre_usuario'])){
        ?>
    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials" action="getSecurity.php" method="post">
         
         <input type="hidden" name="username" value="<?php echo $mensaje['username']?>"/>
      <div class="input-group">
          <input type="password" class="form-control" required="" name="password" placeholder="password">
          
        <div class="input-group-btn">
            <button type="submit" name="ingresar" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
       
    </form>
    <!-- /.lockscreen credentials -->    
    <?php
    }?>


  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
      <?php echo $message = isset($mensaje['nombre_usuario'])? $mensaje['descripcion']:"<strong>".$mensaje['descripcion']."</strong>" ?>
          
  </div>
  <div class="text-center">
    <a href="../">Ingrese con un usuario diferente</a>
  </div>
  <div class="lockscreen-footer text-center">
    Copyright &copy; <?php echo date("Y")?> <b><a href="http://10.7.16.3:8080/Intranet/Inicio.jsp" class="text-black">Intranet Aliada</a></b><br>
    All rights reserved
  </div>
</div>
<!-- /.center -->

<!-- jQuery 3 -->
<script src="../st_includes/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../st_includes/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

            <?php
    }
    
}