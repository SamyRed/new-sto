<?php
$order = new Order();
if($orderListArr = $order::getList()) {
?>
    <table class="table">
        <thead>
            <tr>
<?php
if($order->getFields()) {
    foreach($order->getFields() as $field) {
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
        foreach($order->getFields() as $field) {
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