<?php
    include "../config/config.php";//Contiene funcion que conecta a la base de datos

    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

    if (isset($_GET['id'])) {
        $id_del = intval($_GET['id']);

        if ($action == "statusUpdate") {
            $status = mysqli_query($con,"SELECT status from tareas where id='".$id_del."'");

            while ($st =mysqli_fetch_array($status)){
                $stint = $st['status'] == '0'?1:0;

            }
                $query = mysqli_query($con, "UPDATE tareas SET status = ".$stint." WHERE id='" . $id_del . "'");
            if($query){
                ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <strong>Aviso!</strong> Cambio realizado exitosamente.
                </div>
                <?php
            }else{
                ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
                </div>
                <?php
            }
        } else {
            $query = mysqli_query($con, "SELECT * from tareas where id='" . $id_del . "'");
            $count = mysqli_num_rows($query);
            if ($delete1 = mysqli_query($con, "DELETE FROM tareas WHERE id='" . $id_del . "'")) {
                ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <strong>Aviso!</strong> Datos eliminados exitosamente.
                </div>
                <?php
            } else {

                ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
                </div>
                <?php
            } //end else
        } //end if
    }
    ?>

<?php
    if($action == 'ajax'){

        $idtarea=(isset( $_REQUEST["idU"])&& !empty($_REQUEST["idU"]))? mysqli_real_escape_string($con,(strip_tags($_REQUEST["idU"], ENT_QUOTES))):null;
        // escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $qArray=array($q,$idtarea);
         $aColumns = array('title','user_id');//Columnas de busqueda
         $sTable = "tareas";
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
        $sWhere.=" order by create_date desc";
        include 'pagination.php'; //include pagination file
        //pagination variables
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 10; //how much records you want to show
        $adjacents  = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere");
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
                        <th class="column-title">Título </th>
                        <th class="column-title">Descripción</th>
                        <th class="column-title">Asignado</th>
                        <th class="column-title">Ticket </th>
                        <th class="column-title">Status </th>
                        <th class="column-title">Fecha</th>
                        <th class="column-title no-link last"><span class="nobr"></span></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        while ($r=mysqli_fetch_array($query)) {
                            $id=$r['id'];
                            $created_at=date('d/m/Y', strtotime($r['create_date']));
                            $description=$r['description'];
                            $title=$r['title'];
                            $user_id=$r['user_id'];
                            $ticket_id=$r['ticket_id'];
                            $status=$r['status'];

                            $sql = mysqli_query($con, "select * from user where id=$user_id");
                            if($u=mysqli_fetch_array($sql)) {
                                $name_usr=$u['name'];
                            }

                            $sqlm="select * from ticket where id=$ticket_id";
                            $sql = mysqli_query($con, $sqlm);
                            if($t=mysqli_fetch_array($sql)) {
                                $id_t=$t['title'];

                            }


                ?>
                    <input type="hidden" value="<?php echo $id;?>" id="id<?php echo $id;?>">

                    <input type="hidden" value="<?php echo $title;?>" id="title<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $description;?>" id="description<?php echo $id;?>">
                    <!-- me obtiene los datos -->
                    <input type="hidden" value="<?php echo $user_id;?>" id="user_id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $ticket_id;?>" id="ticket_id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $status;?>" id="status<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $created_date;?>" id="created_date<?php echo $id;?>">




                    <tr class="even pointer">
                        <td><?php echo $title;?></td>
                        <td><?php echo $description; ?></td>
                        <td><?php echo $name_usr; ?></td>
                        <td><?php echo $id_t; ?></td>
                        <?php if ($status==1){?>
                        <td><?php echo 'Activo';?></td>
                        <?php }else{?>
                        <td><?php echo 'Realizado';?></td>
                        <?php }?>
                        
                        <td><?php echo $created_at;?></td>
                        <td ><span class="pull-right">
                        <a href="#" class='btn btn-default' title='Editar producto' onclick="obtener_datos('<?php echo $id;?>');" data-toggle="modal" data-target=".bs-example-modal-lg-udp"><i class="fa fa-ticket"></i></a>
                        <a href="#" class='btn btn-default' title='Borrar producto' onclick="statustarea('<?php echo $id; ?>')"><i class="<?php if ($status==1){?> fa fa-check <?php }else{?> fa fa-times <?php }?>"  ></i> </a></span></td>
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