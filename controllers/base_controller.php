<?php

class BaseController
{
    public $fileName = NULL;
    public $fileLayout = NULL;
    public $view = NULL;

    public function render($fileName, $data = NULL)
    {
        $view_file = 'views/' . $fileName . '.php';
        if (!is_null($data))
            extract($data);
        if (file_exists($view_file)) {
            $this->fileName = $fileName;
            ob_start();
            require_once($view_file);
            $this->view = ob_get_contents();
            ob_get_clean();
            if ($this->fileLayout != NULL)  {
                require_once("views/$this->fileLayout");
            } else {
                echo $this->view;
            }
        } else {
            header('Location: index.php?controller=home&action=error');
        }
    }

    public function authenticationAdmin()
    {
        $url = getImgUrl('management/login');
        if (!isset($_SESSION['admin'])) {
            header("location:".getImgUrl('management/login'));
        }
    }

    public function authenticationUser()
    {
        if (!isset($_SESSION['user'])) {
            header("location:".getImgUrl('login'));
        }
    }

    public function checkRole()
    {
        if (isset($_SESSION['admin']) && $_SESSION['admin']['role'] == "Admin") {
            echo "<script type='text/javascript'>alert('you do not have permission to access');</script>";
            header("location:".getImgUrl('management/index'));
        }

    }
}