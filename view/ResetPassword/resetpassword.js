console.log("dfdjksndj");
$(document).on("click","#btnenviar", function () {

    var user_email = $("#user_email").val();
    if (user_email.length == 0) {
        swal("Error!", "Campo Vacio", "error");
        
    } else {
        $.post("../../controller/usuario.php?op=correo", {user_email:user_email}, function (data) {
            console.log(data);

            if(data=="Existe"){
                $.post("../../controller/email.php?op=recuperar_contra", {user_email : user_email}, function (data) {
                    console.log(data);
                });

                swal("Correcto!", "Se le ha enviado un correo electronico", "success");
            }else{
                swal("Error!", "Correo No Encontrado", "error");
            }
        });
    }

    
});