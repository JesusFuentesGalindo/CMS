<div id="modal_link_equipment" class="modal fade" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <!--Encabezado-->
            <div class="modal-header">
                <h4 class="modal-title">Ligar Equipo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            </div>
            
            <div class="modal-body">
                <form id="frm_link_equipment" class="needs-validation" novalidate>
                    <fieldset>
                        <legend>Datos de Nueva Aplicación</legend>
                        
                        <!--Aplicación------------------------------------------->
                        <div class="form-group">
                            <label for="select_equipo">Aplicación</label>
                            <select id="select_equipo" class="form-control">
                                <?php foreach($aplications as $aplication):?>
                                <option value="<?=$aplication['a_id']?>"><?=$aplication['a_name']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <!----------------------------------------------------->
                        
                        <!--Equipo------------------------------------>
                        <div class="form-group">
                            <label for="create_txt_equipo">Equipo</label>
                            <input id="create_txt_equipo" class="form-control" type="text" required="required" pattern="[0-9a-zA-ZÁÉÍÓÚáéíóúñÑ,() ]{1,100}"/>
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
                        
                      </fieldset>
                </form>
            </div>
            
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
            <button form="frm_link_equipment" id="btn_enviar_equipo" class="btn btn-outline-light" type="submit">Ligar Equipo</button>
          </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>