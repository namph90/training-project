<?php
require_once('models/BaseModel.php');

class UserModel extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
        $this->tabelName = 'users';
    }

    public function list($conditions, $orerBy)
    {
        $searchName = isset($conditions["searchName"]) ? $conditions["searchName"] : "";
        $searchEmail = isset($conditions["searchEmail"]) ? $conditions["searchEmail"] : "";
        $sqlSearch = !empty($conditions["searchName"]) ? (!empty($conditions["searchEmail"]) ?
            "and email like '%$searchEmail%' and name like '%$searchName%'" : "and name like '%$searchName%'") :
            (!empty($_GET["searchEmail"]) ? "and email like '%$searchEmail%'" : " ");

        $sqlOrder = 'order by '. $orerBy['column'].' '. $orerBy['sort_order'];

        $sql = "select * from $this->tabelName where del_flag = " . ACTIVED . " $sqlSearch $sqlOrder";
        $query = $this->conn->query($sql);
        return $query->fetchAll();
    }

    public function checkLogin($email, $pass)
    {
        $dataGetByEmailPass = $this->getByEmailAndPass($email, $pass, ['id', 'email']);
        return array(
            'dataGetByEmailPass' => $dataGetByEmailPass,
        );
    }

    public function getUserBanned($email ,$arr)
    {
        $fields = implode(", ", $arr);
        $query = $this->conn->prepare("select $fields from $this->tabelName where del_flag =:_del_flag and email=:_email");
        $query->execute(array('_del_flag' => BANNED, '_email' => $email));
        return $query->fetch();
    }

}
