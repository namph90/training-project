<?php

require_once('controllers/base_controller.php');
require_once('models/AdminModel.php');

class AdminController extends BaseController
{
    use AdminModel;

    function __construct()
    {
        $this->authentication();
    }

    public function index()
    {
        $recordPerPage = 2;
        $numPage = ceil($this->modelTotal() / $recordPerPage);
        $data = $this->modelRead($recordPerPage);
        $this->render("admin/m_admin/index", ['data' => $data, "numPage" => $numPage]);
    }

    public function create()
    {
        $action = "index.php?controller=admin&action=createPost";
        $this->render("admin/m_admin/create", ['action' => $action]);
    }

    public function createPost()
    {
        $this->createModel();
    }

    public function update()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        $action = "index.php?controller=admin&action=updatePost&id=$id";
        $data = $this->find($id);
        $this->render("admin/m_admin/create", ['action' => $action, 'data' => $data]);
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