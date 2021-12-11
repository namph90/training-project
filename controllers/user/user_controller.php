<?php

require_once('controllers/base_controller.php');
require_once('models/user/User.php');

class UserController extends BaseController
{
    use User;

    function __construct()
    {
        //$this->authenticationUser();
    }

    public function login()
    {
        $this->render("user/login");
    }
    public function loginPost()
    {
        $this->loginModel();
    }
    public function logout()
    {
        unset($_SESSION["user"]);
        header("location:index.php?controller=user&action=login");
    }

    public function details()
    {
        $id = $_SESSION['user']['id'];
        $data = $this->find($id);
        $this->render("user/detail", ['data' => $data]);
    }
}