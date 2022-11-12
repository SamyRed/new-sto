<?php
$company = new Company();
$companyArr = $company->get();
$user = new User();
$userArr = $user->get();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link href="/style/style.css" rel="stylesheet" type="text/css">
        
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="/js/script.js" type="text/javascript"></script>
        
        <title><?=Service::getTitle()?></title>
    </head>
    <body>
        <div style="background: #d5e5eb">
<?php
htmlspecialchars(var_dump('SESSION: ', $_SESSION));
?>
        </div>
        <div id="alertContainer">
<?php
Alert::show();
?>
        </div>
        <nav class="navbar navbar-light navbar-expand-lg"  style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <a class="navbar-brand nav-link load-page" data-params='{"uri":"order/list"}' href="#"><?=Service::config()['title']?></a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link load-page" data-params='{"uri":"storage"}' href="#">{STORAGE}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link load-page" data-params='{"uri":"order/list"}' href="#">{ORDERS}</a>
                        </li>
                    </ul>
                    <div class="d-flex">
<?php
if($companyArr) {
?>
                        <button type="button" class="btn btn-primary load-page" data-params='{"uri":"company/<?=$companyArr['id']?>/info"}'>{COMPANY}</button>
<?php
}
if(!$userArr) {
?>
                        <button type="button" class="btn btn-dark ml-2 load-container" data-params='{"container":"dialogContainer","content":"dialogLogIn"}'>{LOG_IN}</button>
<?php
} else {
?>
                        <button type="button" class="btn btn-dark ml-2 send-data" data-params='{"action":"userLogOut","params":"{}"}'>{LOG_OUT}</button>
<?php
}
?>
                    </div>
                </div>
            </div>
        </nav>
        <div id="dialogContainer"></div>
        <main id="warpper">