<?php
require_once("admin.php");
require_once("auth.php");
$controllers = array_merge($controllersAuth, $controllersAdmin);
if ((!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller]))) {
    $controller = 'home';
    $action = 'error';
}
$fileNameAuth = 'controllers/' . $controllersAuth['prefix'] . $controller . '_controller.php';
$fileNameAdmin = 'controllers/' . $controllersAdmin['prefix'] . $controller . '_controller.php';
if (file_exists($fileNameAuth)) {
    require_once($fileNameAuth);
}
if (file_exists($fileNameAdmin)) {
    require_once($fileNameAdmin);
}

$klass = str_replace('_', '', ucwords($controller, '_')) . 'Controller';
$controller = new $klass;
$controller->$action();