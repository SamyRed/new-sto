<?php
if($storageArr) {
?>
    <h4><?=$storageArr['title']?></h4>
<?php   
}
?>
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
<?php 
if($storageArr) {
?>
                <div class="dropdown ml-2">
                    <a class="nav-link dropdown-toggle btn btn-secondary text-light" data-toggle="dropdown" href="#"><?=$storageArr['title']?></a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<?php
    if($permittedStorageList) {
        foreach($permittedStorageList as $storage) {
?>
                        <li><a class="dropdown-item load-page" data-params='{"uri": "report/storage/<?=$storage['id']?>"}' href="#"><?=$storage['title']?></a></li>
<?php
        }
    }
?>
                    </ul>
                </div>
<?php
}
?>
            </ul>
        </div>
    </div>
</nav>
<div id="materialListConteiner">
<?php
if($storageArr) {
    include_once ROOT . '/view/table/storageMaterialList.php';
}
?>
</div>