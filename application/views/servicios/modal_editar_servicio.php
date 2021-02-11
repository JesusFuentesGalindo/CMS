<div id="modal_edit_service" class="modal fade" aria-modal="true">
        <div class="modal-dialog">
          <div class="modal-content bg-primary">
              
            <div class="modal-header">
                <h4 class="modal-title">Editar Servicio</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
              
            <div class="modal-body">
              <form id="frm_edit_service" class="needs-validation" novalidate enctype="multipart/form-data">
                    <fieldset>
                        <legend>Datos de Servicio</legend>
                        <!--Nombre de Producto------------------------------------>
                        <div class="form-group">
                            <label for="edit_txt_title">Título</label>
                            <input id="edit_txt_title" class="form-control" type="text" required="required" pattern="[0-9a-zA-ZÁÉÍÓÚáéíóúñÑ,() ]{1,100}"/>
                            <div class="valid-feedback">
                                ¡Título validado!
                            </div>
                            <div class="invalid-feedback">
                                <ul>
                                    <li>¡El título es obligatorio!</li>
                                    <li>¡El título debe tener al menos 1 carácteres y menos de 100!</li>
                                    <li>¡El título solo acepta letras, números, espacios, paréntesis y comas</li>
                                </ul>
                            </div>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Descripción de Servicio--------------------------------->
                        <div class="form-group">
                            <label for="edit_txt_description">Descripción</label>
                            <textarea id="edit_txt_description" class="form-control" rows="3" required="required"></textarea>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Imagen del Producto-------------------------------->
                        <div class="form-group">
                            <label for="edit_img_service">Subir Imagen</label>
                            <input id="edit_img_service" type="file" class="img_form"/>
                            <p>Peso máximo de la imagen 200Kb</p>
                            <img id="edit_img_previa" src="<?=base_url('assets/img/servicios/default.jpg')?>" alt="" class="img-thumbnail img_previa" width="100px" />
                        </div>
                        <!----------------------------------------------------->
                      </fieldset>
                </form>
            </div>
              
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
              <button form="frm_edit_service" type="submit" class="btn btn-outline-light">Guardar Cambios</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
