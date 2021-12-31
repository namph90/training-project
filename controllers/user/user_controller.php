<?php

require_once('controllers/base_controller.php');
require_once('models/admin/UserModel.php');
require_once('assets/Facebook/autoload.php');
require_once('function/Common.php');

class UserController extends BaseController
{
    public $model;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->authenticationUser();
    }

    public function details()
    {
        $id = $_SESSION['user']['id'];
        $data = $this->model->getById($id);
        $this->render("user/detail", ['data' => $data]);
    }

}
