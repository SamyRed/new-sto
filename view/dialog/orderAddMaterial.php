<div class="modal fade" id="dialogOrderAddMaterial" tabindex="-1" role="dialog" aria-labelledby="dialogOrderAddMaterialLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dialogOrderAddMaterialLabel">{MATERIAL_ADDING}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label for="<?=$field['service_field_name']?>" class="input-group-text"><?=$field['field_name']?>:</label>
                        <input type="text" class="form-control" name="<?=$field['service_field_name']?>" id="<?=$field['service_field_name']?>" placeholder="<?=$field['field_name']?>" style="width:200px">
                    </div>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-secondary send-form load-container" data-params='{"container": "orderMaterialListContainer", "action": "orderAddMaterial", "content":"tableOrderMaterialList"}' type="button" name="save">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>