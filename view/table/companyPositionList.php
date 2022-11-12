<?php
$position = new Position();
$positionListArr = $position->getList();
?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">{TITLE}</th>
        </tr>
    </thead>
    <tbody class="table-striped">
<?php
if($positionListArr) {
    foreach($positionListArr as $positionArr) {
?>
        <tr>
            <td><a class="load-container" data-params='{"container": "dialogContainer", "content": "dialogCompanyViewPosition", "params": {"positionId": "<?=$positionArr['id']?>"}}' href="#"><?=$positionArr['title']?></a></td>
        </tr>
<?php
    }
}
?>
    </tbody>
</table>