<?php

require_once('controllers/base_controller.php');
require_once('models/AdminModel.php');

class AdminController extends BaseController
{
    use AdminModel;
    public function index()
    {
        $data = $this->getAll();
        $this->render("admin/index", ['data'=>$data]);
    }
    public function login()
    {
        $this->render("admin/login");
    }

    public function loginPost()
    {

        $this->loginModel();
    }

    public function logout()
    {
        unset($_SESSION["admin"]);
        header("location:index.php");
    }

    public function create()
    {
        $action = "index.php?controller=admin&action=createPost";
        $this->render("admin/create", ['action'=>$action]);
    }

    public function createPost()
    {
        $this->createModel();
    }
    public function update()
    {
        $id = isset($_GET['id'])?$_GET['id']:"";
        $action = "index.php?controller=admin&action=updatePost&id=$id";
        $data = $this->find($id);
        $this->render("admin/create",['action'=>$action, 'data'=>$data]);
    }
    public function updatePost()
    {
        $id = isset($_GET['id'])?$_GET['id']:0;
        $this->updateModel($id);
    }
}