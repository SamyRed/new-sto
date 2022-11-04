<?php
$order = new Order();
?>
<div class="modal fade" id="dialogStorageAdd" tabindex="-1" role="dialog" aria-labelledby="dialogStorageAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dialogStorageAddLabel">{STORAGE_ADDING}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#">
                <div class="modal-body">
<?php
foreach($order->fieldList() as $field) {
    $params = json_decode($field['parameters'], 1);
    if($params['type'] == 'text') {
?>
                    <div class="input-group mb-3">
                        <label for="<?=$field['service_field_name']?>" class="input-group-text"><?=$field['field_name']?>:</label>
                        <input type="text" class="form-control" name="<?=$field['service_field_name']?>" id="<?=$field['service_field_name']?>" placeholder="<?=$field['field_name']?>">
                    </div>  
<?php
    } else if($params['type'] == 'number') {
?>
                    <div class="input-group mb-3">
                        <label for="<?=$field['service_field_name']?>" class="input-group-text"><?=$field['field_name']?>:</label>
                        <input type="number" class="form-control" name="<?=$field['service_field_name']?>" id="<?=$field['service_field_name']?>" placeholder="<?=$field['field_name']?>">
                    </div>  
<?php
    } else if($params['type'] == 'year') {
        if($params['max'] == 'NOW') {
            $params['max'] = date('Y');
        }
?>
                    <div class="input-group mb-3">
                        <label for="<?=$field['service_field_name']?>" class="input-group-text"><?=$field['field_name']?>:</label>
                        <select class="form-control" name="<?=$field['service_field_name']?>" id="<?=$field['service_field_name']?>" placeholder="<?=$field['field_name']?>">
                            <option value="<?=$params['default']?>"><?=$params['default']?></option>
<?php
            for($i = $params['min']; $i <= $params['max']; $i++){
                if($i == $params['default']) {
                    
                    $selected = ' selected';
                    
                } else {
                    
                    $selected = '';
                    
                }
?>
                            <option <?=$selected?> value="<?=$i?>"><?=$i?></option>
<?php
            }
?>
                        </select>
                    </div>  
<?php
    } else if($params['type'] == 'select') {
?>
                    <div class="input-group mb-3">
                        <label for="<?=$field['service_field_name']?>" class="input-group-text"><?=$field['field_name']?>:</label>
                        <select class="form-control" name="<?=$field['service_field_name']?>" id="<?=$field['service_field_name']?>" placeholder="<?=$field['field_name']?>">
<?php
            foreach($params['list'] as $key => $element){
?>
                            <option value="<?=$element?>"><?=$element?></option>
<?php
            }
?>
                        </select>
                    </div>  
<?php
    }
}
?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-secondary send-form load-container" data-params='{"container": "orderListContainer", "action": "orderAdd", "content":"tableOrderList"}' type="button" name="save">{SAVE}</button>
                </div>
            </form>
        </div>
    </div>
</div>