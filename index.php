<?php
session_start();
require_once('connection.php');
require_once('controllers/Validated/AdminValidated.php');
require_once('controllers/Validated/UserValidated.php');
require_once('controllers/function/UploadImages.php');
require_once('controllers/function/Paginate.php');
require_once('config/config.php');
require_once('config/mess.php');

if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    } else {
        $action = 'index';
    }
} else {
    $controller = 'user';
    $action = 'login';
}
require_once('routes/routes.php');
