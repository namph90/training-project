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
            header("location:index.php?controller=admin&action=login");
        } elseif ($countPass->rowCount() == 0) {
            $_SESSION['errorsPass'] = "The password entered is incorrect. Forgot password?";
            header("location:index.php?controller=admin&action=login");
        }

    }

    public function createModel()
    {
        $email = $_POST['email'];
        $conn = DB::getInstance();
        $data = $conn->query("select * from admin where email = '$email'");

        //validate email
        if (empty(trim($_POST['email']))) {
            $_SESSION['errCreate']['email']['required'] = 'Email can not be blank';
        } else {
            if (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
                $_SESSION['errCreate']['email']['invaild'] = 'Invalid email format';
            } elseif ($data->rowCount() > 0) {
                $_SESSION['errCreate']['email']['exist'] = 'Email exist';
            }
        }
        //validated name
        if (empty(trim($_POST['name']))) {
            $_SESSION['errCreate']['name']['required'] = 'Name can not be blank';
        } else {
            if (strlen(trim($_POST['name'])) < 6 || strlen(trim($_POST['name'])) > 200) {
                $_SESSION['errCreate']['name']['invaild'] = 'Name must be between 6 and 200 characters';
            }
        }
        //validated password
        if (empty(trim($_POST['password']))) {
            $_SESSION['errCreate']['password']['required'] = 'Password can not be blank';
        } else {
            if (strlen(trim($_POST['password'])) < 3 || strlen(trim($_POST['password'])) > 100) {
                $_SESSION['errCreate']['password']['invaild'] = 'Password must be between 3 and 100 characters';
            }
        }
        // validated Password Verify
        if (!isset($_SESSION['errCreate']['password'])) {
            if (empty(trim($_POST['password_confirm']))) {
                $_SESSION['errCreate']['confirmation_pwd']['required'] = 'Password Verify can not be blank';
            } else {
                if (strlen(trim($_POST['password_confirm'])) != strlen(trim($_POST['password']))) {
                    $_SESSION['errCreate']['confirmation_pwd']['invaild'] = 'Password verify does not match';
                }
            }
        }
        $_SESSION['dl']['name'] = $_POST['name'];
        $_SESSION['dl']['email'] = $_POST['email'];
        $_SESSION['dl']['password'] = $_POST['password'];
        $_SESSION['dl']['password_confirm'] = $_POST['password_confirm'];

        if (!isset($_SESSION['errCreate'])) {
            $name = $_POST['name'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $avatar = "";
            $password = md5($password);
            if ($_FILES["avatar"]["name"] != "") {
                $avatar = time() . "_" . $_FILES["avatar"]["name"];
                move_uploaded_file($_FILES["avatar"]["tmp_name"], "./assets/upload/$avatar");
            }
            $conn = DB::getInstance();
            $query = $conn->prepare("insert into admin set name=:_name,email=:_email,password=:_password, role=:_role, avatar=:_avatar");
            $query->execute(["_name" => $name, "_email" => $email, "_password" => $password, "_role" => $role, "_avatar" => $avatar]);
            header("location:index.php");
        } else {
            header("location:index.php?controller=admin&action=create");
        }
    }
    public function getAll()
    {
        $conn = DB::getInstance();
        $query = $conn->query("select * from admin order by id asc");
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
        $query->execute([":_name"=>$name,":_role"=>$role,":_id"=>$id]);
        if($_FILES["avatar"]["name"] != ""){
            $oldQuery = $conn->query("select avatar from admin where id=$id");
            if($oldQuery->rowCount() > 0)
                $oldPhoto = $oldQuery->fetch();
            if(file_exists("assets/upload/".$oldPhoto->avatar))
                unlink("assets/upload/".$oldPhoto->avatar);
            $avatar = time()."_".$_FILES["avatar"]["name"];
            move_uploaded_file($_FILES["avatar"]["tmp_name"],"assets/upload/$avatar");
            //update csdl
            $query = $conn->prepare("update admin set avatar = :_avatar where id=:_id");
            $query->execute([":_avatar"=>$avatar,":_id"=>$id]);
        }
        if ($password != "") {
            $query = $conn->prepare("update admin set password=:_password where id=:_id");
            $query->execute([":_password" => $password, ":_id" => $id]);
        }
        header("location:index.php");
    }
}
