<?php

    include "../config/config.php";//Contiene funcion que conecta a la base de datos
    
    $action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if (isset($_GET['id'])){
        $id_del=intval($_GET['id']);
        $query=mysqli_query($con, "SELECT * from category where id='".$id_del."'");
        $count=mysqli_num_rows($query);
            if ($delete1=mysqli_query($con,"DELETE FROM category WHERE id='".$id_del."'")){
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
              <strong>Error!</strong> No se pudo eliminar ésta  categoria. Existen gastos vinculadas a ésta categoria. 
            </div>
<?php
        } //end else
    } //end if
?>

<?php
if($action == 'ajax' && !empty( $_REQUEST['idEmpresa']) && isset($_REQUEST['idEmpresa'])){
    $query = mysqli_query($con,"SELECT * from category where empresa_id ='". $_REQUEST['idEmpresa']."'");
    ?>

    <option selected="" value="" disabled>-- Selecciona --</option>
    <?php foreach($query as $p):?>
        <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
    <?php endforeach; ?>
<?php
}else{
    if($action == 'ajax'){

        // escaping, additionally removing everything that could be (html/javascript-) code

        $idEmpresa=(isset( $_REQUEST["emp"])&& !empty($_REQUEST["emp"]))? mysqli_real_escape_string($con,(strip_tags($_REQUEST["emp"], ENT_QUOTES))):null;

        //Admin Mode
        $isAdmin=(isset( $_REQUEST["Admin"])&& !empty($_REQUEST["Admin"]) && $_REQUEST["Admin"] ==1)? true:false;

        $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
        $qArray= array($q,$idEmpresa);

        if (($idEmpresa == null)){
            $aColumns = array('name');
        }else{
            $aColumns= array('name','empresa_id');//Columnas de busqueda
        }
        $sTable = "category";
        $sWhere = "";
//        echo $isAdmin;
        if ( !$isAdmin)
        {
            $sWhere = "WHERE (".$sTable.".";
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".$qArray[$i]."%' AND ";
            }
            $sWhere = substr_replace( $sWhere, "", -4 );
            $sWhere .= ')';
        }else{
            $sWhere = "WHERE (".$sTable.".";
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ')';
        }
        $sWhere.=" order by name desc";

//        echo $sWhere;
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
        $reload = './categories.php';

        //query de admin
        $sqlAdmin="SELECT category.id, category.name, ep.name AS `Empresa` FROM `category` LEFT JOIN company ep ON (ep.id= category.empresa_id) $sWhere LIMIT $offset,$per_page";
        //main query to fetch the data
        $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
        if(!$isAdmin)
            $query = mysqli_query($con, $sql);
        else
            $query = mysqli_query($con, $sqlAdmin);

        //loop through fetched data
        if ($numrows>0){

            ?>
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                <tr class="headings">
                    <th class="column-title">Tipo de trabajo </th>
                    <?php if ($isAdmin) {?>
                        <th class="column-title">Empresa</th>
                    <?php }?>
                    <th class="column-title no-link last"><span class="nobr"></span></th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($r=mysqli_fetch_array($query)) {
                    $id=$r['id'];
                    $name=$r['name'];
                    if($isAdmin)
                        $empresa= $r['Empresa'];
                    ?>
                    <input type="hidden" value="<?php echo $id;?>" id="id<?php echo $id;?>">
                    <input type="hidden" value="<?php echo $name;?>" id="name<?php echo $id;?>">

                    <tr class="even pointer">
                        <td ><?php echo $name; ?></td>
                        <?php if ($isAdmin) {?>
                            <td ><?php echo $empresa; ?></td>
                        <?php }?>
                        <td ><span class="pull-right">
                        <a href="#" class='btn btn-default' title='Editar producto' onclick="obtener_datos('<?php echo $id;?>');" data-toggle="modal" data-target=".bs-example-modal-lg-udp"><i class="glyphicon glyphicon-edit"></i></a>
                        <a href="#" class='btn btn-default' title='Borrar producto' onclick="eliminar('<?php echo $id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
                    </tr>
                    <?php
                } //end while
                ?>
                <tr>
                    <td colspan=6><span class="pull-right">
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
                <strong>Aviso!</strong> No hay datos para mostrar
            </div>
            <?php
        }
    }
}
?>

<?php

?>
