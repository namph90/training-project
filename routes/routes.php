<?php
require_once("admin.php");
require_once("auth.php");
require_once("user.php");
$controllers = array_merge($controllersAuth, $controllersAdmin, $controllersUser);
if ((!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller]))) {
    $controller = 'home';
    $action = 'error';
}
$fileName = array (
'fileNameAuth' => 'controllers/' . $controllersAuth['prefix'] . $controller . '_controller.php',
'fileNameAdmin' => 'controllers/' . $controllersAdmin['prefix'] . $controller . '_controller.php',
'fileNameUser' => 'controllers/' . $controllersUser['prefix'] . $controller . '_controller.php',
);
foreach ($fileName as $key) {
    if (file_exists($key)) {
        require_once($key);
    }
}

$klass = str_replace('_', '', ucwords($controller, '_')) . 'Controller';
$controller = new $klass;
$controller->$action();