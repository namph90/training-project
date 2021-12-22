<?php

require_once('controllers/base_controller.php');
require_once('models/admin/AdminModel.php');
require_once('config/config.php');

class AdminController extends BaseController
{
    use AdminModel;

    public function __construct()
    {
        $this->authenticationAdmin();
        $this->checkRole();
    }

    public function index()
    {
        $dataAdmin = $this->show(RECORDPERPAGE);
        $numPage = ceil($dataAdmin['count'] / RECORDPERPAGE);
        $arr = array(
            'data' => $dataAdmin['data'],
            "numPage" => $numPage,
            "column" => $dataAdmin['column'],
            "asc_or_desc" => $dataAdmin['asc_or_desc'],
            "sort_order" => $dataAdmin['sort_order'],
            "search" => $dataAdmin['search']
        );
        $this->render("admin/m_admin/index", $arr);
    }

    public function create()
    {
        $action = "index.php?controller=admin&action=createPost";
        $this->render("admin/m_admin/create", ['action' => $action]);
    }

    public function createPost()
    {
        $this->store();
    }

    public function edit()
    {
            $id = isset($_GET['id']) ? $_GET['id'] : "";
            $action = "index.php?controller=admin&action=updatePost&id=$id";
            $data = $this->find($id);
            $this->render("admin/m_admin/create", ['action' => $action, 'data' => $data]);
    }

    public function updatePost()
    {
            $id = isset($_GET['id']) ? $_GET['id'] : "";
            $this->update($id);
    }

    public function delete()
    {
        try {
            $id = isset($_GET['id']) ? $_GET['id'] : "";
            $this->destroy($id);
        } catch (Exception $e) {
            $this->render("layouts/error");
        }
    }
}