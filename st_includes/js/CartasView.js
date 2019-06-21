            $(document).ready(function(){
                

                ///// 1. Cargar Cartas de Garantía registradas
                CargarCartasDeGarantia(); 
                
                ///// 2. Registrar Carta selsccionada
                $("#registrar").click(function() {

                    var usuario         = $("#usuario").val();
                        nombrePaciente  = $("#nombrePaciente").val();
                        aseguradora     = $("#aseguradora").val();
                        fechaRegistro   = $("#fechaRegistro").val();
                        fechaAprobado   = $("#fechaAprobado").val();       
                        estado_id       = $("#estado_id").val();
                        nrocarta        = $("#nrocarta").val();
                        tratamiento     = $("#tratamiento").val();
                        esUrgente       = document.getElementById("esUrgente").checked;
                        
                        if(nrocarta===''){
                            nrocarta= '';
                        }
                        
                        IdAseguradora   = $("#IdAseguradora").val();
                        paciente        = $("#paciente").val();
                        IdGarantia      = $("#IdGarantia").val();
                        
                        //console.log(IdAseguradora);
                        //alert(fechaAprobado);

                        if(usuario=='' || nombrePaciente=='' || aseguradora==''){
                            alert('Debe buscar un paciente con carta de garantía');
                        }else{
                            
                            $("#CartasDeGarantia").html("<center><img height='100%' class='img img-responsive center-block' src='../st_includes/img/loading.gif' />  Registrando</center>");
                                $.ajax({
                                    type:       'POST',
                                    dataType:   'html',
                                    url:        '../st_ModuloCartasDeGarantia/getCartas.php',
                                    data:       {registrar_carta:'registrar_carta', usuario: usuario, paciente:paciente, nombrePaciente:nombrePaciente, IdAseguradora:IdAseguradora,aseguradora:aseguradora, fechaRegistro:fechaRegistro,fechaAprobado:fechaAprobado, estado_id: estado_id, nrocarta:nrocarta, tratamiento:tratamiento, esUrgente:esUrgente, IdGarantia:IdGarantia},
                                    success: function(wait_for_confirmation){
                                        $("#CartasDeGarantia").html(wait_for_confirmation);
                                    }
                                }); 
                            LimpiarCampos();                            
                        }
                });     
           
           
                ///// 3. Buscar paciente por nombre (popUp)
                $("#buscar_paciente").click(function(){
                    var nombre = $("#buscar_nombre").val();
                    //console.log(nombre);
                    if(nombre===''){
                        alert('Ingrese un nombre de paciente');
                    }else{
                        //alert(codigo);
                        $("#resultado_buscar_paciente").html("<img height='100%' class='img img-responsive center-block' src='../st_includes/img/loading.gif' /> <p class='text-center'>Buscando: "+nombre+" </p><img class='img img-responsive center-block' src='../st_includes/img/logo_aliada.png'>");
                            $.ajax({
                                type:       'POST',
                                dataType:   'html',
                                url:        '../st_ModuloCartasDeGarantia/getCartas.php',
                                data:       {buscar_paciente:'buscar_paciente', nombre: nombre},
                                success: function(wait_for_confirmation){
                                    $("#resultado_buscar_paciente").html(wait_for_confirmation);
                                }
                            });                         
                    }
                });  
                
                ///// 4. Abrir popUp de Buscar Paciente
                    $('#form_buscar_paciente').click(function() {
                        LimpiarCampos();
                        $('#imagemodal').modal('show');   
                    });	                

                                
                ///// 5. Editar Carta
                

                
            });
                 
            
                function CargarCartasDeGarantia(){
                    //console.log(1);
                   $("#CartasDeGarantia").load("../st_ModuloCartasDeGarantia/getCartas.php",{'mostrar_cartas': 'mostrar_cartas'});
                }
                        
                function LimpiarCampos(){

                    //document.getElementById("usuario").value="";
                    document.getElementById("paciente").value="";
                    document.getElementById("nombrePaciente").value="";
                    document.getElementById("IdAseguradora").value="";
                    document.getElementById("aseguradora").value="";
                    document.getElementById("fechaRegistro").value="";
                    document.getElementById("estado_id").value="8";
                    document.getElementById("nrocarta").value="";
                    document.getElementById("IdGarantia").value="";

                }                
                
                ///// Consulta cada 29 segnudos por las cartas de garantía
//                var intercal = setInterval(function()
//                {
//                 CargarCartasDeGarantia();
//                },29000);
                

                
                
                ///// Ocultar campos en Tabla 
//                  $("input:checkbox:not(:checked)").each(function() {
//                      var column = "table ." + $(this).attr("name");
//                      $(column).hide();
//                  });
//
//                  $("input:checkbox").click(function(){
//                      var column = "table ." + $(this).attr("name");
//                      $(column).toggle();
//                  });      
                  
                  ///// Activa DataTable
//                    $(function () {
//                      var table = $('#example1').DataTable({
//                        'colReorder'  : true,
//                        'paging'      : true,
//                        'lengthChange': true,
//                        'searching'   : true,
//                        'ordering'    : true,
//                        'info'        : true,
//                        'autoWidth'   : true,
//                        'order'       : [[ 4, "desc" ]]
//                      })
//                    })     

