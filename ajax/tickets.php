<?php

    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    
    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    $getTicket = (isset($_REQUEST['getTicket']) && $_REQUEST['getTicket'] !=NULL)?$_REQUEST['getTicket']:'';
    if (isset($_GET['id'])){
        $id_del=intval($_GET['id']);
        if($getTicket=="1"){
            $query="SELECT ticket.id,ticket.title,ticket.description, ticket.updated_at,ticket.created_at,ticket.fecha_entrega, tk.name as tipo,tc.name as \"tipo_trabajo\",tpr.name as proyecto,tu.name as \"solicitante\",tp.name as Prioridad,ts.name as Estado FROM `ticket` LEFT JOIN kind as tk on (tk.id=ticket.kind_id) LEFT JOIN status as ts on (ts.id=ticket.status_id) LEFT JOIN priority as tp on (tp.id=ticket.priority_id) LEFT JOIN category as tc on (tc.id=ticket.category_id) LEFT JOIN user as tu on (tu.id=ticket.user_id) LEFT JOIN project as tpr on (tpr.id = ticket.project_id) WHERE ticket.id=$id_del";
            echo json_encode(mysqli_fetch_array(mysqli_query($con,$query)));
        }else{
            $query=mysqli_query($con, "SELECT * from ticket where id='".$id_del."'");
            $count=mysqli_num_rows($query);

            if ($delete1=mysqli_query($con,"DELETE FROM ticket WHERE id='".$id_del."'")){


?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> Datos eliminados exitosamente.
            </div>
        <?php 
            }else {
        ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
                </div>
    <?php
            } //end else
        } //end if
    }
    ?>

<?php
    if($action == 'ajax'){

        $idUser=(isset( $_REQUEST["solicUser"])&& !empty($_REQUEST["solicUser"]))? mysqli_real_escape_string($con,(strip_tags($_REQUEST["solicUser"], ENT_QUOTES))):null;
        // escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $qArray=array($q,$idUser);
         $aColumns = array('title','user_id');//Columnas de busqueda
         $sTable = "ticket";
         $sWhere = "";
        if (true)
        {
            $sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".$qArray[$i]."%' AND ";
            }
            $sWhere = substr_replace( $sWhere, "", -4 );
            $sWhere .= ')';
        }
        /*if ( $_GET['q'] != "" )
        {
            $sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ')';
        }*/
        $sWhere.=" order by created_at desc";
        include 'pagination.php'; //include pagination file
        //pagination variables
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 10; //how much records you want to show
        $adjacents  = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
        $row= mysqli_fetch_array($count_query);
        $numrows = $row['numrows'];
        $total_pages = ceil($numrows/$per_page);
        $reload = './expences.php';
        //main query to fetch the data
        $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
        $query = mysqli_query($con, $sql);
        //loop through fetched data
        if ($numrows>0){
            
            ?>
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">
                        <th class="column-title">Asunto </th>
                        <th class="column-title">Solicitado a:</th>
                        <th class="column-title">Tipo de Trabajo:</th>
                        <th class="column-title">Proyecto </th>
                        <th class="column-title">Prioridad </th>
                        <th class="column-title">Estado </th>
                        <th>Fecha</th>
                        <th class="column-title no-link last"><span class="nobr"></span></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        while ($r=mysqli_fetch_array($query)) {
                            $id=$r['id'];
                            $created_at=date('d/m/Y', strtotime($r['created_at']));
                            $updated_at=date('d/m/Y', strtotime($r['updated_at']));
                            $fecha_entrega=date('d/m/Y', strtotime($r['fecha_entrega']));


                            $description=$r['description'];
                            $title=$r['title'];
                            $project_id=$r['project_id'];
                            $priority_id=$r['priority_id'];
                            $status_id=$r['status_id'];
                            $kind_id=$r['kind_id'];
                            $category_id=$r['category_id'];
                            $empresa_asig=$r['empresa_id_asig'];

                            $sql = mysqli_query($con, "select * from category where id=$category_id");
                            if($c=mysqli_fetch_array($sql)) {
                                $name_category=$c['name'];
                            }

                            $sql = mysqli_query($con, "select * from project where id=$project_id");
                            if($c=mysqli_fetch_array($sql)) {
                                $name_project=$c['name'];
                            }

                            $sql = mysqli_query($con, "select * from priority where id=$priority_id");
                            if($c=mysqli_fetch_array($sql)) {
                                $name_priority=$c['name'];
                            }

                            $sql = mysqli_query($con, "select * from status where id=$status_id");
                            if($c=mysqli_fetch_array($sql)) {
                                $name_status=$c['name'];
                            }

                            $sql = mysqli_query($con, "select * from company where id=$empresa_asig");
                            if($c=mysqli_fetch_array($sql)) {
                                $name_company=$c['name'];
                            }


                ?>
                    <input type="hidden" value="<?php echo $id;?>" id="id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $title;?>" id="title<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $description;?>" id="description<?php echo $id;?>">

                    <!-- me obtiene los datos -->
                    <input type="hidden" value="<?php echo $kind_id;?>" id="kind_id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $project_id;?>" id="project_id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $empresa_asig;?>" id="empresa_asig<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $category_id;?>" id="category_id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $priority_id;?>" id="priority_id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $status_id;?>" id="status_id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $fecha_entrega;?>" id="fecha_entrega<?php echo $id;?>">


                    <tr class="even pointer">
                        <td><?php echo $title;?></td>
                        <td><?php echo $name_company; ?></td>
                        <td><?php echo $name_category; ?></td>
                        <td><?php echo $name_project; ?></td>
                        <td><?php echo $name_priority; ?></td>
                        <td><?php echo $name_status;?></td>
                        <td><ul><li>Solicitado en:  <?php echo $created_at;?></li><li>Última modificación en: <?php echo $updated_at;?></li><li>Entrega Estimada:  <?php echo $fecha_entrega;?></li></ul></td>
                        <td ><span class="pull-right">
                        <a href="#" class='btn btn-default' title='Editar producto' onclick="obtener_datos('<?php echo $id;?>');" data-toggle="modal" data-target=".bs-example-modal-lg-udp"><i class="glyphicon glyphicon-edit"></i></a> 
                        <a href="#" class='btn btn-default' title='Borrar producto' onclick="eliminar('<?php echo $id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
                    </tr>
                <?php
                    } //en while
                ?>
                <tr>
                    <td colspan=8><span class="pull-right">
                        <?php echo paginate($reload, $page, $total_pages, $adjacents);?>
                    </span></td>
                </tr>
              </table>
            </div>
            <?php
        }else{
           ?> 
            <div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Aviso!</strong> No hay datos para mostrar!
            </div>
        <?php    
        }
    }
?>