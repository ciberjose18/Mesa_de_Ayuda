function init() {
  $("#ticket_form").on("submit", function (e) {
    guardaryeditar(e);
  });
}

$(document).ready(function () {
  $("#tick_descrip").summernote({
    height: 400,
    lang: "es-ES", 
    callbacks: {
      onImageUpload: function(image) {
          console.log("Image detect...");
          myimagetreat(image[0]);
      },
      onPaste: function (e) {
          console.log("Text detect...");
      }
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

  $.post("../../controller/categoria.php?op=combo", function (data, status) {
    $("#cat_id").html(data);
  });

  $("#cat_id").change(function () {
    cat_id=$(this).val();
    console.log(cat_id);
    $.post("../../controller/subcategoria.php?op=combo",{cat_id : cat_id},function(data, status){
      console.log(data);
      $('#subc_id').html(data);
  });
  });

  $.post("../../controller/prioridad.php?op=combo", function (data, status) {
    $("#prio_id").html(data);
  });

});

/*   $(document).ready(function () {
  $(".summernote").summernote({
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

  $.post("../../controller/categoria.php?op=combo", function (data, status) {
    $("#cat_id").html(data);
  });

  $("#cat_id").change(function () {
    cat_id=$(this).val();
    console.log(cat_id);
    $.post("../../controller/subcategoria.php?op=combo",{cat_id : cat_id},function(data, status){
      console.log(data);
      $('#subc_id').html(data);
  });
  });

  $.post("../../controller/prioridad.php?op=combo", function (data, status) {
    $("#prio_id").html(data);
  });

}); */




function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#ticket_form")[0]);
  if ($('#tick_descrip').summernote('isEmpty') || $('#tick_titulo').val()=='' || $('#cat_id').val() == 0 || $('#subc_id').val() == 0 || $('#prio_id').val() == 0){
      swal("Advertencia!", "Campos Vacios", "warning");
  }else{
      var totalfiles = $('#fileElem').val().length;
      for (var i = 0; i < totalfiles; i++) {
          formData.append("files[]", $('#fileElem')[0].files[i]);
      }

      $.ajax({
        url: "../../controller/ticket.php?op=insert", //considera usar una URL absoluta
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){
              console.log(data);
                data = JSON.parse(data);
                console.log(data[0].tick_id);

              $.post("../../controller/whatsapp.php?op=w_ticket_abierto", {tick_id : data[0].tick_id}, function (data) {

              });

              $.post("../../controller/email.php?op=ticket_abierto", {tick_id : data[0].tick_id}, function (data) {

              });


                $('#tick_titulo').val('');
                $('#tick_descrip').summernote('reset');
                swal("Correcto!", "Registrado Correctamente", "success");
                
        }
    });
    

    //$.post("../../controller/email.php?op=ticket_abierto", {tick_id : data[0].tick_id}, function (data) {

 //   });


    }





  }


init();
