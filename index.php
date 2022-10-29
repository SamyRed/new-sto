<?php

//Global settings
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Set global ROOT global variable
define('ROOT', dirname(__FILE__));
$__TITLE = 'New STO';

session_start();

require_once(ROOT . '/component/Db.php');
require_once(ROOT . '/component/Router.php');

//Router call
$router = new Router();
$router->route();