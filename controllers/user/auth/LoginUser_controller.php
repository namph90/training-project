<?php
require_once('controllers/base_controller.php');
require_once('models/admin/UserModel.php');

class LoginUser_controller extends BaseController
{
    public $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }
    public function login()
    {
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $data = $this->model->loginPost($email, $password);
            $dataGetByEmailPass = $data['dataGetByEmailPass'];
            $dataGetByEmail = $data['dataGetByEmail'];
            $_SESSION['email_create'] = $email;

            if (isset($dataGetByEmailPass->id)) {
                $_SESSION['user'] = array(
                    "id" => $dataGetByEmailPass->id,
                    "email" => $dataGetByEmailPass->email
                );

                $_SESSION["mess"] = LOGIN_SUCCESSFUL;
                unset($_SESSION['email_create']);
                header("location:profile");
            } elseif (!isset($dataGetByEmail->id)) {
                $_SESSION['err_email'] = ERROR_LOGIN_EMAIL;
                header("location:login");
            } elseif (!isset($dataGetByEmailPass->id)) {
                $_SESSION['err_pass'] = ERROR_LOGIN_PASS;
                header("location:login");
            }
        } else {
            if (isset($_SESSION['user'])) {
                header("location:profile");
            }
            require_once('config/fbconfig.php');
            $helper = $fb->getRedirectLoginHelper();
            $permissions = ['email'];
            $loginUrl = $helper->getLoginUrl('https://phn.com/TT/BT_TTS/index.php?controller=user&action=loginFb', $permissions);
            $this->render("user/login", ['loginUrl' => $loginUrl]);
        }
    }
}