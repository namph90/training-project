<?php

trait AdminModel
{
    public function loginModel()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = md5($password);
        $conn = DB::getInstance();
        $_SESSION['email_create'] = $_POST['email'];
        $query = $conn->prepare("select email,id from admin where email=:_email and password=:_password");
        $query->execute(array("_email" => $email, "_password" => $password));
        $countEmail = $conn->query("select * from admin where email= '$email'");
        $countPass = $conn->query("select * from admin where email= '$email' and password = '$password'");
        if ($query->rowCount() > 0) {
            $data = $query->fetch();
            $_SESSION['admin'] = array(
                "id" => $data->id,
                "email" => $data->email
            );
            $_SESSION["LoginSuccess"] = "<script type='text/javascript'>alert('đăng nhập thành công');</script>";
            header("location:index.php");
        } elseif ($countEmail->rowCount() == 0) {
            $_SESSION['errorsEmail'] = "The email or password entered is not associated with any accounts. Find your account and log in.";
            header("location:index.php?controller=login&action=login");
        } elseif ($countPass->rowCount() == 0) {
            $_SESSION['errorsPass'] = "The password entered is incorrect. Forgot password?";
            header("location:index.php?controller=login&action=login");
        }

    }

    public function createModel()
    {
        $email = $_POST['email'];
        $conn = DB::getInstance();
        $data = $conn->query("select * from admin where email = '$email'");

        //validate email
        Validated::email($data->rowCount(), $_POST['email']);
        //validated name
        Validated::name($_POST['name']);
        //validated password
        Validated::password($_POST['password']);
        // validated Password Verify
        Validated::password_confirm($_POST['password'], $_POST['password_confirm']);
        //validated image
        Validated::image($_FILES["avatar"]);
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
            if ($_FILES["avatar"]["name"] != "") {
                if (!file_exists("assets/upload/admin/$id")) {
                    mkdir("assets/upload/admin/$id", 0755, true);
                }
                move_uploaded_file($_FILES["avatar"]["tmp_name"], "assets/upload/admin/$id/$avatar");
            }
            $_SESSION['success'] = "Create successfull!";
            header("location:index.php?controller=admin&action=index");
        } else {
            header("location:index.php?controller=admin&action=create");
        }
    }

    public function modelRead($recordPerPage)
    {
        $page = isset($_GET["page"]) && is_numeric($_GET["page"]) && $_GET["page"] > 0 ? $_GET["page"] - 1 : 0;
        $from = $page * $recordPerPage;
        $sqlOrder = " ";
        $sqlSearch = " ";
        if (!empty($_POST['searchName']) && empty($_POST['searchEmail'])) {
            $searchName = $_POST['searchName'];
            $sqlSearch = "where name like '%$searchName%'";
        }
        if (!empty($_POST['searchEmail']) && empty($_POST['searchName'])) {
            $searchEmail = $_POST['searchEmail'];
            $sqlSearch = "where email like '%$searchEmail%'";
        }
        if (!empty($_POST['searchEmail']) && !empty($_POST['searchName'])) {
            $searchEmail = $_POST['searchEmail'];
            $searchName = $_POST['searchName'];
            $sqlSearch = "where email like '%$searchEmail%' and name like '%$searchName%'";
        }
        $order = isset($_GET["order"]) ? $_GET["order"] : "";
        switch ($order) {
            case "nameAsc":
                $sqlOrder = " order by name asc ";
                break;
            case "emailAsc":
                $sqlOrder = " order by email asc ";
                break;
            case "roleAsc":
                $sqlOrder = " order by role asc ";
                break;
            case "idAsc":
                $sqlOrder = " order by id asc ";
                break;
        }
        $conn = DB::getInstance();
        $query = $conn->query("select * from admin $sqlSearch $sqlOrder limit $from,$recordPerPage");
        $data = $query->fetchAll();
        return $data;
    }

    public function find($id)
    {
        $conn = DB::getInstance();
        $query = $conn->query("select * from admin where  id = $id");
        $data = $query->fetch();
        return $data;
    }

    public function updateModel($id)
    {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $avatar = "";
        $password = md5($password);
        $conn = DB::getInstance();
        $query = $conn->prepare("update admin set name=:_name, role=:_role where id=:_id");
        $query->execute([":_name" => $name, ":_role" => $role, ":_id" => $id]);
        if ($_FILES["avatar"]["name"] != "") {
            $oldQuery = $conn->query("select avatar from admin where id=$id");
            if ($oldQuery->rowCount() > 0)
                $oldPhoto = $oldQuery->fetch();
            if (file_exists("assets/upload/admin/" . $id . "/" . $oldPhoto->avatar))
                unlink("assets/upload/admin/" . $id . "/" . $oldPhoto->avatar);
            if (!file_exists("assets/upload/admin/$id")) {
                mkdir("assets/upload/admin/$id", 0755, true);
            }
            $avatar = time() . "_" . $_FILES["avatar"]["name"];
            move_uploaded_file($_FILES["avatar"]["tmp_name"], "assets/upload/admin/$id/$avatar");
            $query = $conn->prepare("update admin set avatar = :_avatar where id=:_id");
            $query->execute([":_avatar" => $avatar, ":_id" => $id]);
        }
        if ($password != "") {
            $query = $conn->prepare("update admin set password=:_password where id=:_id");
            $query->execute([":_password" => $password, ":_id" => $id]);
        }
        $_SESSION['success'] = "Update Successfull!";
        header("location:index.php?controller=admin&action=index");
    }

    public function deleteModel($id)
    {
        $conn = DB::getInstance();
        $query = $conn->prepare("select * from admin where id =:_id");
        $query->execute([":_id" => $id]);
        $target = "assets/upload/$id";
        if ($query->rowCount() > 0) {
            $oldPhoto = $query->fetch();
            if (is_dir("assets/upload/admin/$id")) {
                if (file_exists("assets/upload/admin/" . $id . "/" . $oldPhoto->avatar)) {
                    unlink("assets/upload/admin/" . $id . "/" . $oldPhoto->avatar);
                }
                rmdir($target);
            }
            $conn->query("delete from admin where id=$id");
            if ($_SESSION['admin']['id'] == $id) {
                unset($_SESSION['admin']);
            } else {
                $_SESSION['success'] = "Delete Successfull!";
            }
        }
        header("location:index.php?controller=admin&action=index");
    }

    public function modelTotal()
    {
        $conn = DB::getInstance();
        $query = $conn->query("select id from admin");
        return $query->rowCount();
    }
}
