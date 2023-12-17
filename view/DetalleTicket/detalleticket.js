function init() { }

$(document).ready(function () {
  // Obtiene la URL completa de la página web actual.
  const url = window.location.href;
  // Crea un objeto URLSearchParams a partir de la parte de búsqueda de la URL. Esto facilita la manipulación y acceso a los parámetros de la URL.
  const params = new URLSearchParams(new URL(url).search);
  // Obtiene el valor del parámetro 'ID' de la URL. Si no existe, 'tick_id' será null.
  const tick_id = params.get("ID");
  // Decodifica el valor del parámetro 'ID' para manejar correctamente los caracteres especiales.
  // Por ejemplo, convierte '%20' en un espacio.
  const decoded_id = decodeURIComponent(tick_id);
  const id = decoded_id.replace(/\s/g, "+");

  listardetalle(id);

  // #region mostrar
  $.ajax({url: "../../controller/ticket.php?op=mostrar", // Asegúrate de poner la ruta correcta a ticket.php 
  type: "POST",
    data: { tick_id: id }, // Reemplaza con el ID del ticket correspondiente
    success: function (response) {
      var data = JSON.parse(response);
      console.log(data.usu_asign);
      if (data.usu_asign === null) {
        $("#pnldetalle").hide();
        $("#descrip_duda").summernote("disable");
        swal({
          title: "Mesa de Ayuda!",
          text: "No ha sido asignado un soporte aun.",
          type: "warning",
          confirmButtonClass: "btn-warning",
        });
      } else {
        5;
        $("#pnldetalle").show();
        $("#descrip_duda").summernote("enable");
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud AJAX: ", status, error);
    },
  });
  // #endregion

  // #region summernote

  $("#descrip_duda").summernote({
    height: 400,
    lang: "es-ES",
    callbacks: {
      /* onImageUpload: function(image) {
                console.log("Image detect...");
                myimagetreat(image[0]);
            },*/
      onPaste: function (e) {
        console.log("Text detect...");
      },
    },
    toolbar: [
      ["style", ["bold", "italic", "underline", "clear"]],
      ["font", ["strikethrough", "superscript", "subscript"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
    ],
  });
  // #endregion

  // #region enviarArchivo
  function sendFile(file, el) {
    var form_data = new FormData();
    form_data.append("file", file);
    $.ajax({
      data: form_data,
      type: "POST",
      url: "uploader.php",
      cache: false,
      contentType: false,
      processData: false,
      success: function (url) {
        $(el).summernote("editor.insertImage", url);
      },
    });
  }

  // #endregion

  // #region summernote descrip
  $("#tick_descripusu").summernote({
    height: 400,
    lang: "es-ES",
    toolbar: [
      ["style", ["bold", "italic", "underline", "clear"]],
      ["font", ["strikethrough", "superscript", "subscript"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
    ],
  });
  // #endregion

  $("#tick_descripusu").summernote("disable");
  // #region tabla

  tabla = $("#documentos_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      dom: "Bfrtip",
      searching: true,
      lengthChange: false,
      colReorder: true,
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
      ajax: {
        url: "../../controller/documento.php?op=listar",
        type: "post",
        data: { tick_id: tick_id },
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      responsive: true,
      bInfo: true,
      iDisplayLength: 10,
      autoWidth: false,
      language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo: "Mostrando un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando un total de 0 registros",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
          sFirst: "Primero",
          sLast: "Último",
          sNext: "Siguiente",
          sPrevious: "Anterior",
        },
        oAria: {
          sSortAscending:
            ": Activar para ordenar la columna de manera ascendente",
          sSortDescending:
            ": Activar para ordenar la columna de manera descendente",
        },
      },
    })
    .DataTable();
});
// #endregion

// #region botonEnviar

$(document).on("click", "#btnenviar", function () {
  console.log("Test");
  const url = window.location.href;
  const params = new URLSearchParams(new URL(url).search);
  const tick_id = params.get("ID");
  const decoded_id = decodeURIComponent(tick_id);
  const id = decoded_id.replace(/\s/g, "+");
  var usu_id = $("#user_idx").val();
  var tickdetalle_descrip = $("#descrip_duda").val();

  if ($("#descrip_duda").summernote("isEmpty")) {
    swal("Advertencia!", "Falta Descripción", "warning");
  } else {
    var formData = new FormData();
    formData.append("tick_id", id);
    formData.append("usu_id", usu_id);
    formData.append("tickdetalle_descrip", tickdetalle_descrip);
    var totalfiles = $("#fileElem").val().length;
    for (var i = 0; i < totalfiles; i++) {
      formData.append("files[]", $("#fileElem")[0].files[i]);
    }

    $.ajax({
      url: "../../controller/ticket.php?op=insertdetalle",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        console.log(data);
        listardetalle(tick_id);
        /* TODO: Limpiar inputfile */
        $("#fileElem").val("");
        $("#descrip_duda").summernote("reset");
        swal("Correcto!", "Registrado Correctamente", "success");
      },
    });
  }
});
// #endregion

// #region boton cerrar

$(document).on("click", "#btncerrarticket", function () {
  swal(
    {
      title: "Mesa de Ayuda",
      text: "Esta seguro de Cerrar el Ticket?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-warning",
      confirmButtonText: "Si",
      cancelButtonText: "No",
      closeOnConfirm: false,
    },
    function (isConfirm) {
      if (isConfirm) {
        const url = window.location.href;
        const params = new URLSearchParams(new URL(url).search);
        const tick_id = params.get("ID");
        const decoded_id = decodeURIComponent(tick_id);
        const id = decoded_id.replace(/\s/g, "+");
        var usu_id = $("#user_idx").val();
        $.post(
          "../../controller/ticket.php?op=update",
          { tick_id: id, usu_id: usu_id },
          function (data) { }
        );

        $.post(
          "../../controller/email.php?op=ticket_cerrado",
          { tick_id: id },
          function (data) { }
        );

        $.post(
          "../../controller/whatsapp.php?op=w_ticket_cerrado",
          { tick_id: id },
          function (data) {
            //Haz algo con los datos recibidos, si es necesario
          }
        );
        listardetalle(tick_id);

        swal({
          title: "Mesa de Ayuda!",
          text: "Ticket Cerrado correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      }
    }
  );
});
// #endregion

// #region chatgpt

$(document).on("click", "#btnchatgpt", function () {
  const url = window.location.href;
  const params = new URLSearchParams(new URL(url).search);
  const tick_id = params.get("ID");
  const decoded_id = decodeURIComponent(tick_id);
  const id = decoded_id.replace(/\s/g, "+");

  $.post(
    "../../controller/chatgpt.php?op=respuestaia",
    { tick_id: id },
    function (data) {
      console.log(data);
      $("#descrip_duda").summernote("code", data);
    }
  );
});
// #endregion


function listardetalle(id) {
    // #region listardetalle
    $.post(
      "../../controller/ticket.php?op=listardetalle",
      { tick_id: id },
      function (data) {
        $("#lbldetalle").html(data);
      }
    );
  
    $.post("../../controller/ticket.php?op=mostrar", { tick_id: id }, function (
      data
    ) {
      data = JSON.parse(data);
  
      $("#lblestado").html(data.tick_estado);
      $("#lblnomusuario").html(data.user_nom + " " + data.user_ape);
      $("#lblfechcrea").html(data.fecha_crea);
  
      $("#lblnomidticket").html("Detalle Ticket - " + data.tick_id);
  
      $("#cat_nom").val(data.cat_nom);
      $("#subc_nom").val(data.subc_nom);
      $("#tick_titulo").val(data.tick_titulo);
  
      $("#tick_descripusu").summernote("code", data.tick_descrip);
      $("#prio_nom").val(data.prio_nom);
  
      console.log(data.tick_estado_texto);
      if (data.tick_estado_texto == "Cerrado") {
        $("#pnldetalle").hide();
      }
    });
    // #endregion

}
init();
