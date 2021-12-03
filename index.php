<?php
   session_start();
   include "application/Connection.php";
      include "application/Controller.php";
      $controller = isset($_GET["controller"]) ? $_GET["controller"] : "Home";
      $action = isset($_GET["action"]) ? $_GET["action"] : "index";
      $controllerFile = "controllers/".ucfirst($controller)."Controller.php";
      if (file_exists($controllerFile)) {
         include $controllerFile;
         $controllerClass = ucfirst($controller)."Controller";
         $obj = new $controllerClass();
         $obj->$action();
      } else die("File $controllerFile không tồn tại");
      //---
 ?>