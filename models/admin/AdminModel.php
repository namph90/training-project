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
//index
    public function show($sqlSearch, $sqlOrder, $from, $recordPerPage)
    {
        $sql = "select * from $this->tabelName where del_flag = $this->active $sqlSearch $sqlOrder";
        $query = $this->conn->query("$sql limit  $from,$recordPerPage");
        $count = $this->conn->query($sql)->rowCount();
        $data = $query->fetchAll();
        return array(
            'data' => $data,
            'count' => $count
        );
    }
}
