<div id="modal_edit" class="modal fade" aria-modal="true">
        <div class="modal-dialog">
          <div class="modal-content bg-secondary">
              
            <div class="modal-header">
                <h4 class="modal-title">Editar Usuario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
              
            <div class="modal-body">
              <form id="frm_edit_user" class="needs-validation" novalidate enctype="multipart/form-data">
                    <fieldset>
                        <legend>Datos de <?=$auth_username?></legend>
                        <!--Nombre de Usuario-->
                        <div class="form-group">
                            <label for="txt_username">Nombre</label>
                            <input id="edit_txt_username" class="form-control" type="text" minlength="2" required="required" value="<?=$auth_username?>" />
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
                            <input id="edit_txt_email" class="form-control" type="email" required ="required" value="<?=$auth_email?>" />
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
                            <input id="edit_txt_contrasenia" class="form-control" type="password" minlength="8" maxlength="72"/>
                            <div class="valid-feedback">
                                ¡Campo validado!
                            </div>
                            <div class="invalid-feedback">
                                ¡La contraseña debe ser mayor a 8 caracteres y contener mayúsculas, minúsculas y un número!
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="panel">Subir Foto</div>
                            <input id="img_foto" type="file" />
                            <p>Peso máximo de la foto 2MB</p>
                            <img id="img_previa" src="<?=base_url().$auth_photo?>" alt="" class="img-thumbnail" width="100px" />
                        </div>
                      </fieldset>
                </form>
            </div>
              
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
              <button form="frm_edit_user" type="submit" class="btn btn-outline-light">Guardar Cambios</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
