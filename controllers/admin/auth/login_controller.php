<?php

require_once('controllers/base_controller.php');
require_once('models/admin/AdminModel.php');
require_once('config/mess.php');

class LoginController extends BaseController
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
                header("location:index.php?controller=home&action=index");
            } elseif (!isset($dataGetByEmail->id)) {
                $_SESSION['err_email'] = ERROR_LOGIN_EMAIL;
                header("location:index.php?controller=login&action=login");
            } elseif (!isset($dataGetByEmailPass->id)) {
                $_SESSION['err_pass'] = ERROR_LOGIN_PASS;
                header("location:index.php?controller=login&action=login");
            }
        } else {
            if (isset($_SESSION['admin'])) {
                header("location:index.php?controller=home&action=index");
            }
            $this->render("admin/login");
        }
    }

    public function logout()
    {
        unset($_SESSION["admin"]);
        header("location:index.php?controller=login&action=login");
    }
}