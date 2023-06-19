<?php
define('_ROOTPATH_', __DIR__);
session_start();
spl_autoload_register();

use App\Controller\Controller;

header("Content-Security-Policy: default-src 'self'");
header("X-Frame-Options: DENY");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");

$controller = new Controller();
$controller->route();
