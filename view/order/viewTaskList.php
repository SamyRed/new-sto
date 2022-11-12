<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="btn btn-outline-secondary nav-link load-container" data-params='{"container":"dialogContainer","content":"dialogOrderAddTask","params":{"order_id":"<?=$orderArr['id']?>"}}' href="#">{ADD_TASK}</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="taskListContainer" class="container">
<?php
    include_once ROOT . '/view/table/orderTaskList.php';
?>
</div>