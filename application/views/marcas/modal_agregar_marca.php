<div id="modal_create_brand" class="modal fade" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <!--Encabezado-->
            <div class="modal-header">
                <h4 class="modal-title">Agregar Marca</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            
            <div class="modal-body">
                <form id="frm_create_brand" class="needs-validation" novalidate>
                    <fieldset>
                        <legend>Datos de Nueva Marca</legend>
                        <!--Nombre de la Marca------------------------------------>
                        <div class="form-group">
                            <label for="brand_create_txt_name">Nombre</label>
                            <input id="brand_create_txt_name" class="form-control" type="text" required="required" pattern="[0-9a-zA-ZÁÉÍÓÚáéíóúñÑ ]{3,100}"/>
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
                        
                        <!--Descripción de la Marca------------------------------------>
                        <div class="form-group">
                            <label for="brand_create_txt_name">Descripción</label>
                            <input id="brand_create_txt_description" class="form-control" type="text" required="required" />
                            <div class="valid-feedback">
                                ¡Descripción validada!
                            </div>
                            <div class="invalid-feedback">
                                <ul>
                                    <li>¡La descripción es obligatoria!</li>
                                </ul>
                            </div>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Equipos de la Marca------------------------------------>
                        <div class="form-group">
                            <label for="brand_create_txt_name">Equipos</label>
                            <input id="brand_create_txt_equipments" class="form-control" type="text" required="required" />
                            <div class="valid-feedback">
                                ¡Equipos validado!
                            </div>
                            <div class="invalid-feedback">
                                <ul>
                                    <li>¡Los equipos es obligatorio!</li>
                                </ul>
                            </div>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Aplicaciones de la Marca------------------------------------>
                        <div class="form-group">
                            <label for="brand_create_txt_name">Aplicaciones</label>
                            <input id="brand_create_txt_aplications" class="form-control" type="text" required="required" />
                            <div class="valid-feedback">
                                ¡Aplicación validado!
                            </div>
                            <div class="invalid-feedback">
                                <ul>
                                    <li>¡La aplicación es obligatoria!</li>
                                </ul>
                            </div>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Imagen de la Marca----------------------------------->
                        <div class="form-group">
                            <label for="img_aviso">Subir Imagen</label>
                            <input id="brand_create_input_img" type="file" class="img_form"/>
                            <p>Peso máximo de la imagen 200Kb</p>
                            <img id="brand_create_img_previa" src="<?=base_url()?>assets/img/marcas/default.jpg" alt="" class="img-thumbnail img_previa" width="100px" />
                        </div>
                        <!----------------------------------------------------->
                      </fieldset>
                </form>
            </div>
            
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
            <button form="frm_create_brand" id="btn_send_brand" class="btn btn-outline-light" type="submit">Crear Marca</button>
          </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
