<?php
require_once('config/config.php');
require_once('models/upload/UploadImages.php');

trait UserModel
{
    use UploadImages;

    public function store()
    {
        $email = $_POST['email'];
        $conn = DB::getInstance();
        $data = $conn->query("select * from users where email = '$email'");

        //validate email
        UserValidated::email($data->rowCount(), $_POST['email']);
        //validated name
        UserValidated::name($_POST['name']);
        //validated password
        UserValidated::password($_POST['password']);
        // validated Password Verify
        UserValidated::password_confirm($_POST['password'], $_POST['password_confirm']);
        //validated image
        UserValidated::image($_FILES["avatar"]);
        $_SESSION['dl'] = $_POST;
        if (!isset($_SESSION['errCreate'])) {
            $name = $_POST['name'];
            $password = $_POST['password'];
            $status = $_POST['status'];
            $avatar = "";
            $password = md5($password);
            if ($_FILES["avatar"]["name"] != "") {
                $avatar = time() . "_" . $_FILES["avatar"]["name"];
            }
            $conn = DB::getInstance();
            $query = $conn->prepare("insert into users set name=:_name,email=:_email,password=:_password, status=:_status, avatar=:_avatar");
            $query->execute(["_name" => $name, "_email" => $email, "_password" => $password, "_status" => $status, "_avatar" => $avatar]);
            $id = $conn->lastInsertId();
            $path = PATH_UPLOAD_USER . $id;
            $newPath = $path . '/' . $avatar;
            $this->createImage($_FILES["avatar"], $path, $newPath);
            $_SESSION['success'] = "Create successful!";
            unset($_SESSION['dl']);
            header("location:index.php?controller=mUser&action=index");
        } else {
            header("location:index.php?controller=mUser&action=create");
        }
    }

    public function show()
    {
        $sqlOrder = " ";
        $searchName = isset($_GET["searchName"]) ? $_GET["searchName"] : "";
        $searchEmail = isset($_GET["searchEmail"]) ? $_GET["searchEmail"] : "";
        $sqlSearch = !empty($_GET["searchName"]) ? (!empty($_GET["searchEmail"]) ?
            "and email like '%$searchEmail%' and name like '%$searchName%'" : "and name like '%$searchName%'") :
            (!empty($_GET["searchEmail"]) ? "and email like '%$searchEmail%'" : " ");
        $name = isset($_GET['searchName']) ? "&searchName=" . $_GET['searchName'] : "";
        $email = isset($_GET['searchEmail']) ? "&searchEmail=" . $_GET['searchEmail'] : "";
        $search = $name . $email;

        $columns = array('id', 'name', 'email', 'status');
        $column = isset($_GET['column']) && in_array($_GET['column'], $columns, true) ? $_GET['column'] : $columns[0];
        $sort_order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'desc' : 'asc';
        $asc_or_desc = $sort_order == 'asc' ? 'desc' : 'asc';
        $sqlOrder = "order by $column $sort_order";

        $conn = DB::getInstance();
        $query = $conn->query("select * from users where del_flag = 0 $sqlSearch $sqlOrder");
        $data = $query->fetchAll();
        return array(
            'data' => $data,
            'column'=>$column,
            'asc_or_desc' => $asc_or_desc,
            'sort_order' => $sort_order,
            'search' => $search
        );
    }

    public function find($id)
    {
        $conn = DB::getInstance();
        $query = $conn->query("select * from users where  id = $id");
        $data = $query->fetch();
        return $data;
    }

    public function update($id)
    {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $status = $_POST['status'];
        $avatar = "";

        $_SESSION['dl'] = $_POST;

        UserValidated::name($name);
        if (!empty($password)) {
            UserValidated::password($password);
            UserValidated::password_confirm($password, $password_confirm);
        }
        if (!empty($_FILES["avatar"]["name"])) {
            UserValidated::image($_FILES["avatar"]);
        }

        if (!isset($_SESSION['errCreate'])) {
            $password = md5($password);
            $conn = DB::getInstance();
            $query = $conn->prepare("update users set name=:_name, status=:_status where id=:_id");
            $query->execute([":_name" => $name, ":_status" => $status, ":_id" => $id]);

            if ($_FILES["avatar"]["name"] != "") {
                $oldQuery = $conn->query("select avatar from users where id=$id");
                if ($oldQuery->rowCount() > 0) {
                    $oldPhoto = $oldQuery->fetch()->avatar;
                    $avatar = time() . "_" . $_FILES["avatar"]["name"];
                    $path = PATH_UPLOAD_USER . $id;
                    $pathOldAvatar = $path . '/' . $oldPhoto;
                    $pathNewAvatar = $path . '/' . $avatar;
                    $this->updateImage($_FILES["avatar"], $path, $pathOldAvatar, $pathNewAvatar);
                    $query = $conn->prepare("update users set avatar = :_avatar where id=:_id");
                    $query->execute([":_avatar" => $avatar, ":_id" => $id]);
                }
            }
            if (!empty($password)) {
                $query = $conn->prepare("update users set password=:_password where id=:_id");
                $query->execute([":_password" => $password, ":_id" => $id]);
            }

            $_SESSION['success'] = "Update Successful!";
            header("location:index.php?controller=mUser&action=index");
            //unset($_SESSION['errCreate']);
            unset($_SESSION['dl']);
        } else {
            header("location:index.php?controller=mUser&action=edit&id=$id");
        }
    }

    public function destroy($id)
    {
        $conn = DB::getInstance();
        $query = $conn->prepare("select * from users where id =:_id");
        $query->execute([":_id" => $id]);
        $path = PATH_UPLOAD_USER . $id;
        if ($query->rowCount() > 0) {
            $this->deleteImage($path);
            $conn->query("update users set del_flag = 1 where id=$id");
            $_SESSION['success'] = "Delete Successful!";
        }
        header("location:index.php?controller=mUser&action=index");
    }
}
