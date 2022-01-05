<?php
require_once("admin.php");
require_once("auth.php");
require_once("user.php");
$controllers = array_merge($controllersAuth, $controllersAdmin, $controllersUser);
if ((!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller], true))) {
    $controller = 'Home';
    $action = 'error';
}
$fileName = array (
'fileNameAuth' => 'controllers/' . $controllersAuth['prefixAdmin'] . $controller . 'Controller.php',
'fileNameAdmin' => 'controllers/' . $controllersAdmin['prefix'] . $controller . 'Controller.php',
'fileNameUser' => 'controllers/' . $controllersUser['prefix'] . $controller . 'Controller.php',
'fileNameUserAuth' => 'controllers/' . $controllersAuth['prefixUser'] . $controller . 'Controller.php',
);
foreach ($fileName as $key) {
    if (file_exists($key)) {
        require_once($key);
    }
}

$klass = str_replace('_', '', ucwords($controller, '_')) . 'Controller';
$controller = new $klass;
$controller->$action();