<table class="table">
    <thead>
        <tr>
            <th scope="col">{TITLE}</th>
            <th scope="col">{AMOUNT}</th>
            <th scope="col">{PRICE}</th>
            <th scope="col">{SUMM}</th>
        </tr>
    </thead>
    <tbody class="table-striped">
<?php
$storage = new Storage();
$materialListArr = $storage->getMaterialList();
if($materialListArr) {
    $totalMaterialsPrice = 0;
    foreach($materialListArr as $materialArr) {
        $totalMaterialsPrice += $materialArr['sum'];
?>
        <tr>
            <td><?=$materialArr['title']?></td>
            <td><?=$materialArr['amount']?> <?=$materialArr['unit']?></td>
            <td><?=$materialArr['price']?>/<?=$materialArr['unit']?></td>
            <td><?=$materialArr['sum']?>{UAH}</td>
        </tr>
<?php
    }
?>
        <tr>
            <td colspan="3" class="text-end">{TOTAL}:</td>
            <td><b><?=$totalMaterialsPrice?>{UAH}</b></td>
        </tr>
<?php
}
?>
    </tbody>
</table>