<div id="modal_add" class="modal fade" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <!--Encabezado-->
            <div class="modal-header">
                <h4 class="modal-title">Agregar Usuario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            
            <div class="modal-body">
                <form id="frm_add_user" class="needs-validation" novalidate>
                    <fieldset>
                        <legend>Datos de Nuevo Usuario</legend>
                        <!--Nombre de Usuario-->
                        <div class="form-group">
                            <label for="txt_username">Nombre</label>
                            <input id="txt_username" class="form-control" type="text" minlength="2" required="required" />
                            <div class="valid-feedback">
                                ¡Campo validado!
                            </div>
                            <div class="invalid-feedback">
                                ¡El nombre debe tener al menos dos caracarteres!
                            </div>
                        </div>
                        <!--E-mail-->
                        <div class="form-group">
                            <label for="txt_email">E-Mail</label>
                            <input id="txt_email" class="form-control" type="email" required ="required" />
                            <div class="valid-feedback">
                                ¡Email validado!
                            </div>
                            <div class="invalid-feedback">
                                ¡Ingrese un email valido!
                            </div>
                        </div>
                        <!--Contraseña-->
                        <div class="form-group">
                            <label for="txt_contrasenia">Contraseña</label>
                            <input id="txt_contrasenia" class="form-control" type="password" minlength="8" maxlength="72" required="required" />
                            <div class="valid-feedback">
                                ¡Campo validado!
                            </div>
                            <div class="invalid-feedback">
                                ¡La contraseña debe ser mayor a 8 caracteres y contener mayúsculas, minúsculas y un número!
                            </div>
                        </div>
                      </fieldset>
                </form>
            </div>
            
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
            <button form="frm_add_user" id="btn_crear_usuario" class="btn btn-outline-light" type="submit">Guardar</button>
          </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>