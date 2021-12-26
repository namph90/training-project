<?php

require_once('controllers/base_controller.php');
require_once('models/admin/AdminModel.php');
require_once('config/config.php');

class AdminController extends BaseController
{
    public $model;

    public function __construct()
    {
        $this->model = new AdminModel();
        $this->authenticationAdmin();
        $this->checkRole();
    }

    public function index()
    {
        $page = isset($_GET["page"]) && is_numeric($_GET["page"]) && $_GET["page"] > 0 ? $_GET["page"] - 1 : 0;
        $from = $page * RECORDPERPAGE;

        $searchName = isset($_GET["searchName"]) ? $_GET["searchName"] : "";
        $searchEmail = isset($_GET["searchEmail"]) ? $_GET["searchEmail"] : "";
        $sqlSearch = !empty($_GET["searchName"]) ? (!empty($_GET["searchEmail"]) ?
            "and email like '%$searchEmail%' and name like '%$searchName%'" : "and name like '%$searchName%'") :
            (!empty($_GET["searchEmail"]) ? "and email like '%$searchEmail%'" : " ");
        $name = isset($_GET['searchName']) ? "&searchName=" . $_GET['searchName'] : "";
        $email = isset($_GET['searchEmail']) ? "&searchEmail=" . $_GET['searchEmail'] : "";
        $search = $name . $email;

        $columns = array('id', 'name', 'email', 'role');
        $column = isset($_GET['column']) && in_array($_GET['column'], $columns, true) ? $_GET['column'] : $columns[0];
        $sort_order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'desc' : 'asc';
        $asc_or_desc = $sort_order == 'asc' ? 'desc' : 'asc';
        $sqlOrder = "order by $column $sort_order";

        $dataAdmin = $this->model->show($sqlSearch, $sqlOrder, $from, RECORDPERPAGE);
        $numPage = ceil($dataAdmin['count'] / RECORDPERPAGE);
        $arr = array(
            'data' => $dataAdmin['data'],
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
            $data = $this->model->getByEmail($_POST['email']);
            AdminValidated::validateCreate($_POST, $data, $_FILES["avatar"]);
            $_SESSION['dl'] = $_POST;

            if (!isset($_SESSION['errCreate'])) {
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
                UploadImages::createImage($_FILES["avatar"], $path, $newPath);
                $_SESSION['success'] = CREATE_SUCCESSFUL;
                unset($_SESSION['dl']);
                header("location:index.php?controller=admin&action=index");
            } else {
                header("location:index.php?controller=admin&action=create");
            }
        } else {
            $action = "index.php?controller=admin&action=create";
            $this->render("admin/m_admin/create", ['action' => $action]);
        }
    }

    public function edit()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $admin = $this->model->getById($id);
        if (isset($_POST['submit'])) {
            $password = $admin->password;
            $avatar = $admin->avatar;
            $_SESSION['dl'] = $_POST;

            AdminValidated::validateEdit($_POST, $_FILES["avatar"]);

            if (!isset($_SESSION['errCreate'])) {
                if ($_FILES["avatar"]["name"] != "") {
                    if ($admin) {
                        $oldPhoto = $admin->avatar;
                        $avatar = time() . "_" . $_FILES["avatar"]["name"];
                        $path = PATH_UPLOAD_ADMIN . $id;
                        $pathOldAvatar = $path . '/' . $oldPhoto;
                        $pathNewAvatar = $path . '/' . $avatar;
                        UploadImages::updateImage($_FILES["avatar"], $path, $pathOldAvatar, $pathNewAvatar);
                    }
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
                header("location:index.php?controller=admin&action=index");
                unset($_SESSION['dl']);
            } else {
                header("location:index.php?controller=admin&action=edit&id=$id");
            }

        } else {
            $action = "index.php?controller=admin&action=edit&id=$id";
            $this->render("admin/m_admin/create", ['action' => $action, 'data' => $admin]);
        }
    }


    public function delete()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $result = $this->model->getById($id);
        $path = PATH_UPLOAD_ADMIN . $id;

        if ($result) {
            UploadImages::deleteImage($path);
            $this->model->delete($id);
            if ($_SESSION['admin']['id'] == $id) {
                unset($_SESSION['admin']);
            } else {
                $_SESSION['success'] = DELETE_SUCCESSFUL;
            }
        }
        header("location:search");
    }
}