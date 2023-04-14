<?php
class AddressModel extends Model
{
    public function getAllConscious()
    {

        $sql = parent::$connection->prepare('SELECT * FROM conscious');
        return parent::select($sql);
    }
    public function getDistric($id_conscious)
    {
        $sql = parent::$connection->prepare("SELECT district.id_district , district.id_conscious , district.name
        FROM district INNER JOIN conscious ON district.id_conscious = conscious.id
        WHERE district.id_conscious= ?");
        $sql->bind_param('i', $id_conscious);
        return parent::select($sql);
    }
    public function getWards($id_ward)
    {
        $sql = parent::$connection->prepare("SELECT wards.wards_id , wards.district_id , wards.name
        FROM wards INNER JOIN district ON wards.district_id = district.id_district
        WHERE wards.district_id = ?");
        $sql->bind_param('i', $id_ward);
        return parent::select($sql);
    }
    public function getNameConscious($id_conscious)
    {
        $sql = parent::$connection->prepare('SELECT * FROM conscious where id = ?');
        $sql->bind_param('i', $id_conscious);
        return (parent::select($sql)[0]['name_conscious']);
    }
    public function getNameDistric($id_Distric)
    {
        $sql = parent::$connection->prepare('
        SELECT `name` FROM district where id_district = ?');
        $sql->bind_param('i', $id_Distric);
        return( parent::select($sql)[0]['name']);
    }
    public function getNameward($id_ward)
    {
        $sql = parent::$connection->prepare('SELECT `name` FROM wards where wards_id = ?');
        $sql->bind_param('i', $id_ward);
        return parent::select($sql)[0]['name'];
        // var_dump(parent::select($sql)[0]['name']);
    }
}
