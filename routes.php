<?php
$controllers = array(
    'home' => ['index', 'error'],
    'admin' => ['index', 'login', 'loginPost', 'logout', 'create', 'createPost', 'update', 'updatePost']
);
if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
    $controller = 'home';
    $action = 'error';
}

include_once('controllers/' . $controller . '_controller.php');
$klass = str_replace('_', '', ucwords($controller, '_')) . 'Controller';
$controller = new $klass;
$controller->$action();