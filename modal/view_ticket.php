    <!-- Modal -->
    <div class="modal fade bs-example-modal-lg-udp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" <?php if ($id==1){?> disabled <?php }?> >×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"> Información del Ticket</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left input_mask" method="post" id="upd" name="upd">
                        <div id="result2"></div>

                        <input type="hidden" name="mod_id" id="mod_id">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tipo
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="title" class="form-control" placeholder="ticket" id="mod_tipo" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Titulo</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" name="title" class="form-control" placeholder="Titulo" id="mod_title" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Descripción
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <textarea name="description" id="mod_description" class="form-control col-md-7 col-xs-12" disabled></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                             <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Solicitado por:
                           </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="title" class="form-control" placeholder="Proyecto" id="mod_solicitado" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Proyecto
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" name="title" class="form-control" placeholder="Proyecto" id="mod_project_id" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tipo de trabajo
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" name="title" class="form-control" placeholder="Proyecto" id="mod_category_id" disabled>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fecha</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <div class="form-control" id="mod_fechas" disabled  style="height: 80px;">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Prioridad
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" name="title" class="form-control" placeholder="Proyecto" id="mod_priority_id" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Estado
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" name="title" class="form-control" placeholder="Proyecto" id="mod_status_id" disabled>
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