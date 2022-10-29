<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/style/style.css" rel="stylesheet" type="text/css">
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="/js/JQuery.js" type="text/javascript"></script>
        <script src="/js/script.js" type="text/javascript"></script>
        
        <title><?=Service::getTitle()?></title>
    </head>
    <body>
        <div style="background: #d5e5eb">
<?php
var_dump('COOKIE: ', $_COOKIE);
var_dump('<br>SESSION: ', $_SESSION);
?>
        </div>
        <div id="alertContainer">
<?php
Alert::show();
?>
        </div>
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand nav-link load-container" data-params='{"setURI":"/order/list","container":"warpper","content":"storageMaterials"}' href="#"><?=Service::config()['title']?></a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link load-container" data-params='{"setURI":"/storage/materials","container":"warpper","content":"storageMaterials"}' href="#">{STORAGE}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link load-container" data-params='{"setURI":"order/list","container":"warpper","content":"orderList"}' href="#">{ORDERS}</a>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </nav>
        <div id="dialogContainer"></div>
        <main id="warpper">