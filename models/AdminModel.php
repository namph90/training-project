<?php


trait AdminModel
{
    public function loginModel()
    {
        //validate email
        if (empty(trim($_POST['email']))) {
            $_SESSION['errorsEmail']['required'] = 'Email can not be blank';
        } else {
            if (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
                $_SESSION['errorsEmail']['invaild'] = 'Invalid email format';
            }
        }

        //validate password
        if (empty(trim($_POST['password']))) {
            $_SESSION['errorsPass']['required'] = 'Password can not be blank';
        } else {
            if (strlen(trim($_POST['password'])) < 6 || strlen(trim($_POST['password'])) > 100) {
                $_SESSION['errorsPass']['invaild'] = 'Password must be between 6 and 100 characters';
            }
        }
        if (!isset($_SESSION['errorsEmail'])&&!isset($_SESSION['errorsPass'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password = md5($password);
            $conn = Connection::getInstance();
            $query = $conn->prepare("select email,id from admin where email=:_email and password=:_password");
            $query->execute(array("_email" => $email, "_password" => $password));
            if ($query->rowCount() > 0) {
                $data = $query->fetch();
                $_SESSION['admin'] = array(
                    "id"=> $data->id,
                    "email"=>$data->email
                );
                $_SESSION["LoginSuccess"] = "<script type='text/javascript'>alert('đăng nhập thành công');</script>";
                header("location:index.php");
            }
        } else {
            header("location:index.php?controller=Admin&action=login");
        }
    }
}
