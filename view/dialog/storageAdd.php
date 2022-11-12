<?php
$worker = new Worker();
$position = new Position();
$workerListArr = $worker->getList();
$positionListArr = $position->getList();
?>
<div class="modal fade" id="dialogStorageAdd" tabindex="-1" role="dialog" aria-labelledby="dialogStorageAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dialogStorageAddLabel">{STORAGE_ADDING}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label for="title" class="input-group-text">{TITLE}:</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="{TITLE}">
                    </div>
                    <div class="input-group mb-3">
                        <label for="description" class="input-group-text">{DESCRIPTION}:</label>
                        <input type="text" class="form-control" name="description" id="description" placeholder="{DESCRIPTION}">
                    </div>
                    <div class="container card card-body" id="storageAccessRules">
                        <div class="row">
                            <h5>{WHO_HAVE_BEEN_ACCESS_TO_THIS_STORAGE}:</h5>
                            <div class="col">
<?php 
if($workerListArr) {
?>
                                <div class="input-group mb-3">
                                    <label class="input-group-text">{WORKER}:</label>
                                    <select class="form-select">
<?php
    foreach ($workerListArr as $workerArr) {
?>
                                        <option value="<?=$workerArr['id']?>"><?=$workerArr['name']?></option>
<?php
    }
?>
                                    </select>
                                    <button class="btn btn-outline-secondary" data-type="worker" type="button">{ADD}</button>
                                </div>
                                <div class="choosen"></div>
<?php
}
?>
                            </div>
                            <div class="col">
<?php 
if($positionListArr) {
?>
                                <div class="input-group mb-3">
                                    <label class="input-group-text">{POSITION}:</label>
                                    <select class="form-select">
<?php
    foreach ($positionListArr as $positionArr) {
?>
                                        <option value="<?=$positionArr['id']?>"><?=$positionArr['title']?></option>
<?php
    }
?>
                                    </select>
                                    <button class="btn btn-outline-secondary" data-type="position" type="button">{ADD}</button>
                                </div>
                                <div class="choosen"></div>
<?php
}
?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{CLOSE}</button>
                    <button type="button" class="btn btn-outline-secondary send-form load-container" data-params='{"action": "storageAdd", "container": "warpper", "content": "storageView"}' type="button" name="save">{SAVE}</button>
                </div>
            </form>
        </div>
    </div>
</div>