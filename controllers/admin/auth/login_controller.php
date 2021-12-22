<?php

require_once('controllers/base_controller.php');
require_once('models/admin/AdminModel.php');

class LoginController extends BaseController
{
    use AdminModel;

    public function login()
    {
        if (isset($_SESSION['admin'])) {
            header("location:index.php?controller=home&action=index");
        }
        $this->render("admin/login");
    }

    public function loginPost()
    {
        $this->loginModel();
    }

    public function logout()
    {
        unset($_SESSION["admin"]);
        header("location:index.php?controller=login&action=login");
    }
}