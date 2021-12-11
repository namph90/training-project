<?php

trait UserModel
{
    public function createModel()
    {
        $email = $_POST['email'];
        $conn = DB::getInstance();
        $data = $conn->query("select * from users where email = '$email'");

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
            if ($_FILES["avatar"]["name"] != "") {
                if (!file_exists("assets/upload/user/$id")) {
                    mkdir("assets/upload/user/$id", 0755, true);
                }
                move_uploaded_file($_FILES["avatar"]["tmp_name"], "assets/upload/user/$id/$avatar");
            }
            $_SESSION['success'] = "Create successfull!";
            header("location:index.php?controller=mUser&action=index");
        } else {
            header("location:index.php?controller=mUser&action=create");
        }
    }

    public function modelRead()
    {
        $sqlOrder = " ";
        $sqlSearch = " ";
        if (!empty($_GET["searchName"]) && empty($_GET["searchEmail"])) {
            $searchName = $_GET["searchName"];
            $sqlSearch = "where name like '%$searchName%'";
        }
        if (!empty($_GET["searchEmail"]) && empty($_GET["searchName"])) {
            $searchEmail = $_GET['searchEmail'];
            $sqlSearch = "where email like '%$searchEmail%'";
        }
        if (!empty($_GET["searchEmail"]) && !empty($_GET['searchName'])) {
            $searchEmail = $_GET['searchEmail'];
            $searchName = $_GET['searchName'];
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
            case "statusAsc":
                $sqlOrder = " order by status asc ";
                break;
            case "idAsc":
                $sqlOrder = " order by id asc ";
                break;
        }
        $conn = DB::getInstance();
        $query = $conn->query("select * from users $sqlSearch $sqlOrder");
        $data = $query->fetchAll();
        return $data;
    }

    public function find($id)
    {
        $conn = DB::getInstance();
        $query = $conn->query("select * from users where  id = $id");
        $data = $query->fetch();
        return $data;
    }

    public function updateModel($id)
    {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $status = $_POST['status'];
        $avatar = "";
        $password = md5($password);
        $conn = DB::getInstance();
        $query = $conn->prepare("update users set name=:_name, status=:_status where id=:_id");
        $query->execute([":_name" => $name, ":_status" => $status, ":_id" => $id]);
        if ($_FILES["avatar"]["name"] != "") {
            $oldQuery = $conn->query("select avatar from users where id=$id");
            if ($oldQuery->rowCount() > 0)
                $oldPhoto = $oldQuery->fetch();
            if (file_exists("assets/upload/user/" . $id . "/" . $oldPhoto->avatar))
                unlink("assets/upload/user/" . $id . "/" . $oldPhoto->avatar);
            $avatar = time() . "_" . $_FILES["avatar"]["name"];
            move_uploaded_file($_FILES["avatar"]["tmp_name"], "assets/upload/user/$id/$avatar");
            $query = $conn->prepare("update users set avatar = :_avatar where id=:_id");
            $query->execute([":_avatar" => $avatar, ":_id" => $id]);
        }
        if ($password != "") {
            $query = $conn->prepare("update users set password=:_password where id=:_id");
            $query->execute([":_password" => $password, ":_id" => $id]);
        }
        $_SESSION['success'] = "Update Successfull!";
        header("location:index.php?controller=mUser&action=index");
    }

    public function deleteModel($id)
    {
        $conn = DB::getInstance();
        $query = $conn->prepare("select * from users where id =:_id");
        $query->execute([":_id" => $id]);
        $target = "assets/upload/user/$id";
        if ($query->rowCount() > 0) {
            $oldPhoto = $query->fetch();
            if (is_dir("assets/upload/user/$id")) {
                if (file_exists("assets/upload/user/" . $id . "/" . $oldPhoto->avatar)) {
                    unlink("assets/upload/user/" . $id . "/" . $oldPhoto->avatar);
                }
                rmdir($target);
            }
            $conn->query("delete from users where id=$id");
            $_SESSION['success'] = "Delete Successfull!";
        }
        header("location:index.php?controller=mUser&action=index");
    }
}
