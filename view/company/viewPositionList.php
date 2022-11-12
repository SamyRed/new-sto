<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="btn btn-outline-secondary nav-link load-container" data-params='{"container":"dialogContainer","content":"dialogCompanyAddPosition"}' href="#">{ADD_POSITION}</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="positionListContainer" class="container">
<?php
    include_once ROOT . '/view/table/companyPositionList.php';
?>
</div>