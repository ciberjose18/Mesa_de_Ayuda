$(document).on("click", "#btnactualizar", function () {
  var pass = $("#txtpass").val();
  var newpass = $("#txtpassconfirm").val();

  if (pass.length == 0 || newpass.length == 0) {
    swal("Error!", "Campos Vacios", "error");
  } else {
    if (pass == newpass) {
      var usu_id = $("#user_idx").val();
      $.post(
        "../../controller/usuario.php?op=password",
        { usu_id: usu_id, user_pass: newpass },
        function (data) {
          swal("Correcto!", "Actualizado Correctamente", "success");
        }
      );
      $("#txtpass").val("");
      $("#txtpassconfirm").val("");
    } else {
      swal("Error!", "Las contraseñas no coinciden", "error");
    }
  }
});

document.getElementById("showPassword1").addEventListener("change", function() {
    togglePassword('txtpass');
  });

  document.getElementById("showPassword2").addEventListener("change", function() {
    togglePassword('txtpassconfirm');
  });

  function togglePassword(id) {
    var element = document.getElementById(id);
    if (element.type === "password") {
      element.type = "text";
    } else {
      element.type = "password";
    }
  }