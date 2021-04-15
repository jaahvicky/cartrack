<?php

class VehicleModel extends Model
{

    public function getAll()
    {

        $sql = "select * from $this->table";

        $vehicles = $this->db->getAll($sql);

        return $vehicles;

    }
    public function create($data)
    {
        $currentTime = date('Y-m-d H:i:s');
        $record = [
            'name' => $data['name'],
            'number_plate' => $data['number_plate'],
            'updated_at' => $currentTime,
            'created_at' => $currentTime,
        ];
        $sql = "INSERT INTO $this->table(name,number_plate,updated_at,created_at) VALUES (:name, :number_plate, :updated_at, :created_at)";
        $insertResult = $this->db->insert($sql, $record);
        $lastId = $this->db->getInsertId();

        $sqlGet = "SELECT id,name,number_plate,created_at,updated_at FROM $this->table WHERE id = :id";
        $result = $this->db->getById($sqlGet, $lastId);

        return $result;
    }
    public function getById($id)
    {
        $sql = "SELECT id,name,number_plate,created_at,updated_at FROM $this->table WHERE id = :id";
        return $this->db->getById($sql, $id);
    }
    public function getByNumberPlate($numberPlate)
    {
        $sql = "SELECT id,name,number_plate,created_at,updated_at FROM $this->table WHERE id = :number_plate";
        return $this->db->getByColumn($sql, ['number_plate' => $numberPlate]);
    }
    public function update($id, $data)
    {
        $currentTime = date('Y-m-d H:i:s');
        $record = [
            'name' => $data['name'],
            'number_plate' => $data['number_plate'],
            'updated_at' => $currentTime,
            'id' => $id,
        ];
        $sql = "UPDATE $this->table SET name = :name, number_plate = :number_plate, updated_at = :updated_at WHERE id = :id";
        $updated = $this->db->update($sql, $record);
        $sqlGet = "SELECT id,name,number_plate,created_at,updated_at FROM $this->table WHERE id = :id";
        $result = $this->db->getById($sqlGet, $id);

        return $result;
    }
    public function remove($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        return $this->db->removeById($sql, $id);
    }

}