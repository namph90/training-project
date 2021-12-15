<?php

require_once('controllers/base_controller.php');
require_once('models/user/User.php');
require_once ('assets/Facebook/autoload.php');

class UserController extends BaseController
{
    use User;

    function __construct()
    {

    }

    public function login()
    {
        include 'config/fbconfig.php';
        $helper = $fb->getRedirectLoginHelper();
        //$permissions = ['email'];
        $loginUrl = $helper->getLoginUrl('https://phn.com/TT/MVC_Thuan/index.php?controller=user&action=loginFb');
        $this->render("user/login",['loginUrl'=>$loginUrl]);
    }
    public function loginPost()
    {
        $this->loginModel();
    }
    public function logout()
    {
        unset($_SESSION["user"]);
        header("location:login");
    }

    public function details()
    {
        $id = $_SESSION['user']['id'];
        $data = $this->find($id);
        $this->render("user/detail", ['data' => $data]);
    }
    public function loginFb()
    {
        $this->loginFbModel();
    }
}