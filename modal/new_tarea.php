<?php
    /*$projects =mysqli_query($con, "select * from project");
    $priorities =mysqli_query($con, "select * from priority");
    $statuses =mysqli_query($con, "select * from status");
    $kinds =mysqli_query($con, "select * from kind");
    $categories =mysqli_query($con, "select * from category");
    $empresas =mysqli_query($con, "select * from company");*/

    //busca usuarios segun la empresa
    $id=$_SESSION['user_id'];
    
    $usrs=mysqli_query($con,"SELECT Empresa from user where id=$id");
    while ($row=mysqli_fetch_array($usrs)) {
        $id_company = $row['Empresa'];
    }
    $usuarios=mysqli_query($con,"SELECT * from user where Empresa=$id_company");

    //busca tickets segun la empresa
    $tickets=mysqli_query($con,"SELECT * from ticket where empresa_id_asig=$id_company");

    /*foreach ($tickets as $t) {
        echo $t['title'];
    }*/
    
    //$usuarios =mysqli_query($con, "select * from user where Empresa=");

?>

    <div> <!-- Modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg-add"><i class="fa fa-plus-circle"></i> Agregar Tarea</button>
    </div>
    <div class="modal fade bs-example-modal-lg-add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Agregar Tarea</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left input_mask" method="post" id="add" name="add">
                        <div id="result"></div>
                        <!--div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tipo
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="kind_id" >
                                      <?php foreach($kinds as $p):?>
                                        <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                      <?php endforeach; ?>
                                </select>
                            </div>
                        </div-->
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Titulo<span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" name="title" class="form-control" placeholder="Titulo" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Descripción <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <textarea name="description" class="form-control col-md-7 col-xs-12"  placeholder="Descripción"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Usuario
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="user_id" >
                                    <option selected="" value="" disabled="">-- Selecciona --</option>
                                      <?php foreach($usuarios as $u):?>
                                        <option value="<?php echo $u['id']; ?>"><?php echo $u['name']; ?></option>
                                      <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ticket
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="ticket_id" id="ticket_id" >
                                    <option selected="" value="" disabled>-- Selecciona --</option>
                                    <?php foreach($tickets as $t):?>
                                        <option value="<?php echo $t['id']; ?>"><?php echo $t['title']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tipo de trabajo
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="category_id" id="category_id" -->
                                    <!--<option selected="" value="">-- Selecciona --</option>
                                      <?php /*foreach($categories as $p):*/?>
                                        <option value="<?php /*echo $p['id']; */?>"><?php /*echo $p['name']; */?></option>
                                      --><?php /*endforeach; */?>
                                <!--/select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fecha estimada de entrega</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="date" class="form-control" name="fecha_entrega">
                            </div>
                        </div-->

                        <!--<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Prioridad
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="priority_id" >
                                    <option selected="" value="">-- Selecciona --</option>
                                  <?php /*foreach($priorities as $p):*/?>
                                    <option value="<?php /*echo $p['id']; */?>"><?php /*echo $p['name']; */?></option>
                                  <?php /*endforeach; */?>
                                </select>
                            </div>
                        </div>-->
                        <!--div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Estado
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                  <?php foreach($statuses as $p):?>
                                      <?php if($p['id']==1){ ?>
                                      <input type="text" id="last-name" name="estado" class="form-control" value="<?php echo  $p['name']; ?>" disabled>
                                      <?php }?>
                                  <?php endforeach; ?>
                            </div>
                        </div-->
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                              <button id="save_data" type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>    
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div> <!-- /Modal -->