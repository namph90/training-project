<?php

require_once('controllers/BaseController.php');
require_once('models/AdminModel.php');
require_once('function/Validated/AdminValidated.php');

class AdminController extends BaseController
{
    public $model;
    public $validated;

    public function __construct()
    {
        $this->model = new AdminModel();
        $this->validated = new AdminValidated();
        $this->authenticationAdmin();
        $this->checkRole();
    }

    public function index()
    {
        $page = isset($_GET["page"]) && is_numeric($_GET["page"]) && $_GET["page"] > 0 ? $_GET["page"] - 1 : 0;
        $from = $page * RECORDPERPAGE;

        $name = isset($_GET['searchName']) ? "?searchName=" . $_GET['searchName'] : "?";
        $email = isset($_GET['searchEmail']) ? "&searchEmail=" . $_GET['searchEmail']."&" : "";
        $searchName = isset($_GET["searchName"]) ? $_GET["searchName"] : "";
        $searchEmail = isset($_GET["searchEmail"]) ? $_GET["searchEmail"] : "";
        $search = $name . $email;

        $columns = array('id', 'name', 'email', 'role');
        $column = isset($_GET['column']) && in_array($_GET['column'], $columns, true) ? $_GET['column'] : $columns[0];
        $sort_order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'desc' : 'asc';
        $asc_or_desc = $sort_order == 'asc' ? 'desc' : 'asc';

        $conditions = ['searchName' => $searchName, 'searchEmail'=> $searchEmail];
        $orerBy = ['column'=>$column, 'sort_order'=>$sort_order];

        $dataAdmin = $this->model->list($conditions, $orerBy, $from, RECORDPERPAGE);
        $numPage = ceil($dataAdmin['count'] / RECORDPERPAGE);

        $arr = array(
            "data" => $dataAdmin['data'],
            "numPage" => $numPage,
            "column" => $column,
            "asc_or_desc" => $asc_or_desc,
            "sort_order" => $sort_order,
            "search" => $search
        );
        $this->render("admin/m_admin/index", $arr);
    }

    public function create()
    {
        if (isset($_POST['submit'])) {
            $fields = ['id'];
            $data = $this->model->getByEmail($_POST['email'], $fields);
            $check = $this->validated->validateCreate($_POST, $data, $_FILES["avatar"]);
            $_SESSION['dl'] = $_POST;

            if ($check == true) {
                $avatar = "";
                $password = md5($_POST['password']);
                if ($_FILES["avatar"]["name"] != "") {
                    $avatar = time() . "_" . $_FILES["avatar"]["name"];
                }
                $arrInsert = array(
                    "name" => $_POST['name'],
                    "email" => $_POST['email'],
                    "password" => $password,
                    "role" => $_POST['role'],
                    "avatar" => $avatar
                );
                $conn = $this->model->create($arrInsert);
                $id = $conn->lastInsertId();

                $path = PATH_UPLOAD_ADMIN . $id;
                $newPath = $path . '/' . $avatar;
                createImage($_FILES["avatar"], $path, $newPath);

                $_SESSION['success'] = CREATE_SUCCESSFUL;
                unset($_SESSION['dl']);
                $this->redirect('management/admin/search');
            } else {
                $this->redirect('management/admin/create');
            }
        } else {
            $action = "management/admin/create";
            $this->render("admin/m_admin/create", ['action' => $action]);
        }
    }

    public function edit()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $fields = ['id', 'name', 'email', 'role', 'avatar', 'password'];
        $admin = $this->model->getById($id, $fields);
        if (isset($_POST['submit'])) {
            $password = $admin->password;
            $avatar = $admin->avatar;
            $_SESSION['dl'] = $_POST;

            $check = $this->validated->validateEdit($_POST, $_FILES["avatar"]);

            if ($check == true) {
                if (($_FILES["avatar"]["name"] != "") && $admin) {
                    $oldPhoto = $admin->avatar;
                    $avatar = time() . "_" . $_FILES["avatar"]["name"];
                    $path = PATH_UPLOAD_ADMIN . $id;
                    $pathOldAvatar = $path . '/' . $oldPhoto;
                    $pathNewAvatar = $path . '/' . $avatar;
                    updateImage($_FILES["avatar"], $path, $pathOldAvatar, $pathNewAvatar);
                }

                if (!empty($_POST['password'])) {
                    $password = md5($_POST['password']);
                }

                $arrUpdate = array(
                    "name" => $_POST['name'],
                    "password" => $password,
                    "role" => $_POST['role'],
                    "avatar" => $avatar
                );
                $this->model->update($arrUpdate, $id);

                $_SESSION['success'] = UPDATE_SUCCESSFUL;
                $this->redirect('management/admin/search');
                unset($_SESSION['dl']);
            } else {
                $this->redirect("management/admin/edit/$id");
            }
        } else {
            $action = "management/admin/edit/$id";
            $this->render("admin/m_admin/create", ['action' => $action, 'data' => $admin]);
        }
    }

    public function delete()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $fields = ['id'];
        $result = $this->model->getById($id, $fields);
        $path = PATH_UPLOAD_ADMIN . $id;

        if ($result) {
            deleteImage($path);
            $this->model->delete($id);
            if ($_SESSION['admin']['id'] == $id) {
                unset($_SESSION['admin']);
            } else {
                $_SESSION['success'] = DELETE_SUCCESSFUL;
            }
        }
        $this->redirect('management/admin/search');
    }
}
