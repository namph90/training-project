<?php
require_once('config/config.php');
require_once('models/upload/UploadImages.php');

trait AdminModel
{
    use UploadImages;

    public function loginModel()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = md5($password);
        $conn = DB::getInstance();
        $_SESSION['email_create'] = $email;
        $query = $conn->prepare("select email,id,role from admin where email=:_email and password=:_password");
        $query->execute(array("_email" => $email, "_password" => $password));
        $countEmail = $conn->query("select * from admin where email= '$email'");
        $countPass = $conn->query("select * from admin where email= '$email' and password = '$password'");
        if ($query->rowCount() > 0) {
            $data = $query->fetch();
            $_SESSION['admin'] = array(
                "id" => $data->id,
                "email" => $data->email,
                "role" => $data->role
            );
            $_SESSION["LoginSuccess"] = "<script type='text/javascript'>alert('đăng nhập thành công');</script>";
            unset($_SESSION['email_create']);
            header("location:index.php?controller=home&action=index");
        } elseif ($countEmail->rowCount() == 0) {
            $_SESSION['errorsEmail'] = "The email or password entered is not associated with any accounts. Find your account and log in.";
            header("location:index.php?controller=login&action=login");
        } elseif ($countPass->rowCount() == 0) {
            $_SESSION['errorsPass'] = "The password entered is incorrect. Forgot password?";
            header("location:index.php?controller=login&action=login");
        }

    }

    public function store()
    {
        $email = $_POST['email'];
        $conn = DB::getInstance();
        $data = $conn->query("select * from admin where email = '$email'");
        AdminValidated::email($data->rowCount(), $_POST['email']);
        AdminValidated::name($_POST['name']);
        AdminValidated::password($_POST['password']);
        AdminValidated::password_confirm($_POST['password'], $_POST['password_confirm']);
        AdminValidated::image($_FILES["avatar"]);
//        $imageData = file_get_contents($_FILES['avatar']['tmp_name']);
//        $test = base64_encode($imageData);
//        $_SESSION['src'] ="data:image/png;base64,$test";
        $_SESSION['dl'] = $_POST;
        if (!isset($_SESSION['errCreate'])) {
            $name = $_POST['name'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $avatar = "";
            $password = md5($password);
            if ($_FILES["avatar"]["name"] != "") {
                $avatar = time() . "_" . $_FILES["avatar"]["name"];
            }
            $conn = DB::getInstance();
            $query = $conn->prepare("insert into admin set name=:_name,email=:_email,password=:_password, role=:_role, avatar=:_avatar");
            $query->execute(["_name" => $name, "_email" => $email, "_password" => $password, "_role" => $role, "_avatar" => $avatar]);
            $id = $conn->lastInsertId();
            $path = PATH_UPLOAD_ADMIN . $id;
            $newPath = $path . '/' . $avatar;
            $this->createImage($_FILES["avatar"], $path, $newPath);
            $_SESSION['success'] = "Create successfull!";
            //unset($_SESSION['src']);
            unset($_SESSION['dl']);
            header("location:index.php?controller=admin&action=index");
        } else {
            header("location:index.php?controller=admin&action=create");
        }
    }

    public function show($recordPerPage)
    {
        $page = isset($_GET["page"]) && is_numeric($_GET["page"]) && $_GET["page"] > 0 ? $_GET["page"] - 1 : 0;
        $from = $page * $recordPerPage;

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

        $conn = DB::getInstance();
        $query = $conn->query("select * from admin where del_flag = 0 $sqlSearch $sqlOrder limit  $from,$recordPerPage");
        $count = $conn->query("select * from admin where del_flag = 0 $sqlSearch $sqlOrder")->rowCount();
        $data = $query->fetchAll();
        return array(
            'data' => $data,
            'count' => $count,
            'column' => $column,
            'asc_or_desc' => $asc_or_desc,
            'sort_order' => $sort_order,
            'search' => $search
        );
    }

    public function find($id)
    {
        $conn = DB::getInstance();
        $query = $conn->query("select * from admin where  id = $id");
        $data = $query->fetch();
        return $data;
    }

    public function update($id)
    {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $role = $_POST['role'];
        $avatar = "";
        $_SESSION['dl'] = $_POST;

        AdminValidated::name($name);
        if (!empty($password)) {
            AdminValidated::password($password);
            AdminValidated::password_confirm($password, $password_confirm);
        }
        if (!empty($_FILES["avatar"]["name"])) {
            AdminValidated::image($_FILES["avatar"]);
        }
        if (!isset($_SESSION['errCreate'])) {
            $password = md5($password);
            $conn = DB::getInstance();
            $query = $conn->prepare("update admin set name=:_name, role=:_role where id=:_id");
            $query->execute([":_name" => $name, ":_role" => $role, ":_id" => $id]);

            if ($_FILES["avatar"]["name"] != "") {
                $oldQuery = $conn->query("select avatar from admin where id=$id");
                if ($oldQuery->rowCount() > 0) {
                    $oldPhoto = $oldQuery->fetch()->avatar;
                    $avatar = time() . "_" . $_FILES["avatar"]["name"];
                    $path = PATH_UPLOAD_ADMIN . $id;
                    $pathOldAvatar = $path . '/' . $oldPhoto;
                    $pathNewAvatar = $path . '/' . $avatar;
                    $this->updateImage($_FILES["avatar"], $path, $pathOldAvatar, $pathNewAvatar);
                    $query = $conn->prepare("update admin set avatar = :_avatar where id=:_id");
                    $query->execute([":_avatar" => $avatar, ":_id" => $id]);
                }
            }
            if ($password != "") {
                $query = $conn->prepare("update admin set password=:_password where id=:_id");
                $query->execute([":_password" => $password, ":_id" => $id]);
            }

            $_SESSION['success'] = "Update Successful!";
            header("location:index.php?controller=admin&action=index");
            //unset($_SESSION['errCreate']);
            unset($_SESSION['dl']);
        } else {
            header("location:index.php?controller=admin&action=edit&id=$id");
        }
    }

    public function destroy($id)
    {
        $conn = DB::getInstance();
        $query = $conn->prepare("select * from admin where id =:_id");
        $query->execute([":_id" => $id]);
        $path = PATH_UPLOAD_ADMIN . $id;
        if ($query->rowCount() > 0) {
            $this->deleteImage($path);
            $conn->query("update admin set del_flag = 1 where id=$id");
            if ($_SESSION['admin']['id'] == $id) {
                unset($_SESSION['admin']);
            } else {
                $_SESSION['success'] = "Delete Successfull!";
            }
        }
        header("location:index.php?controller=admin&action=index");
    }
}
