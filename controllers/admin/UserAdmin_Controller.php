<?php

require_once('controllers/Base_Controller.php');
require_once('models/UserModel.php');
require_once('function/Validated/UserValidated.php');

class UserAdminController extends BaseController
{
    public $model;
    public $validated;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->validated = new UserValidated();
        $this->authenticationAdmin();
    }

    public function index()
    {
        $result = search();

        $columns = array('id', 'name', 'email', 'status');
        $order = order($columns);

        $data = $this->model->list($result['sqlSearch'], $order['sqlOrder']);
        $arr = array(
            'data' => $data,
            'column' => $order['column'],
            'asc_or_desc' => $order['asc_or_desc'],
            'sort_order' => $order['sort_order'],
            'search' => $result['search']
        );
        $this->render("admin/m_user/index", $arr);
    }

    public function create()
    {
        if (isset($_POST['submit'])) {
            $fields = "id";
            $data = $this->model->getByEmail($_POST['email'],$fields);
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
                    "status" => $_POST['status'],
                    "avatar" => $avatar
                );
                $conn = $this->model->create($arrInsert);

                $id = $conn->lastInsertId();
                $path = PATH_UPLOAD_USER . $id;
                $newPath = $path . '/' . $avatar;
                createImage($_FILES["avatar"], $path, $newPath);

                $_SESSION['success'] = CREATE_SUCCESSFUL;
                unset($_SESSION['dl']);
                header("location:search");
            } else {
                header("location:create");
            }
        } else {
            $action = "management/user/create";
            $this->render("admin/m_user/create", ['action' => $action]);
        }
    }

    public function edit()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $fields = "*";
        $admin = $this->model->getById($id, $fields);
        if (isset($_POST['submit'])) {
            $password = $admin->password;
            $avatar = $admin->avatar;
            $_SESSION['dl'] = $_POST;

            $this->validated->validateEdit($_POST, $_FILES["avatar"]);

            if (!isset($_SESSION['errCreate'])) {
                if (($_FILES["avatar"]["name"] != "") && $admin) {
                    $oldPhoto = $admin->avatar;
                    $avatar = time() . "_" . $_FILES["avatar"]["name"];
                    $path = PATH_UPLOAD_USER . $id;
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
                    "status" => $_POST['status'],
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
            $action = "management/user/edit/$id";
            $this->render("admin/m_user/create", ['action' => $action, 'data' => $admin]);
        }
    }

    public function delete()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $fields = "id";
        $result = $this->model->getById($id, $fields);
        $path = PATH_UPLOAD_USER . $id;

        if ($result) {
            deleteImage($path);
            $this->model->delete($id);
            $_SESSION['success'] = DELETE_SUCCESSFUL;
        }
        header("location:../search");
    }
}
