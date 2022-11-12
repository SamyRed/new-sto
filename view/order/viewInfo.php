<?php
$order = new Order();
$fieldList = $order->getFields();
?>
<div class="container mt-2" id="orderInfoContainer">
<?php
if($fieldList) {
    foreach($order->getFields() as $field) {
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
    
}
?>
</div>