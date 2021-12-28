<?php

require_once('controllers/base_controller.php');
require_once('models/admin/UserModel.php');
require_once('controllers/Validated/UserValidated.php');
require_once('controllers/function/Paginate.php');
require_once('controllers/function/UploadImages.php');

class mUserController extends BaseController
{
    public $model;
    public $validated;
    public $uploadImg;
    public $paginate;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->validated = new UserValidated();
        $this->uploadImg = new UploadImages();
        $this->paginate = new Paginate();
        $this->authenticationAdmin();
    }

    public function index()
    {
        $result = $this->paginate->search();

        $columns = array('id', 'name', 'email', 'status');
        $order = $this->paginate->order($columns);

        $data = $this->model->show($result['sqlSearch'], $order['sqlOrder']);
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
                    "status" => $_POST['status'],
                    "avatar" => $avatar
                );
                $conn = $this->model->create($arrInsert);
                $id = $conn->lastInsertId();
                $path = PATH_UPLOAD_USER . $id;
                $newPath = $path . '/' . $avatar;
                $this->uploadImg->createImage($_FILES["avatar"], $path, $newPath);
                $_SESSION['success'] = CREATE_SUCCESSFUL;
                unset($_SESSION['dl']);
                header("location:index.php?controller=mUser&action=index");
            } else {
                header("location:index.php?controller=mUser&action=create");
            }
        } else {
            $action = "index.php?controller=mUser&action=create";
            $this->render("admin/m_user/create", ['action' => $action]);
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
                        $path = PATH_UPLOAD_USER . $id;
                        $pathOldAvatar = $path . '/' . $oldPhoto;
                        $pathNewAvatar = $path . '/' . $avatar;
                        $this->uploadImg->updateImage($_FILES["avatar"], $path, $pathOldAvatar, $pathNewAvatar);
                    }
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
                header("location:index.php?controller=mUser&action=index");
                unset($_SESSION['dl']);
            } else {
                header("location:index.php?controller=mUser&action=edit&id=$id");
            }

        } else {
            $action = "index.php?controller=mUser&action=edit&id=$id";
            $this->render("admin/m_user/create", ['action' => $action, 'data' => $admin]);
        }
    }

    public function delete()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $result = $this->model->getById($id);
        $path = PATH_UPLOAD_USER . $id;

        if ($result) {
            $this->uploadImg->deleteImage($path);
            $this->model->delete($id);
            $_SESSION['success'] = DELETE_SUCCESSFUL;
        }
        header("location:index.php?controller=mUser&action=index");
    }
}