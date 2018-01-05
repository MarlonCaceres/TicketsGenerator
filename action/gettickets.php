<?php
include "../config/config.php";//Contiene funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

if (isset($_GET['id'])){
    $id_del=intval($_GET['id']);
    $query=mysqli_query($con, "SELECT * from tareas where id='".$id_del."'");
    $count=mysqli_num_rows($query);

    if ($delete1=mysqli_query($con,"DELETE FROM tareas WHERE id='".$id_del."'")){
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
?>
