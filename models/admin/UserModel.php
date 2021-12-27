<?php
require_once('config/config.php');
require_once('models/BaseModel.php');

class UserModel extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
        $this->tabelName = 'users';
    }

    public function show($sqlSearch, $sqlOrder)
    {
        $query = $this->conn->query("select * from $this->tabelName where del_flag = $this->active $sqlSearch $sqlOrder");
        return $query->fetchAll();
    }

    public function loginPost($email, $pass)
    {
        $dataGetByEmailPass = $this->getByEmailAndPass($email, $pass);
        $dataGetByEmail = $this->getByEmail($email);
        return array(
            'dataGetByEmailPass' => $dataGetByEmailPass,
            'dataGetByEmail' => $dataGetByEmail
        );
    }

    public function getUserBanned($email)
    {
        $query = $this->conn->query("select * from $this->tabelName where del_flag = $this->banned and email = '$email'");
        return $query->fetch();
    }

}
