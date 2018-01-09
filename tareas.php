<?php
    $title ="Tareas | ";
    include "head.php";
    include "sidebar.php";
?>

    <div class="right_col" role="main"><!-- page content -->
        <div class="">
            <div class="page-title">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                        /*include("modal/new_tarea.php");*/
                        include("modal/view_ticket.php");
                    ?>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Mis tareas</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        
                        <!-- form seach -->
                        <form class="form-horizontal" role="form" id="gastos">
                            <div class="form-group row">
                                <label for="q" class="col-md-2 control-label">Nombre/Asunto</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="q" placeholder="Nombre de la tarea" onkeyup='load(1);'>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-default" onclick='load(1);'>
                                        <span class="glyphicon glyphicon-search" ></span> Buscar</button>
                                    <span id="loader"></span>
                                </div>
                            </div>
                        </form>     
                        <!-- end form seach -->


                        <div class="x_content">
                            <div class="table-responsive">
                                <!-- ajax -->
                                    <div id="resultados"></div><!-- Carga los datos ajax -->
                                    <div class='outer_div'></div><!-- Carga los datos ajax -->
                                <!-- /ajax -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /page content -->

<?php include "footer.php" ?>

<script type="text/javascript" src="js/tareas.js"></script>
<script>
/*$("#add").submit(function(event) {
  $('#save_data').attr("disabled", true);
  
 var parametros = $(this).serialize();
     $.ajax({
            type: "POST",
            url: "action/addtareas.php",
            data: parametros,
             beforeSend: function(objeto){
                $("#result").html("Mensaje: Cargando...");
              },
            success: function(datos){
            $("#result").html(datos);
            $('#save_data').attr("disabled", false);
            load(1);
          }
    });
  event.preventDefault();
});


$( "#upd" ).submit(function( event ) {
  $('#upd_data').attr("disabled", true);
  
 var parametros = $(this).serialize();
     $.ajax({
            type: "POST",
            url: "action/updtarea.php",
            data: parametros,
             beforeSend: function(objeto){
                $("#result2").html("Mensaje: Cargando...");
              },
            success: function(datos){
            $("#result2").html(datos);
            $('#upd_data').attr("disabled", false);
            load(1);
          }
    });
  event.preventDefault();
});*/

    function obtener_datos(id){
        var ticket_id = $("#ticket_id"+id).val();
        $.ajax({
            type: "POST",
            url: "ajax/tickets.php?id="+ticket_id+"&getTicket=1",
            beforeSend: function(objeto){
//                $("#result2").html("Mensaje: Cargando...");
            },
            success: function(datos){
                datos =JSON.parse(datos);
            console.log(datos);
                $("#mod_title").val(datos.title);
                $("#mod_description").val(datos.description);
                $("#mod_project_id").val(datos.proyecto);
                $("#mod_kind_id").val(datos.tipo);
                $("#mod_priority_id").val(datos.Prioridad);
                $("#mod_status_id").val(datos.Estado);
                $("#mod_solicitado").val(datos.solicitante);
                $("#mod_category_id").val(datos.tipo_trabajo);
                
                if( datos.adjunto  && datos.adjunto != null ){
                    $("#mod_Adjunto").removeAttr("disabled");
                    $("#mod_Adjunto").attr("href","Adjuntos/"+datos.adjunto);
                    $("#mod_Adjunto").attr("download",datos.adjunto);
                    $("#mod_Adjunto").attr("title","Descargar adjunto - "+datos.adjunto);
                    $("#mod_Adjunto").html('<i class="fa fa-download"></i> ' + datos.adjunto );                   
                }else{
                     $("#mod_Adjunto").attr('<i class="fa fa-download"></i>  Sin Adjunto' );
                     $("#mod_Adjunto").attr("disabled","disabled");                     
                }

                

                var txt="<ul>";
                    txt+="<li><strong>Solicitado en:</strong>"+datos.created_at+"</li>";
                    txt+="<li> <strong>Ultima Modificación: </strong>"+(datos.updated_at==null?datos.created_at:datos.updated_at)+"</li>";
                    txt+="<li> <strong>Fecha de entrega:</strong>"+(datos.fecha_entrega==null?'Sin Definir':datos.fecha_entrega)+"</li></ul>";
                $("#mod_fechas").html(txt);
            }
        });

        
        }

     function statustarea(id){
        console.log("holadad");
         $.ajax({
             type: "GET",
             url: "./ajax/tareas.php?id="+id+"&action=statusUpdate",

             beforeSend: function(objeto){
                 $("#resultados").html("Mensaje: Cargando...");
             },
             success: function(datos){
                 $("#resultados").html(datos);
                 load(1);
             }
         });
     }

</script>