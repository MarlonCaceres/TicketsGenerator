<?php    
    $priorities =mysqli_query($con, "select * from priority");
    $statuses =mysqli_query($con, "select * from status where id != 6");
    $kinds =mysqli_query($con, "select * from kind");
    

    $id=isset($_POST['mod']);
    echo $id;
?>
    <!-- Modal -->
    <div class="modal fade bs-example-modal-lg-udp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" <?php if ($id==1){?> disabled <?php }?> >×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"> Modificar estado ticket</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left input_mask" method="post" id="upd" name="upd">
                        <div id="result2"></div>

                        <input type="hidden" name="mod_id" id="mod_id">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tipo
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control" name="kind_id" required id="mod_kind_id" disabled >
                                      <?php foreach($kinds as $p):?>
                                        <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                      <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Titulo</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" name="title" class="form-control" placeholder="Titulo" id="mod_title" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Descripción </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <textarea name="description" id="mod_description" class="form-control col-md-7 col-xs-12" disabled></textarea>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Prioridad
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="hidden"   id="mod_h_priority_id" >
                                <select class="form-control"  name="priority_id" required id="mod_priority_id" >
                                  <?php foreach($priorities as $p):?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Estado
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="hidden"  id="mod_h_status_id" >
                                <select  class="form-control"  name="status_id" required id="mod_status_id">
                                  <?php foreach($statuses as $p):?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                            </div>
                        </div>                        
                        
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                              <button id="upd_data" type="submit" class="btn btn-success btn-block">Guardar</button>
                            </div>
                        </div>
                    </form>                
                </div>
                
            </div>
        </div>
    </div> <!-- /Modal -->