<?php

require_once('controllers/base_controller.php');
require_once('models/admin/UserModel.php');

class mUserController extends BaseController
{
    public $model;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->authenticationAdmin();
    }

    public function index()
    {
        $sqlOrder = " ";
        $result = Paginate::search();

        $columns = array('id', 'name', 'email', 'status');
        $order = Paginate::order($columns);

        $data = $this->model->show($result['sqlSearch'], $order['sqlOrder']);
        $arr = array(
            'data' => $data,
            'column'=>$order['column'],
            'asc_or_desc' => $order['asc_or_desc'],
            'sort_order' => $order['sort_order'],
            'search' => $result['search']
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
        $this->model->store();
    }

    public function edit()
    {
        try {
            $id = isset($_GET['id']) ? $_GET['id'] : "";
            $action = "index.php?controller=mUser&action=updatePost&id=$id";
            $data = $this->model->find($id);
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
            $this->model->update($id);
        }
        catch (Exception $e) {
            $this->render("layouts/error");
        }
    }

    public function delete()
    {
        try {
            $id = isset($_GET['id']) ? $_GET['id'] : "";
            $this->model->destroy($id);
        }
        catch (Exception $e) {
            $this->render("layouts/error");
        }
    }
}