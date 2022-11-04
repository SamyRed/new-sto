<h4><?=$storage->content()['title']?></h4>
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <button type="button" class="btn btn-outline-secondary nav-link load-container" data-params='{"container":"dialogContainer","content":"dialogStorageAddMaterial"}'>{ADD_MATERIAL}</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-outline-secondary nav-link load-container ml-2" data-params='{"container":"dialogContainer","content":"dialogStorageAdd"}'>{ADD_STORAGE}</button>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="materialListConteiner">
<?php
include_once ROOT . '/view/table/storageMaterialList.php';
?>
</div>