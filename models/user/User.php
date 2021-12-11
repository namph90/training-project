<?php


trait User
{
    public function loginModel()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = md5($password);
        $conn = DB::getInstance();
        $_SESSION['email_create'] = $_POST['email'];
        $query = $conn->prepare("select email,id from users where email=:_email and password=:_password");
        $query->execute(array("_email" => $email, "_password" => $password));
        $countEmail = $conn->query("select * from users where email= '$email'");
        $countPass = $conn->query("select * from users where email= '$email' and password = '$password'");
        if ($query->rowCount() > 0) {
            $data = $query->fetch();
            $_SESSION['user'] = array(
                "id" => $data->id,
                "email" => $data->email
            );
            $_SESSION["LoginSuccess"] = "<script type='text/javascript'>alert('đăng nhập thành công');</script>";
            header("location:index.php?controller=user&action=details");
        } elseif ($countEmail->rowCount() == 0) {
            $_SESSION['errorsEmail'] = "The email or password entered is not associated with any accounts. Find your account and log in.";
            header("location:index.php?controller=user&action=login");
        } elseif ($countPass->rowCount() == 0) {
            $_SESSION['errorsPass'] = "The password entered is incorrect. Forgot password?";
            header("location:index.php?controller=user&action=login");
        }
    }
    public function find($id) {
        $conn = DB::getInstance();
        $query = $conn->query("select * from users where id = $id");
        $data = $query->fetch();
        return $data;
    }
}