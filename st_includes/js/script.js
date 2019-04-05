$(document).ready(function(){
  
    Cargar();

    $("#registrar").click(function(){
        var comentario = $("#comentario").val();
            ticket_id  = $("#ticket_id").val();
            usuario_id = $("#usuario_id").val();
        
        $("#resultados").html("<img src='loader.gif' /> Por favor espera un momento");            
        //console.log(ticket_id);
        //$('#datagrid').load('registrar.php'); 
        //Limpiar();
        $.ajax({
        type: "POST",
        dataType: 'html',
        url: "registro.php",
        data: "comentario="+comentario+"&ticket_id="+ticket_id+"&usuario_id="+usuario_id,
        success: function(resp){
            $('#resultados').html(resp);
            Limpiar();
            Cargar();
        }
    });
    });

    function Limpiar(){
        $("#comentario").val("");
    }

    function Cargar(){
        $("#resultados").load("consulta.php");
    }
 
});


/*
window.onload = function () {
    Cargar();    
}
function Registrar()
{
    console.log("bien...!!!");
    var comentario = $("#comentario").val();
    var ticket_id = $("#ticket_id").val();
    var usuario_id  = $("#usuario_id").val();

    $("#resultados").html("<img src="loader.gif" /> Por favor espera un momento");
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "registro.php",
        data: "comentario="+comentario+"&ticket_id="+ticket_id+"&user_id="+usuario_id,
        success: function(resp){
            $('#resultados').html(resp);
            Limpiar();
            Cargar();
        }
    });
}
function Cargar()
{
    $('#datagrid').load('consulta.php');    
}
function Limpiar()
{
    $("#comentario").val("");
}   */