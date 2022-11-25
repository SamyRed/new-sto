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
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
        <nav class="navbar navbar-light navbar-expand"  style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <a class="navbar-brand nav-link load-page" data-params='{"uri":"order/list"}' href="#"><?=Service::config()['title']?></a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item d-xxl-flex d-xl-flex d-lg-flex d-md-none d-sm-none d-xs-none">
                            <a class="nav-link load-page" data-params='{"uri":"storage"}' href="#">{STORAGE}</a>
                        </li>
                        <li class="nav-item d-xxl-flex d-xl-flex d-lg-flex d-md-none d-sm-none d-xs-none">
                            <a class="nav-link load-page" data-params='{"uri":"order/list"}' href="#">{ORDER_LIST}</a>
                        </li>
                        <li class="nav-item d-xxl-flex d-xl-flex d-lg-flex d-md-none d-sm-none d-xs-none">
                            <a class="nav-link load-page" data-params='{"uri":"report/salary"}' href="#">{REPORT}</a>
                        </li>
                    </ul>
<?php
if($companyArr) {
?>
                    <ul class="navbar-nav d-flex">
                        <li class="nav-item">
                            <a class="btn btn-primary load-page"  data-params='{"uri":"company/<?=$companyArr['id']?>/info"}' href="#">{COMPANY}</a>
                        </li>
<?php
}
if(!$userArr) {
?>
                        <li class="nav-item">
                            <a class="btn btn-dark ml-2 load-container" data-params='{"container":"dialogContainer","content":"dialogLogIn"}' href="#">{LOG_IN}</a>
                        </li>
<?php
} else {
?>
                        <li class="nav-item">
                            <a class="btn btn-dark ml-2 send-data" data-params='{"action":"userLogOut","params":"{}"}' href="#">{LOG_OUT}</a>
                        </li>
                    </ul>
<?php
}
?>
                </div>
            </div>
        </nav>
        <div id="dialogContainer"></div>
        <main class="container card mt-2 mb-2" id="warpper">