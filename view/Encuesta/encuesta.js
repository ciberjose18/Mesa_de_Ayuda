function init(){
   
}

$(document).ready(function(){
    var tick_id = getUrlParameter('ID');
    listardetalle(tick_id);
    console.log(tick_id);

    $('#tick_estrellas').on('rating.change', function() {
        console.log($('#tick_estrellas').val());
    });
    
});

function listardetalle(tick_id){
    $.post("../../controller/ticket.php?op=mostrar", { tick_id : tick_id }, function (data) {
        data = JSON.parse(data);
        $("#lblestado").val(data.tick_estado_texto);
        $("#lblnomusuario").val(data.user_nom + " " + data.user_ape);
        $("#lblfechcrea").val(data.fecha_crea);
        $('#lblnomidticket').val(data.tick_id);
        $("#cat_nom").val(data.cat_nom);    
        $("#subc_nom").val(data.subc_nom);
        $("#tick_titulo").val(data.tick_titulo);
        $("#prio_nom").val(data.prio_nom);
        $("#lblfechacierre").val(data.fecha_cierre);

        if (data.tick_estado_texto=='Abierto') {
            window.open('http://localhost/Mesa_de_Ayuda/','_self');
        }else{
            if (data.tick_estrellas==null){

            }else{
                $('#panel1').hide();
            }
        }


    });
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

$(document).on("click","#btnguardar", function(){
    console.log("post");
    var tick_id = getUrlParameter('ID');
    var tick_estrellas = $('#tick_estrellas').val(); 
    var tick_coment = $('#tick_coment').val();

    $.post("../../controller/ticket.php?op=encuesta", { tick_id : tick_id, tick_estrellas:tick_estrellas, tick_coment:tick_coment}, function (data) {
        console.log(data);
        $('#panel1').hide();
        swal("Correcto!", "Gracias por su Tiempo", "success");
    }); 
});