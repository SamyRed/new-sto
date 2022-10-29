<?php
$order = new Order();
$orderList = json_decode($order::getList(), 1)['result'];
?>
    <table class="table">
        <thead>
            <tr>
<?php
if($order->fieldList() !== false) {
    foreach($order->fieldList() as $field) {
?>
                <th scope="col"><?=$field['field_name']?></th>
<?php
    }
?>
            </tr>
        </thead>
        <tbody class="table-striped">
<?php
    foreach($orderList as $orderItem) {
        $orderContent = json_decode($orderItem['content'], 1);
?>
            <tr>
<?php
        foreach($order->fieldList() as $field) {
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