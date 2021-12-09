<?php

require_once('controllers/base_controller.php');
require_once('models/AdminModel.php');

class LoginController extends BaseController
{
    use AdminModel;

    public function login()
    {
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