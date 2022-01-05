<?php

require_once('controllers/BaseController.php');
require_once('models/UserModel.php');

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
        $fields = ['id', 'name', 'avatar', 'email'];
        $data = $this->model->getById($id, $fields);
        $this->render("user/detail", ['data' => $data]);
    }
}
