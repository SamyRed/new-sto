<?php
$order = new Order();
$taskListArr = $order->getTaskList();
?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">{TITLE}</th>
            <th scope="col">{AMOUNT}</th>
            <th scope="col">{PRICE}</th>
            <th scope="col">{SUM}</th>
            <th scope="col">{DATE}</th>
        </tr>
    </thead>
    <tbody class="table-striped">
<?php
if($taskListArr) {
    $totalTaskPrice = 0;
    foreach($taskListArr as $taskArr) {
        $totalTaskPrice += $taskArr['sum'];
?>
        <tr>
            <td><?=$taskArr['title']?></td>
            <td><?=$taskArr['amount']?></td>
            <td><?=$taskArr['price']?></td>
            <td><?=$taskArr['sum']?>{UAH}</td>
            <td><?=$taskArr['date']?></td>
        </tr>
<?php
    }
?>
        <tr>
            <td colspan="3" class="text-end">{TOTAL}:</td>
            <td><b><?=$totalTaskPrice?>{UAH}</b></td>
            <td></td>
        </tr>
<?php
}
?>
    </tbody>
</table>