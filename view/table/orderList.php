<?php
$order = new Order();
$statusListArr = $order->getStatusList();
if($orderListArr = $order::getList()) {
$fieldListArr = $order->getFields();
?>
    <table class="table">
        <thead>
            <tr>
                <th>{STATUS}</th>
<?php
if($fieldListArr) {
    
    $i = 0;
    
    foreach($fieldListArr as $field) {
        
        if($i === 1) {
?>
                <th scope="col">{SUM_FOR_WORK}</th>    
<?php
        }
        
        $i++;
?>
                <th scope="col"><?=$field['field_name']?></th>
<?php
    }
?>
            </tr>
        </thead>
        <tbody class="table-striped">
<?php
    foreach($orderListArr as $orderArr) {
        $orderContent = json_decode($orderArr['content'], 1);
?>
            <tr>
                <td>
                    <select id="orderSetStatus" data-params='{"order_id":"<?=$orderArr['id']?>"}'>
<?php
        foreach($statusListArr as $statusArr) {
            
            if($statusArr['id'] === $orderArr['status_id']) {
                
                $selected = 'selected';
                
            } else {
                
                $selected = '';
                
            }
?>
                        <option <?=$selected?> value="<?=$statusArr['id']?>"><?=$statusArr['title']?></option>
<?php
        }
?>
                    </select>
                </td>
<?php
        $i = 0;
        
        foreach($fieldListArr as $field) {
        
        if($i === 1) {
?>
                <td><a href="/order/<?=$orderArr['id']?>/material-list"><?=$orderArr['sum']?></a></td>
<?php
        }
        
        $i++;
?>
                <td><a href="/order/<?=$orderArr['id']?>/material-list"><?=$orderContent[$field['service_field_name']]?></a></td>
<?php
        }
?>
            </tr>
<?php
    }
}
?>
        </tbody>
    </table>
<?php
} else {
?>
    <div class="alert alert-info">{LIST_OF_ORDERS_EMPTY}</div>
<?php
} 
?>