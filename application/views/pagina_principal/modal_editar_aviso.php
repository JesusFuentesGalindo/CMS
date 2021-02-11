<div id="modal_edit_notice" class="modal fade" aria-modal="true">
        <div class="modal-dialog">
          <div class="modal-content bg-primary">
              
            <div class="modal-header">
                <h4 class="modal-title">Editar Aviso</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
              
            <div class="modal-body">
              <form id="frm_edit_notice" class="needs-validation" novalidate enctype="multipart/form-data">
                    <fieldset>
                        <legend>Datos de Aviso</legend>
                        <!--Nombre de Aviso------------------------------------>
                        <div class="form-group">
                            <label for="edit_txt_nombre">Nombre</label>
                            <input id="edit_txt_nombre" class="form-control" type="text" required="required" pattern="[0-9a-zA-ZÁÉÍÓÚáéíóúñÑ ]{3,50}" />
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
                            <label for="edit_txt_texto">Texto del Aviso</label>
                            <textarea id="edit_txt_texto" class="form-control" rows="3" placeholder="Grandes ofertas..."></textarea>
                            <div class="valid-feedback">
                                ¡Texto validado!
                            </div>
                            <div class="invalid-feedback">
                                ¡Ingrese un texto valido!
                            </div>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Posición del Texto--------------------------------->
                        <div class="form-group">
                            <label for="edit_select_posicion">Posición del Texto</label>
                            <select id="edit_select_posicion" class="form-control">
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
                        
                        <!--Seleccionar Color---------------------------------->
                        <div class="form-group">
                            <label for="edit_text_color">Color del Texto</label>
                            <div class="input-group my-colorpicker2 colorpicker-element" data-colorpicker-id="2">
                                <input id="edit_text_color" type="text" class="form-control" data-original-title title>

                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!----------------------------------------------------->
                         
                        <!--Producto------------------------------------------->
                        <div class="form-group">
                            <label for="edit_select_producto">Producto</label>
                            <select id="edit_select_producto" class="form-control">
                                <?php foreach($products['data'] as $product):?>
                                <option value="<?=$product['p_id']?>"><?=$product['p_name']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Imagen del Aviso----------------------------------->
                        <div class="form-group">
                            <label for="img_aviso">Subir Imagen</label>
                            <input id="edit_img_aviso" type="file" class="img_form" />
                            <p>Peso máximo de la imagen 2MB</p>
                            <img id="edit_img_previa" src="<?=base_url()?>assets/img/avisos/default.jpg" alt="" class="img-thumbnail img_previa" width="100px" />
                        </div>
                        <!----------------------------------------------------->
                      </fieldset>
                </form>
            </div>
              
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
              <button form="frm_edit_notice" type="submit" class="btn btn-outline-light">Guardar Cambios</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
