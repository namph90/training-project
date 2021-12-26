<?php

require_once('config/config.php');

abstract class BaseModel
{
    protected $tabelName;
    protected $active;
    protected $conn;
    public function __construct()
    {
        $this->active = ACTIVED;
        $this->conn = DB::getInstance();
        //can use __set __get
    }

    public function getById($id)
    {;
        $query = $this->conn->query("select * from $this->tabelName where  id = $id and del_flag = $this->active");
        return $query->fetch();
    }

    public function getByEmail($email)
    {
        $query = $this->conn->query("select * from $this->tabelName where  email = '$email' and del_flag = $this->active");
        return $query->fetch();
    }

    public function getByEmailAndPass($email, $pass)
    {
        $query = $this->conn->query("select * from $this->tabelName where  email = '$email' and password = '$pass' and del_flag = $this->active");
        return $query->fetch();
    }

    public function getAll()
    {
        $query = $this->conn->query("select * from $this->tabelName where del_flag = $this->active");
        return $query->fetchAll();
    }

    public function create($data)
    {
        $ins = array(
          'ins_id' => $_SESSION['admin']['id'],
          'ins_datetime' => date('Y-m-d H:i:s')
        );
        $fields = array_merge($data,$ins);
        $col = "insert into $this->tabelName (" . implode(" , ", array_keys($fields)) . ")";
        $val = " values('";
        $val .= implode("' , '", array_values($fields)) . "');";
        $this->conn->query("$col $val");
        return $this->conn;
    }

    function update($data, $id)
    {
        $upd = array(
            'upd_id' => $_SESSION['admin']['id'],
            'upd_datetime' => date('Y-m-d H:i:s')
        );
        $fields = array_merge($data,$upd);
        $sql = "update $this->tabelName set ";
        foreach ($fields as $key => $value) {
            $fields[$key] = " $key = '" . $value . "' ";
        }
        $sql .= implode(" , ", array_values($fields)) . " where id = '" . $id . "';";
        return $this->conn->query((string)$sql);
    }
    function delete ($id) {
        return $this->conn->query("update $this->tabelName set del_flag = 1 where id=$id");
    }
}