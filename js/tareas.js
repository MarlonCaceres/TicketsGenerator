$(document).ready(function(){
	load(1);

});

function load(page){
	var q= $("#q").val();
	var idu=$("#idUser").val();
	var RolUser=$("#RolUser").val();
	
    $("#loader").fadeIn('slow');
    
    var urlajax;
    
	$.ajax({
		url:'./ajax/tareas.php?action=ajax&page=' + page + '&q=' + q+'&idU='+idu,
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
			url: "./ajax/tareas.php",
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


