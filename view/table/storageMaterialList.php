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
    $totalMaterialsPrice = 0;
    foreach($materialList as $material) {
        $totalMaterialsPrice += $material['price'] * $material['amount'];
?>
        <tr>
            <td><?=$material['title']?></td>
            <td><?=$material['amount']?> <?=$material['unit']?></td>
            <td><?=$material['price']?>/<?=$material['unit']?></td>
            <td><?=$material['price'] * $material['amount']?>{UAH}</td>
        </tr>
<?php
    }
?>
        <tr>
            <td colspan="3" class="text-end">{TOTAL}:</td>
            <td><b><?=$totalMaterialsPrice?>{UAH}</b></td>
        </tr>
    </tbody>
</table>