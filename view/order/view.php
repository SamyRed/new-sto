<h4><?=$order->content()['car_name']?> | <?=$order->content()['car_number']?> | <?=$order->content()['issue_year']?></h4>
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="btn btn-outline-secondary nav-link load-container" data-params='{"setURI":"/order/1/info","container":"subWrapper","content":"orderViewInfo"}' href="#">{INFO}</a>
                </li>
                <li class="nav-item ml-2">
                    <a class="btn btn-outline-secondary nav-link load-container" data-params='{"setURI":"/order/1/material-list","container":"subWrapper","content":"orderViewMaterialList"}' href="#">{MATERIAL_LIST}</a>
                </li>
                <li class="nav-item ml-2">
                    <a class="btn btn-outline-secondary nav-link load-container" data-params='{"setURI":"/order/1/task-list","container":"subWrapper","content":"orderViewTaskList"}' href="#">{TASK_LIST}</a>
                </li>
            </ul>

        </div>
    </div>
</nav>
<div id="subWrapper">
<?php
include_once ROOT . '/view/order/view' . $subPage . '.php';
?>
</div>