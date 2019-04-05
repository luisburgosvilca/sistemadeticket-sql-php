                $(document).ready(function(){

                    CargarComentarios(); 

                    $("#registrar").click(function(){

                        var comentario = $("#comentario").val();
                            usuario_id = $("#usuario_id").val();
                            ticket_id  = $("#ticket_id").val();

                            $("#comentarios").html("<br><center><img class='img img-responsive' width='10%' src='../st_includes/img/loading.gif' /> Cargando comentarios</center>");
                                $.ajax({
                                type: "POST",
                                dataType: 'html',
                                url: "../st_ModuloTicket/getTicket.php",                               
                                data: {"comentario":comentario,"ticket_id":ticket_id,"usuario_id":usuario_id},
                                //data: "comentario="+comentario+"&ticket_id="+ticket_id+"&usuario_id="+usuario_id,
                                success: function(resp){
                                    $('#comentarios').html(resp);
                                    CargarComentarios();
                                    LimpiarCajaComentarios();
                                }
                            });

                    });

                    function LimpiarCajaComentarios(){
                      
                      document.getElementById("comentario").value = "";
                    } 

                    function CargarComentarios(){
                        $("#comentarios").load("../st_Moduloticket/getTicket.php",{'action': 'MostrarComentarios','ticket_id':'<?php echo $ticket_id?>'});   
                    }
                           
                });