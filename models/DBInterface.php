<?php
interface BDInterface
{
    public function getById($id,$fields);
    public function getByEmail($email, $fields);
    public function getByEmailAndPass($email, $pass, $fields);
    public function getAll($fields);
    public function create($data);
    public function update($data, $id);
    public function delete($id);
}