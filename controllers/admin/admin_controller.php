<?php

require_once('controllers/base_controller.php');
require_once('models/admin/AdminModel.php');
require_once('controllers/Validated/AdminValidated.php');
require_once('function/Paginate.php');
require_once('function/UploadImages.php');
require_once('function/Common.php');
require_once('views/elements/error.php');

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

        $result = search();
        $columns = array('id', 'name', 'email', 'role');
        $order = order($columns);
        $dataAdmin = $this->model->list($result['sqlSearch'], $order['sqlOrder'], $from, RECORDPERPAGE);
        $numPage = ceil($dataAdmin['count'] / RECORDPERPAGE);
        $arr = array(
            'data' => $dataAdmin['data'],
            "numPage" => $numPage,
            "column" => $order['column'],
            "asc_or_desc" => $order['asc_or_desc'],
            "sort_order" => $order['sort_order'],
            "search" => $result['search']
        );
        $this->render("admin/m_admin/index", $arr);
    }

    public function create()
    {
        if (isset($_POST['submit'])) {
            $data = $this->model->getByEmail($_POST['email']);
            $this->validated->validateCreate($_POST, $data, $_FILES["avatar"]);
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
                createImage($_FILES["avatar"], $path, $newPath);

                $_SESSION['success'] = CREATE_SUCCESSFUL;
                unset($_SESSION['dl']);
                header("location:search");
            } else {
                header("location:create");
            }
        } else {
            $action = "management/admin/create";
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

            $this->validated->validateEdit($_POST, $_FILES["avatar"]);

            if (!isset($_SESSION['errCreate'])) {
                if ($_FILES["avatar"]["name"] != "") {
                    if ($admin) {
                        $oldPhoto = $admin->avatar;
                        $avatar = time() . "_" . $_FILES["avatar"]["name"];
                        $path = PATH_UPLOAD_ADMIN . $id;
                        $pathOldAvatar = $path . '/' . $oldPhoto;
                        $pathNewAvatar = $path . '/' . $avatar;
                        updateImage($_FILES["avatar"], $path, $pathOldAvatar, $pathNewAvatar);
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
                header("location:../search");
                unset($_SESSION['dl']);
            } else {
                header("location:../edit/$id");
            }
        } else {
            $action = "management/admin/edit/$id";
            $this->render("admin/m_admin/create", ['action' => $action, 'data' => $admin]);
        }
    }


    public function delete()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $result = $this->model->getById($id);
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
        header("location:../search");
    }
}