<?php
require_once('config/config.php');
require_once('models/BaseModel.php');

class AdminModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->tabelName = 'admin';
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

    public function show($sqlSearch, $sqlOrder, $from, $recordPerPage)
    {
        $query = $this->conn->query("select * from $this->tabelName where del_flag = 0 $sqlSearch $sqlOrder limit  $from,$recordPerPage");
        $count = $this->conn->query("select * from $this->tabelName where del_flag = 0 $sqlSearch $sqlOrder")->rowCount();
        $data = $query->fetchAll();
        return array(
            'data' => $data,
            'count' => $count
        );
    }
}
