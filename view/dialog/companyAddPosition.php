<?php
$position = new Position();
$permissionListArr = $position->getDefaultPerlissionList();
?>
<div class="modal fade" id="dialogCompanyAddPosition" tabindex="-1" role="dialog" aria-labelledby="dialogCompanyAddPositionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dialogCompanyAddPositionLabel">{POSITION_ADDING}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <div class="input-group mb-3 ui-widget">
                        <label for="companyAddPositionTitle" class="input-group-text">{POSITION_TITLE}:</label>
                        <input type="text" class="form-control" name="title" id="companyAddPositionTitle" placeholder="{POSITION_TITLE}">
                    </div>
                    <div class="card card-body">
                        <h5 class="mb-2">{ACCESS_RULES}</h5>
<?php
if($permissionListArr) {
    
    foreach($permissionListArr as $permissionArr) {
        
        if($permissionArr['default_value'] == 1) {
            
            $checked = ' checked';
            
        } else {
            
            $checked = '';
            
        }
?>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input type="checkbox" name="permissionList[]" value="<?=$permissionArr['id']?>" id="companyAddPositionPermission-<?=$permissionArr['id']?>"<?=$checked?>>
                            </div>
                            <label for="companyAddPositionPermission-<?=$permissionArr['id']?>" class="form-control"><?=$permissionArr['title']?></label>
                        </div>
<?php
    }
    
}
?>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{CLOSE}</button>
                    <button type="button" class="btn btn-outline-secondary send-form load-container" data-params='{"action": "positionAdd", "container": "positionListContainer", "content":"tableCompanyPositionList"}' name="save">{SAVE}</button>
                </div>
            </form>
        </div>
    </div>
</div>