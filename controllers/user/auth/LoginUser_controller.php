<?php
require_once('controllers/Base_Controller.php');
require_once('models/UserModel.php');

class LoginUserController extends BaseController
{
    public $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function login()
    {
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $data = $this->model->checkLogin($email, $password);
            $dataGetByEmailPass = $data['dataGetByEmailPass'];
            $dataGetByEmail = $data['dataGetByEmail'];
            $_SESSION['email_create'] = $email;

            if (isset($dataGetByEmailPass->id)) {
                $_SESSION['user'] = array(
                    "id" => $dataGetByEmailPass->id,
                    "email" => $dataGetByEmailPass->email
                );

                unset($_SESSION['email_create']);
                header("location:profile");
            } elseif (!isset($dataGetByEmail->id)) {
                $_SESSION['err_email'] = ERROR_LOGIN_EMAIL;
                header("location:login");
            } elseif (!isset($dataGetByEmailPass->id)) {
                $_SESSION['err_pass'] = ERROR_LOGIN_PASS;
                header("location:login");
            }
        } else {
            if (isset($_SESSION['user'])) {
                header("location:profile");
            }
            require_once('config/fbconfig.php');
            $helper = $fb->getRedirectLoginHelper();
            $permissions = ['email'];
            $loginUrl = $helper->getLoginUrl('https://phn.com/index.php?controller=loginUser&action=loginFb', $permissions);
            $this->render("user/login", ['loginUrl' => $loginUrl]);
        }
    }

    public function logout()
    {
        unset($_SESSION["user"]);
        header("location:login");
    }

    public function loginFb()
    {
        require_once('config/fbconfig.php');
        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
            $response = $fb->get('/me?fields=id,name,email', $accessToken);
            $requestPicture = $fb->get('/me/picture?redirect=false&height=100', $accessToken);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        if (!isset($accessToken)) {
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
        $avatar = $user['id'] . '.jpg';
        $url = $picture['url'];
        $email = $user['email'];
        $check = $this->model->getUserBanned($email, "id");
        $userGetByEmail = $this->model->getByEmail($email, "id");
        if ($check) {
            $id = $check->id;
            $this->model->update(['del_flag' => ACTIVED, 'avatar' => $avatar], $id);
            $path = PATH_UPLOAD_USER . $id;
            $newPath = $path . '/' . $avatar;
            createImageFb($url, $path, $newPath);
        }
        if (!$userGetByEmail) {
            $data = array(
                'name' => $user['name'],
                'email' => $email,
                'avatar' => $avatar
            );
            $result = $this->model->create($data);
            $id = $result->lastInsertId();

            $path = PATH_UPLOAD_USER . $id;
            $newPath = $path . '/' . $avatar;
            createImageFb($url, $path, $newPath);
        }
        $data = $this->model->getByEmail($user['email'], "id, email");
        $_SESSION['user'] = array(
            "id" => $data->id,
            "email" => $data->email
        );
        header("location:profile");
    }

}