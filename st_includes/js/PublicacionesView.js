    $(document).ready(function() {
        //1. Cargar Publicaciones
        CargarPublicaciones();
        
    }) ;
    
                function CargarPublicaciones(){
                //console.log(1);
                $("#publicaciones").load("../st_ModuloPublicaciones/getPublicaciones.php",{'mostrar_publicaciones': 'mostrar_publicaciones'});
                }