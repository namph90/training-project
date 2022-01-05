<?php

require_once('controllers/BaseController.php');

class HomeController extends BaseController
{
    public function __construct()
    {
        $this->authenticationAdmin();
    }

    public function index()
    {
        $this->render("layouts/home");
    }

    public function error()
    {
        $this->render("layouts/error");
    }
}
