<?php

require_once('controllers/BaseController.php');
require_once('models/AdminModel.php');

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
            $data = $this->model->checkLogin($email, $password);
            $dataGetByEmailPass = $data['dataGetByEmailPass'];
            $_SESSION['email_create'] = $email;

            if (isset($dataGetByEmailPass->id)) {
                $_SESSION['admin'] = array(
                    "id" => $dataGetByEmailPass->id,
                    "email" => $dataGetByEmailPass->email,
                    "role" => $dataGetByEmailPass->role
                );

                unset($_SESSION['email_create']);
                $this->redirect('management/index');

            } elseif (empty($_POST['email']) || empty($_POST['password'])) {
                $_SESSION['errLogin']['err'] = ERROR_LOGIN_EMAIL;
                $this->redirect('management/login');

            } elseif (!isset($dataGetByEmailPass->id)) {
                $_SESSION['errLogin']['err'] = ERROR_LOGIN_PASS;
                $this->redirect('management/login');
            }
        } else {
            if (isset($_SESSION['admin'])) {
                $this->redirect('management/index');
            }
            $this->render("admin/login");
        }
    }

    public function logout()
    {
        unset($_SESSION["admin"]);
        $this->redirect('management/login');
    }
}
