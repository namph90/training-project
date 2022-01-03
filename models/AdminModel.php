<?php
require_once('models/BaseModel.php');

class AdminModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->tabelName = 'admin';
    }

    public function checkLogin($email, $pass)
    {
        $fields = "id, email, role";
        $dataGetByEmailPass = $this->getByEmailAndPass($email, $pass, $fields);
        $dataGetByEmail = $this->getByEmail($email, "id");
        return array(
            'dataGetByEmailPass' => $dataGetByEmailPass,
            'dataGetByEmail' => $dataGetByEmail
        );
    }
//index
    public function list($sqlSearch, $sqlOrder, $from, $recordPerPage)
    {
        $sql = "select * from $this->tabelName where del_flag =". ACTIVED ." $sqlSearch $sqlOrder";
        $query = $this->conn->query("$sql limit  $from,$recordPerPage");
        $count = $this->conn->query($sql)->rowCount();
        $data = $query->fetchAll();
        return array(
            'data' => $data,
            'count' => $count
        );
    }
}
