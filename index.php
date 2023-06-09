<?php
define('_ROOTPATH_', __DIR__);
session_start();
spl_autoload_register();

use App\Controller\Controller;

$controller = new Controller();
$controller->route();
