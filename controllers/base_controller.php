<?php

class BaseController
{
    public $fileName = NULL;
    public $fileLayout = NULL;
    public $view = NULL;

    public function render($fileName, $data = NULL)
    {
        $view_file = 'views/'. $fileName . '.php';
        if ($data != NULL)
            extract($data);
        if (file_exists($view_file)) {
            $this->fileName = $fileName;
            ob_start();
            require_once ($view_file);
            $this->view = ob_get_contents();
            ob_get_clean();
            if ($this->fileLayout != NULL)
                require_once ("views/$this->fileLayout");
            else
                echo $this->view;
        } else {
            header('Location: index.php?controller=home&action=error');
        }
    }
    public function authentication() {
        if(isset($_SESSION['admin']) == false)
            header("location:index.php?controller=login&action=login");
    }
}