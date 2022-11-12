<?php
$worker = new Worker();
$workerListArr = $worker->getList();
?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">{E-MAIL}</th>
            <th scope="col">{TITLE}</th>
            <th scope="col">{POSITION}</th>
            <th scope="col">{DATE}</th>
        </tr>
    </thead>
    <tbody class="table-striped">
<?php
if($workerListArr) {
    foreach($workerListArr as $workerArr) {
?>
        <tr>
            <td><?=$workerArr['email']?></td>
            <td><?=$workerArr['name']?></td>
            <td><?=$workerArr['position_title']?></td>
            <td><?=$workerArr['date']?></td>
        </tr>
<?php
    }
}
?>
    </tbody>
</table>