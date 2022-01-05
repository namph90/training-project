<?php

require_once('models/AdminModel.php');
require_once('function/Common.php');
require_once('function/UploadImages.php');
require_once('views/elements/error.php');
require_once('models/UserModel.php');
require_once('assets/Facebook/autoload.php');

class BaseController
{
    public $fileName = NULL;
    public $fileLayout = NULL;
    public $view = NULL;

    public function render($fileName, $data = NULL)
    {
        $view_file = 'views/' . $fileName . '.php';
        if (!is_null($data)){
            extract($data);
        }
        if (file_exists($view_file)) {
            $this->fileName = $fileName;
            ob_start();
            require_once($view_file);
            $this->view = ob_get_contents();
            ob_get_clean();
            if ($this->fileLayout != NULL) {
                require_once("views/$this->fileLayout");
            } else {
                echo $this->view;
            }
        } else {
            $this->redirect('index.php?controller=home&action=error');
        }
    }

    public function redirect ($path)
    {
        header("location:".getImgUrl($path));
    }

    public function authenticationAdmin()
    {
        $url = getImgUrl('management/login');
        if (!isset($_SESSION['admin'])) {
            $this->redirect('management/login');
        }
    }

    public function authenticationUser()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('login');
        }
    }

    public function checkRole()
    {
        if (isset($_SESSION['admin']) && $_SESSION['admin']['role'] == "Admin") {
            $this->redirect('management/index');
        }
    }
}
