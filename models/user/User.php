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
            unset($_SESSION['email_create']);
            header("location:profile");
        } elseif ($countEmail->rowCount() == 0) {
            $_SESSION['errorsEmail'] = "The email or password entered is not associated with any accounts. Find your account and log in.";
            header("location:login");
        } elseif ($countPass->rowCount() == 0) {
            $_SESSION['errorsPass'] = "The password entered is incorrect. Forgot password?";
            header("location:login");
        }
    }

    public function find($id)
    {
        $conn = DB::getInstance();
        $query = $conn->query("select * from users where id = $id");
        $data = $query->fetch();
        return $data;
    }

    public function loginFbModel()
    {
        require_once ('config/fbconfig.php');
        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
            $response = $fb->get('/me?fields=id,name,email', $accessToken);
            $requestPicture = $fb->get('/me/picture?redirect=false&height=100', $accessToken);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        $me = $response->getGraphUser();
        $picture = $requestPicture->getGraphUser();
        $this->loginFromSocialCallBack($me, $picture);


    }

    public function loginFromSocialCallBack($user, $picture)
    {
        $idUser = $user['id'];
        $name = $user['name'];
        $avatar = $idUser . '.jpg';
        $url = $picture['url'];
        $email = $user['email'];
        $conn = DB::getInstance();
        $query = $conn->query("select email,id from users where email = '$email'");
        $check = $conn->query("select email,id from users where email = '$email' and del_flag=1");
        if($check->rowCount()>0) {
            $id = $check->fetch()->id;
            $conn->query("update users set del_flag = 0 where email = '$email' ");
            $avatar = $idUser . '.jpg';
            if (!file_exists("assets/upload/user/$id")) {
                mkdir("assets/upload/user/$id", 0755, true);
            }
            $img = "assets/upload/user/$id/$avatar";
            file_put_contents($img, file_get_contents($url));
        }
        if ($query->rowCount() == 0) {

            $conn = DB::getInstance();
            $query = $conn->prepare("insert into users set name=:_name,email=:_email,avatar=:_avatar");
            $query->execute(["_name" => $name, "_email" => $email, "_avatar" => $avatar]);
            $id = $conn->lastInsertId();
            if (!file_exists("assets/upload/user/$id")) {
                mkdir("assets/upload/user/$id", 0755, true);
            }
            $img = "assets/upload/user/$id/$avatar";
            file_put_contents($img, file_get_contents($url));
        } else {
            $data = $query->fetch();
            $_SESSION['user'] = array(
                "id" => $data->id,
                "email" => $data->email
            );
            $_SESSION["LoginSuccess"] = "<script type='text/javascript'>alert('đăng nhập thành công');</script>";
            header("location:profile");
        }
    }
}