<?php

require_once('config/config.php');
require_once('models/DBInterface.php');

abstract class BaseModel implements BDInterface
{
    protected $tabelName;
    protected $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance();
    }

    public function getById($id, $fields)
    {
        $query = $this->conn->prepare("select $fields from $this->tabelName where  id =:_id and del_flag =:_del_flag");
        $query->execute(array('_id' => $id, '_del_flag' => ACTIVED));
        return $query->fetch();
    }

    public function getByEmail($email, $fields)
    {
        $query = $this->conn->prepare("select $fields from $this->tabelName where  email =:_email and del_flag =:_del_flag");
        $query->execute(array('_email' => $email, '_del_flag' => ACTIVED));
        return $query->fetch();
    }

    public function getByEmailAndPass($email, $pass, $fields)
    {
        $query = $this->conn->prepare("select $fields from $this->tabelName where  email =:_email and password =:_password and del_flag =:_del_flag");
        $query->execute(array('_email' => $email, '_password' => $pass, '_del_flag' => ACTIVED));
        return $query->fetch();
    }

    public function getAll($fields)
    {
        $query = $this->conn->prepare("select $fields from $this->tabelName where del_flag =:_del_flag");
        $query->execute(array('_del_flag' => ACTIVED));
        return $query->fetchAll();
    }

    public function create($data)
    {
        $ins = array(
            'ins_id' => isset($_SESSION['admin']['id']) ? $_SESSION['admin']['id'] : 9999,
            'ins_datetime' => date('Y-m-d H:i:s')
        );
        $fields = array_merge($data, $ins);
        $col = "insert into $this->tabelName (" . implode(" , ", array_keys($fields)) . ")";
        $val = " values('";
        $val .= implode("' , '", array_values($fields)) . "');";
        $this->conn->query("$col $val");

        return $this->conn;
    }

    public function update($data, $id)
    {
        $upd = array(
            'upd_id' => isset($_SESSION['admin']['id']) ? $_SESSION['admin']['id'] : 99999999,
            'upd_datetime' => date('Y-m-d H:i:s')
        );
        $fields = array_merge($data, $upd);
        $sql = "update $this->tabelName set ";
        foreach ($fields as $key => $value) {
            $fields[$key] = " $key = '" . $value . "' ";
        }
        $sql .= implode(" , ", array_values($fields)) . " where id = '" . $id . "';";
        return $this->conn->query((string)$sql);
    }

    public function delete($id)
    {
        $query = $this->conn->prepare("update $this->tabelName set del_flag =:_del_flag where id=:_id");
        $query->execute(array('_del_flag' => BANNED, '_id' => $id));
        return $query;
    }
}