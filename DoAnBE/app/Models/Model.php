<?php
class Model
{
    public static $connection = null;

    public function __construct(){

        # code...
        if(!self::$connection )
        { 
            self::$connection =new mysqli(DB_HOST,DB_USER ,DB_PASS, DB_NAME);
            self::$connection->set_charset('utf8mb4');
        }
        return self::$connection;
    }
    public function select($sql)
    {
        # code...
        $item =[];
        $sql->execute();
        $item = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $item;
    }
}
?>