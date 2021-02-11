<div id="modal_edit_brand" class="modal fade" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <!--Encabezado-->
            <div class="modal-header">
                <h4 class="modal-title">Editar Marca</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            
            <div class="modal-body">
                <form id="frm_edit_brand" class="needs-validation" novalidate>
                    <fieldset>
                        <legend>Datos de Marca</legend>
                        <!--Nombre de la Marca------------------------------------>
                        <div class="form-group">
                            <label for="brand_create_txt_name">Nombre</label>
                            <input id="brand_edit_txt_name" class="form-control" type="text" required="required" pattern="[0-9a-zA-ZÁÉÍÓÚáéíóúñÑ ]{3,100}"/>
                            <div class="valid-feedback">
                                ¡Nombre validado!
                            </div>
                            <div class="invalid-feedback">
                                <ul>
                                    <li>¡El nombre es obligatorio!</li>
                                    <li>¡El nombre debe tener al menos 3 carácteres y menos de 100!</li>
                                    <li>¡El nombre solo acepta letras, números y espacios!</li>
                                </ul>
                            </div>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Imagen de la Marca----------------------------------->
                        <div class="form-group">
                            <label for="img_aviso">Subir Imagen</label>
                            <input id="brand_edit_input_img" type="file" class="img_form"/>
                            <p>Peso máximo de la imagen 200Kb</p>
                            <img id="brand_edit_img_previa" src="<?=base_url()?>assets/img/marcas/default.jpg" alt="" class="img-thumbnail img_previa" width="100px" />
                        </div>
                        <!----------------------------------------------------->
                      </fieldset>
                </form>
            </div>
            
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
            <button form="frm_edit_brand" id="btn_edit_brand" class="btn btn-outline-light" type="submit">Actualizar Marca</button>
          </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


