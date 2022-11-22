<ul class="nav nav-tabs mt-2">
    <li class="nav-item ml-2">
        <a class="nav-link <?php if($subPage == 'salary') echo 'active'?> load-page" data-params='{"uri":"report/salary"}' href="#">{SALARY}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($subPage == 'storage') echo 'active'?> load-page" data-params='{"uri":"report/storage"}' href="#">{STORAGE}</a>
    </li>
</ul>
<div id="subWrapper">
<?php
include_once ROOT . '/view/company/report' . $subPage . '.php';
?>
</div>