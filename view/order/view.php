<h4><?=$order['car_name']?> | <?=$order['car_number']?> | <?=$order['issue_year']?></h4>
<nav>
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if($subPage == 'Info') echo 'active'?>">
            <a class="page-link load-page" data-params='{"uri":"order/<?=$order['id']?>/info"}' href="#">{INFO}</a>
        </li>
        <li class="page-item <?php if($subPage == 'MaterialList') echo 'active'?>">
            <a class="page-link load-page" data-params='{"uri":"order/<?=$order['id']?>/material-list"}' href="#">{MATERIAL_LIST}</a>
        </li>
        <li class="page-item <?php if($subPage == 'TaskList') echo 'active'?>">
            <a class="page-link load-page"data-params='{"uri":"order/<?=$order['id']?>/task-list"}' href="#">{TASK_LIST}</a>
        </li>
    </ul>
</nav>
<div id="subWrapper">
<?php
include_once ROOT . '/view/order/view' . $subPage . '.php';
?>
</div>