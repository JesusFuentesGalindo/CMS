<div id="modal_agregar_aviso" class="modal fade" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <!--Encabezado-->
            <div class="modal-header">
                <h4 class="modal-title">Agregar Aviso</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            
            <div class="modal-body">
                <form id="frm_agregar_aviso" class="needs-validation" novalidate>
                    <fieldset>
                        <legend>Datos de Nuevo Aviso</legend>
                        <!--Nombre de Aviso------------------------------------>
                        <div class="form-group">
                            <label for="txt_nombre">Nombre</label>
                            <input id="txt_nombre" class="form-control" type="text" required="required" pattern="[0-9a-zA-ZÁÉÍÓÚáéíóúñÑ ]{3,50}"/>
                            <div class="valid-feedback">
                                ¡Nombre validado!
                            </div>
                            <div class="invalid-feedback">
                                <ul>
                                    <li>¡El nombre es obligatorio!</li>
                                    <li>¡El nombre debe tener al menos 3 carácteres y menos de 50!</li>
                                    <li>¡El nombre solo acepta letras, números y espacios!</li>
                                </ul>
                            </div>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Texto Aviso---------------------------------------->
                        <div class="form-group">
                            <label for="txt_texto">Texto del Aviso</label>
                            <textarea id="txt_texto" class="form-control" rows="3" placeholder="Grandes ofertas..."></textarea>
                            <div class="valid-feedback">
                                ¡Texto validado!
                            </div>
                            <div class="invalid-feedback">
                                <ul>
                                    <li>¡El texto solo acepta letras, números, espacios los signos % y ? !</li>
                                </ul>
                            </div>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Posición del Texto--------------------------------->
                        <div class="form-group">
                            <label for="select_posicion">Posición del Texto</label>
                            <select id="select_posicion" class="form-control">
                                <option value="1">1 izquierda-arriba</option>
                                <option value="2">2 centro-arriba</option>
                                <option value="3">3 derecha-arriba</option>
                                <option value="4">4 izquierda-centro</option>
                                <option value="5">5 centro-centro</option>
                                <option value="6">6 derecha-centro</option>
                                <option value="7">7 izquierda-abajo</option>
                                <option value="8">8 centro-abajo</option>
                                <option value="9">9 derecha-abajo</option>
                            </select>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Seleccionar Color----------------------------------->
                        <div class="form-group">
                            <label for="text_color">Color del Texto</label>
                            <div class="input-group my-colorpicker2 colorpicker-element" data-colorpicker-id="2">
                                <input id="text_color" type="text" class="form-control" data-original-title="" title="">

                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-square" style="color: rgb(210, 38, 38);"></i></span>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!----------------------------------------------------->
                         
                        <!--Producto------------------------------------------->
                        <div class="form-group">
                            <label for="select_producto">Producto</label>
                            <select id="select_producto" class="form-control">
                                <?php foreach($products['data'] as $product):?>
                                <option value="<?=$product['p_id']?>"><?=$product['p_name']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Imagen del Aviso----------------------------------->
                        <div class="form-group">
                            <label for="img_aviso">Subir Imagen</label>
                            <input id="img_aviso" type="file" class="img_form"/>
                            <p>Peso máximo de la imagen 200Kb</p>
                            <img id="create_img_previa" src="<?=base_url()?>assets/img/avisos/default.jpg" alt="" class="img-thumbnail img_previa" width="100px" />
                        </div>
                        <!----------------------------------------------------->
                      </fieldset>
                </form>
            </div>
            
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
            <button form="frm_agregar_aviso" id="btn_enviar_aviso" class="btn btn-outline-light" type="submit">Crear Aviso</button>
          </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>