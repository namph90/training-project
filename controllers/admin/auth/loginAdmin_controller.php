<?php

require_once('controllers/base_controller.php');
require_once('models/admin/AdminModel.php');
require_once('config/mess.php');
require_once('function/Common.php');
require_once('views/elements/error.php');

class LoginAdminController extends BaseController
{
    public $model;

    public function __construct()
    {
        $this->model = new AdminModel();
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
                $_SESSION['admin'] = array(
                    "id" => $dataGetByEmailPass->id,
                    "email" => $dataGetByEmailPass->email,
                    "role" => $dataGetByEmailPass->role
                );

                $_SESSION["mess"] = LOGIN_SUCCESSFUL;
                unset($_SESSION['email_create']);
                header("location:index");

            } elseif (!isset($dataGetByEmail->id)) {
                $_SESSION['errLogin']['email']['err'] = ERROR_LOGIN_EMAIL;
                header("location:login");

            } elseif (!isset($dataGetByEmailPass->id)) {
                $_SESSION['errLogin']['pass']['err'] = ERROR_LOGIN_PASS;
                header("location:login");
            }
        } else {
            if (isset($_SESSION['admin'])) {
                header("location:index");
            }
            $this->render("admin/login");
        }
    }

    public function logout()
    {
        unset($_SESSION["admin"]);
        header("location:login");
    }
}