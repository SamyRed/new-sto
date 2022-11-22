<?php
$position = new Position();
$positionListArr = $position->getList();
?>
<div class="modal fade" id="dialogCompanyAddWorker" tabindex="-1" role="dialog" aria-labelledby="dialogCompanyAddWorkerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dialogCompanyAddWorkerLabel">{WORKER_ADDING}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label for="companyAddWorkerEmail" class="input-group-text">{EMAIL}:</label>
                        <input type="text" class="form-control" name="email" id="companyAddWorkerEmail" placeholder="{EMAIL}">
                    </div>
<?php 
if($positionListArr) {
?>
                    <div class="input-group mb-3">
                        <label for="companyAddWorkerPositionId" class="input-group-text">{POSITION}:</label>
                        <select class="custom-select" name="position_id" id="companyAddWorkerPositionId">
<?php
    foreach($positionListArr as $positionArr) {
?>
                        <option value="<?=$positionArr['id']?>"><?=$positionArr['title']?></option>
<?php
    }
?>
                        </select>
                    </div>
<?php
}
?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{CLOSE}</button>
                    <button type="button" class="btn btn-outline-secondary send-form" data-params='{"action": "companyAddWorker", "container": "workerListContainer", "content":"tableCompanyWorkerList"}' name="save">{SAVE}</button>
                </div>
            </form>
        </div>
    </div>
</div>