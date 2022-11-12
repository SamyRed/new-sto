<?php
$order = new Order();
$materialList = $order->getMaterialList();
?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">{TITLE}</th>
            <th scope="col">{AMOUNT}</th>
            <th scope="col">{STORAGE}</th>
            <th scope="col">{PRICE}</th>
            <th scope="col">{SUM}</th>
            <th scope="col">{DATE}</th>
        </tr>
    </thead>
    <tbody class="table-striped">
<?php
if($materialList) {
    $totalMaterialsPrice = 0;
    foreach($materialList as $material) {
        $totalMaterialsPrice += $material['price'] * $material['amount'];
?>
        <tr>
            <td><?=$material['title']?></td>
            <td><?=$material['amount']?> <?=$material['unit']?></td>
            <td><?=$material['storage_title']?></td>
            <td><?=$material['price']?>/<?=$material['unit']?></td>
            <td><?=$material['sum']?>{UAH}</td>
            <td><?=$material['date']?></td>
        </tr>
<?php
    }
?>
        <tr>
            <td colspan="4" class="text-end">{TOTAL}:</td>
            <td><b><?=$totalMaterialsPrice?>{UAH}</b></td>
            <td></td>
        </tr>
<?php
}
?>
    </tbody>
</table>