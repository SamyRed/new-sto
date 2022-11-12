<ul class="nav nav-tabs mt-2">
    <li class="nav-item ml-2">
        <a class="nav-link <?php if($subPage == 'Info') echo 'active'?> load-page" data-params='{"uri":"order/<?=$orderArr['id']?>/info"}' href="#">{INFO}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($subPage == 'MaterialList') echo 'active'?> load-page" data-params='{"uri":"order/<?=$orderArr['id']?>/material-list"}' href="#">{MATERIAL_LIST}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($subPage == 'TaskList') echo 'active'?> load-page"data-params='{"uri":"order/<?=$orderArr['id']?>/task-list"}' href="#">{TASK_LIST}</a>
    </li>
</ul>
<div id="subWrapper">
<?php
include_once ROOT . '/view/order/view' . $subPage . '.php';
?>
</div>