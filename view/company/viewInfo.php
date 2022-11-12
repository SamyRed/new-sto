<?php
$company = new Company();
$companyArr = $company->get();
?>
<div id="InfoContainer" class="container">
<?php
if($companyArr) {
?>
    <div class="input-group mb-3">
        <label for="companyTitle" class="input-group-text">{TITLE}:</label>
        <input type="text" class="form-control" name="title" id="companyTitle" placeholder="{TITLE}" value="<?=$companyArr['title']?>">
    </div>
<?php
}
?>
</div>