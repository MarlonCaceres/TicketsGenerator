$(document).ready(function(){
	load(1);

	$("#empresa_id").on('change',function (e) {
		console.log($(this).val());
		var idEmpresa=$(this).val();

        $.ajax({
            url:'./ajax/categories.php?action=ajax&idEmpresa='+idEmpresa,
            success:function(data){
                $('#category_id').html(data);
            }
        })
    });




});

function load(page){
	var q= $("#q").val();

    var idEmpresa=$("#idEmpresa").val();
    var RolUser=$("#RolUser").val();
    var urlajax;
    if(RolUser =="Administrador") {
        urlajax = './ajax/ticketsEmpresas.php?action=ajax&page=' + page + '&q=' + q + '&Admin=1';
    }else{
        urlajax = './ajax/ticketsEmpresas.php?action=ajax&page=' + page + '&q=' + q + '&emp=' + idEmpresa;
	}




    $("#loader").fadeIn('slow');
	$.ajax({
		url:urlajax,
		beforeSend: function(objeto){
			$('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
		},
		success:function(data){
			$(".outer_div").html(data).fadeIn('slow');
			$('#loader').html('');
		}
	})
}



function eliminar (id)
{
	var q= $("#q").val();
	if (confirm("Realmente deseas eliminar el ticket?")){	
		$.ajax({
			type: "GET",
			url: "./ajax/tickets.php",
			data: "id="+id,"q":q,
			beforeSend: function(objeto){
				$("#resultados").html("Mensaje: Cargando...");
			},
			success: function(datos){
				$("#resultados").html(datos);
				load(1);
			}
		});
	}
}


