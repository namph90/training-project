<?php

include "models/AdminModel.php";
class AdminController extends Controller
{
    use AdminModel;
    public function login()
    {
        $this->loadView("login.php");
    }
    public function loginPost()
    {
        $this->loginModel();
    }
    public function logout()
    {
        unset($_SESSION["admin"]);
        header("location:index.php");
    }
    public function create()
    {
        $this->loadView("CreateAdminView.php");
    }
}
