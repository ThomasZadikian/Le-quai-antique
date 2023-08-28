<?php
define('_ROOTPATH_', __DIR__);
session_start();
spl_autoload_register(function ($className) {
    $filePath = _ROOTPATH_ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

    if (file_exists($filePath)) {
        require_once $filePath;
    }
});

use App\Controller\Controller;

$controller = new Controller();
$controller->route();
