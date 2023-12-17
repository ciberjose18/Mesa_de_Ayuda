function init(){
}

$(document).ready(function() {

});

$(document).on("click", "#btnsoporte", function () {
    if ($('#rol_id').val()==1){
        $('#lbltitulo').html("Acceso Soporte");
        $('#btnsoporte').html("Acceso Usuario");
        //$('#btnsoporte').attr("href", "#2")
        $("#imgtipo").attr("src","assets/img/2.png");
        $("#btnacceso").attr("class","btn btn-rounded btn-success");
        
        
        $('#rol_id').val(2);
    }else{
        $('#lbltitulo').html("Acceso Usuario");
        $('#btnsoporte').html("Acceso Soporte");
        
        $("#imgtipo").attr("src","assets/img/1.png");
        $("#btnacceso").attr("class","btn btn-rounded btn-primary");
        $('#rol_id').val(1);
    }
});

init();