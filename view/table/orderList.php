<?php
$order = new Order();
if($orderListArr = $order::getList()) {
$fieldList = $order->getFields();
?>
    <table class="table">
        <thead>
            <tr>
<?php
if($fieldList) {
    
    $i = 0;
    
    foreach($fieldList as $field) {
        
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
    foreach($orderListArr as $orderItem) {
        $orderContent = json_decode($orderItem['content'], 1);
?>
            <tr>
<?php
        $i = 0;
        
        foreach($fieldList as $field) {
        
        if($i === 1) {
?>
                <td><a href="/order/<?=$orderItem['id']?>/material-list"><?=$orderItem['sum']?></a></td>
<?php
        }
        
        $i++;
?>
                <td><a href="/order/<?=$orderItem['id']?>/material-list"><?=$orderContent[$field['service_field_name']]?></a></td>
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