<?php
interface BDInterface
{
    public function getById($id, $arr);
    public function getByEmail($email, $arr);
    public function getByEmailAndPass($email, $pass, $arr);
    public function create($data);
    public function update($data, $id);
    public function delete($id);
}