<ul class="nav nav-tabs mt-2">
    <li class="nav-item ml-2">
        <a class="nav-link <?php if($subPage == 'Info') echo 'active'?> load-page" data-params='{"uri":"company/<?=$companyArr['id']?>/info"}' href="#">{INFO}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($subPage == 'PositionList') echo 'active'?> load-page" data-params='{"uri":"company/<?=$companyArr['id']?>/position-list"}' href="#">{POSITION_LIST}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($subPage == 'WorkerList') echo 'active'?> load-page"data-params='{"uri":"company/<?=$companyArr['id']?>/worker-list"}' href="#">{WORKER_LIST}</a>
    </li>
    <li class="nav-item ml-2">
        <a class="nav-link <?php if($subPage == 'Log') echo 'active'?> load-page" data-params='{"uri":"company/<?=$companyArr['id']?>/log"}' href="#">{LOG}</a>
    </li>
</ul>
<div id="subWrapper">
<?php
include_once ROOT . '/view/company/view' . $subPage . '.php';
?>
</div>