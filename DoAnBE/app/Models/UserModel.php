<?php
    class UserModel extends Model
    {
        public function addUser($user_name,$pass,$type_user)
        {
            $pass = password_hash($pass, PASSWORD_BCRYPT);
            $sql = parent::$connection->prepare('INSERT INTO `users`(`user_name`, `pass`,`type_user`) VALUES (?,?,?)');
            $sql->bind_param('sss',$user_name,$pass,$type_user);
            return  $sql->execute();
        }
        public function getUser()
        {
            $sql = parent::$connection->prepare('SELECT * FROM users');
            return parent::select($sql);
        }
        public function getUserID($user_name)
        {
            $sql = parent::$connection->prepare('SELECT * FROM users where user_name = ?');
            $sql->bind_param('s',$user_name);

            return parent::select($sql)[0]['id_user'];
        }
        public function getUserByID($id)
        {
            $sql = parent::$connection->prepare('SELECT * FROM users WHERE id_user = ?');
            $sql->bind_param('i',$id);
            return parent::select($sql)[0];
        }
        public function getUserByUsername($username)
        {
            $sql = parent::$connection->prepare('SELECT * FROM users WHERE user_name = ?');
            $sql->bind_param('s',$username);
            return parent::select($sql)[0];

        }
        public function addAddressUser($fullname,$email,$phone,$id_ward,$id_distric,$id_consious,$address_detail,$user_name)
        {
            $sql = parent::$connection->prepare("UPDATE `users` SET `fullname`=?,`email`=?,`phone`=?,`id_ward`=?,`id_distric`=?,`id_consious`=?,`address_detail`=?  WHERE user_name = ?");
            $sql->bind_param('ssiiiiss',$fullname,$email,$phone,$id_ward,$id_distric,$id_consious,$address_detail,$user_name);
            return  $sql->execute();
        
        }
        public function getAddressUser($user_name)
        {
            $sql = parent::$connection->prepare('SELECT `fullname`, `email`, `phone`, `id_ward`, `id_distric`, `id_consious`,`address_detail` FROM users WHERE user_name = ?');
            $sql->bind_param('s',$user_name);
            
            return parent::select($sql)[0];
        }
        public function deleteAddress($user_name)
        {
            $sql = parent::$connection->prepare("UPDATE `users` SET `address` = '' WHERE user_name = ?");
            $sql->bind_param('s',$user_name);
            return  $sql->execute();
        }

    }
    
?>