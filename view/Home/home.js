function init(){
   
}

$(document).ready(function(){

    var usu_id = $('#user_idx').val();

    if ( $('#rol_idx').val() == 1){

        $.post("../../controller/usuario.php?op=total", {usu_id:usu_id}, function (data) {
            data = JSON.parse(data);
            $('#lbltotal').html(data.Total);
        }); 
    
        $.post("../../controller/usuario.php?op=totalabierto", {usu_id:usu_id}, function (data) {
            data = JSON.parse(data);
            $('#lbltotalabierto').html(data.Total);
        });
    
        $.post("../../controller/usuario.php?op=totalcerrado", {usu_id:usu_id}, function (data) {
            data = JSON.parse(data);
            $('#lbltotalcerrado').html(data.Total);
        });

        $.post("../../controller/usuario.php?op=grafico", {usu_id:usu_id}, function (data) {
            data = JSON.parse(data);
    
            new Morris.Bar({
                element: 'chartgrafico',
                data:data,
                xkey: 'Nom',
                ykeys: ['Total'],
                labels: ['Value'],
                barColors: function (row, series, type) {
                    if(row.label == "Hardware") return "#AD1D28";
                    else if(row.label == "Software") return "#DEBB27";
                    else if(row.label == "Incidencia") return "#4993B8"; 
                    else if(row.label == "Petición de Servicio") return "#B66C47";
                    else if(row.label == "test2") return "#009688";


                }
            });
        }); 

        

    }else{

        
        $.post("../../controller/ticket.php?op=total", function (data) {
            data = JSON.parse(data);
            $('#lbltotal').html(data.Total);
        }); 
    
        $.post("../../controller/ticket.php?op=totalabierto", function (data) {
            data = JSON.parse(data);
            $('#lbltotalabierto').html(data.Total);
        });
    
        $.post("../../controller/ticket.php?op=totalcerrado", function (data) {
            data = JSON.parse(data);
            $('#lbltotalcerrado').html(data.Total);
        });

        $.post("../../controller/ticket.php?op=grafico", function (data) {
            data = JSON.parse(data);
    
            new Morris.Bar({
                element: 'chartgrafico',
                data: data,
                xkey: 'Nom',
                ykeys: ['Total'],
                labels: ['Value'],
                barColors: ["#1AB244"], 
            });
        }); 

    }





});

init();