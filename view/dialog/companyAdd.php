<?php
$order = new Order();
?>
<div class="modal fade" id="dialogCompanyAdd" tabindex="-1" role="dialog" aria-labelledby="dialogCompanyAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dialogCompanyAddLabel">{COMPANY_ADDING}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label for="companyAddTitle" class="input-group-text">{TITLE}:</label>
                        <input type="text" class="form-control" name="title" id="companyAddTitle" placeholder="{TITLE}">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <label for="companyAddHeadPositionTitle" class="input-group-text">{HEAD_POSITION_TITLE}:</label>
                        <input type="text" class="form-control" name="position_title" id="companyAddHeadPositionTitle" placeholder="{TITLE}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{CLOSE}</button>
                    <button type="button" class="btn btn-outline-secondary send-form" data-params='{"action": "companyAdd"}' type="button" name="save">{SAVE}</button>
                </div>
            </form>
        </div>
    </div>
</div>