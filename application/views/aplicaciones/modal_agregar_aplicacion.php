<div id="modal_create_aplication" class="modal fade" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <!--Encabezado-->
            <div class="modal-header">
                <h4 class="modal-title">Agregar Aplicación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            
            <div class="modal-body">
                <form id="frm_create_aplication" class="needs-validation" novalidate>
                    <fieldset>
                        <legend>Datos de Nueva Aplicación</legend>
                        <!--Nombre de Producto------------------------------------>
                        <div class="form-group">
                            <label for="create_txt_nombre">Nombre</label>
                            <input id="create_txt_nombre" class="form-control" type="text" required="required" pattern="[0-9a-zA-ZÁÉÍÓÚáéíóúñÑ,() ]{1,100}"/>
                            <div class="valid-feedback">
                                ¡Nombre validado!
                            </div>
                            <div class="invalid-feedback">
                                <ul>
                                    <li>¡El nombre es obligatorio!</li>
                                    <li>¡El nombre debe tener al menos 3 carácteres y menos de 100!</li>
                                    <li>¡El nombre solo acepta letras, números, espacios, paréntesis y comas</li>
                                </ul>
                            </div>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Descripción---------------------------------------->
                        <div class="form-group">
                            <label for="create_txt_description">Descripción</label>
                            <textarea id="create_txt_description" class="form-control" rows="3" required="required"></textarea>
                            <div class="valid-feedback">
                                ¡Descripción validada!
                            </div>
                            <div class="invalid-feedback">
                                <ul>
                                    <li>¡Este campo es obligatorio!</li>
                                </ul>
                            </div>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Imagen del Producto----------------------------------->
                        <div class="form-group">
                            <label for="create_img_aplication">Subir Imagen</label>
                            <input id="create_img_aplication" type="file" class="img_form"/>
                            <p>Peso máximo de la imagen 200Kb</p>
                            <img id="create_img_previa" src="<?=base_url('assets/img/productos/default.jpg')?>" alt="" class="img-thumbnail img_previa" width="100px" />
                        </div>
                        <!----------------------------------------------------->
                      </fieldset>
                </form>
            </div>
            
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
            <button form="frm_create_aplication" id="btn_enviar_aplicacion" class="btn btn-outline-light" type="submit">Crear Aplicación</button>
          </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>