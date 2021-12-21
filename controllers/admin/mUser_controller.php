<?php

require_once('controllers/base_controller.php');
require_once('models/admin/UserModel.php');

class mUserController extends BaseController
{
    use UserModel;

    public function __construct()
    {
        $this->authenticationAdmin();
    }

    public function index()
    {
        $dataUser = $this->modelRead();
        $arr = array(
            'data' => $dataUser['data'],
            "column" => $dataUser['column'],
            "asc_or_desc" => $dataUser['asc_or_desc'],
            "sort_order" => $dataUser['sort_order'],
            "search" => $dataUser['search']
        );
        $this->render("admin/m_user/index", $arr);
    }

    public function create()
    {
        $action = "index.php?controller=mUser&action=createPost";
        $this->render("admin/m_user/create", ['action' => $action]);
    }

    public function createPost()
    {
        $this->createModel();
    }

    public function update()
    {
        try {
            $id = isset($_GET['id']) ? $_GET['id'] : "";
            $action = "index.php?controller=mUser&action=updatePost&id=$id";
            $data = $this->find($id);
            $this->render("admin/m_user/create", ['action' => $action, 'data' => $data]);
        }
        catch (Exception $e) {
            $this->render("layouts/error");
        }
    }

    public function updatePost()
    {
        try {
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            $this->updateModel($id);
        }
        catch (Exception $e) {
            $this->render("layouts/error");
        }
    }

    public function delete()
    {
        try {
            $id = isset($_GET['id']) ? $_GET['id'] : "";
            $this->deleteModel($id);
        }
        catch (Exception $e) {
            $this->render("layouts/error");
        }
    }
}