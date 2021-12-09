<?php

require_once('controllers/base_controller.php');
require_once('models/UserModel.php');

class UserController extends BaseController
{
    use UserModel;

    function __construct()
    {
        $this->authentication();
    }

    public function index()
    {
        $data = $this->modelRead();
        $this->render("admin/m_user/index", ['data' => $data]);
    }

    public function create()
    {
        $action = "index.php?controller=user&action=createPost";
        $this->render("admin/m_user/create", ['action' => $action]);
    }

    public function createPost()
    {
        $this->createModel();
    }

    public function update()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        $action = "index.php?controller=user&action=updatePost&id=$id";
        $data = $this->find($id);
        $this->render("admin/m_user/create", ['action' => $action, 'data' => $data]);
    }

    public function updatePost()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $this->updateModel($id);
    }

    public function delete()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        $this->deleteModel($id);
    }
}