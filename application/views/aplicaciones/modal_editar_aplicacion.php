<div id="modal_edit_aplication" class="modal fade" aria-modal="true">
        <div class="modal-dialog">
          <div class="modal-content bg-primary">
              
            <div class="modal-header">
                <h4 class="modal-title">Editar Aplicación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
              
            <div class="modal-body">
              <form id="frm_edit_aplication" class="needs-validation" novalidate enctype="multipart/form-data">
                    <fieldset>
                        <legend>Datos de Aplicación</legend>
                        <!--Nombre de Producto------------------------------------>
                        <div class="form-group">
                            <label for="edit_txt_nombre">Nombre</label>
                            <input id="edit_txt_nombre" class="form-control" type="text" required="required" pattern="[0-9a-zA-ZÁÉÍÓÚáéíóúñÑ,() ]{1,100}"/>
                            <div class="valid-feedback">
                                ¡Nombre validado!
                            </div>
                            <div class="invalid-feedback">
                                <ul>
                                    <li>¡El nombre es obligatorio!</li>
                                    <li>¡El nombre debe tener al menos 1 carácteres y menos de 100!</li>
                                    <li>¡El nombre solo acepta letras, números, espacios, paréntesis y comas</li>
                                </ul>
                            </div>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Equipos---------------------------------------->
                        <div class="form-group">
                            <label for="edit_txt_description">Descripción</label>
                            <textarea id="edit_txt_description" class="form-control" rows="3"></textarea>
                            <div class="valid-feedback">
                                ¡Texto validado!
                            </div>
                            <div class="invalid-feedback">
                                <ul>
                                    <li>¡La descripción solo acepta letras, números y espacios</li>
                                </ul>
                            </div>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Imagen del Producto-------------------------------->
                        <div class="form-group">
                            <label for="edit_img_aplication">Subir Imagen</label>
                            <input id="edit_img_aplication" type="file" class="img_form"/>
                            <p>Peso máximo de la imagen 200Kb</p>
                            <img id="edit_img_previa" src="<?=base_url('assets/img/aplicaciones/default.jpg')?>" alt="" class="img-thumbnail img_previa" width="100px" />
                        </div>
                        <!----------------------------------------------------->
                      </fieldset>
                </form>
            </div>
              
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
              <button form="frm_edit_aplication" type="submit" class="btn btn-outline-light">Guardar Cambios</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
