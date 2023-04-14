<?php
    class CartModel extends Model
    {
        public function addProductIntoCart($id_book, $soLuong, $id_user)
        {
            $sql = parent::$connection->prepare('INSERT INTO `cart`(`id_book`, `soLuong`, `id_user`) VALUES (?,?,?)');
            $sql->bind_param('iii',$id_book, $soLuong, $id_user);
            return $sql->execute();
        }
        public function getProductByIdUser($id_user)
        {
            $sql = parent::$connection->prepare('SELECT * FROM `cart` INNER JOIN books ON cart.id_book = books.id_book WHERE id_user = ?');
            $sql->bind_param('i',$id_user);
            return parent::select($sql);
        }
        public function updateProductInCart($soLuong,$id_user,$id_book)
        {
            $sql = parent::$connection->prepare('UPDATE `cart` SET `soLuong`=`soLuong`+? WHERE id_user=? and id_book = ?');
            $sql->bind_param('iii', $soLuong,$id_user,$id_book);
            return $sql->execute();
        }
        public function getAllProductInCart()
        {
            $sql = parent::$connection->prepare('SELECT * FROM cart');
            return parent::select($sql);
        }
        public function deleteID($id_book)
        {
            $sql = parent::$connection->prepare('DELETE FROM `cart` WHERE id_book = ?');
            $sql->bind_param('i'    ,$id_book);
            return $sql->execute();
        }
        public function payment($id_user,$fullname,$email,$phone,$id_ward,$id_distric,$id_consious,$address_detail)
        {
            $sql = parent::$connection->prepare('INSERT INTO `oder`( `id_user`, `fullname`,`email`, `phone`,`id_ward`, `id_distric`, `id_consious`, `address_detail`) VALUES (?,?,?,?,?,?,?,?)');
            $sql->bind_param('issiiiis',$id_user,$fullname,$email,$phone,$id_ward,$id_distric,$id_consious,$address_detail);
            $sql->execute();
            return parent::$connection->insert_id;
        }
        public function addOderItem($invoice_code,$id_product,$quantity,$price,$id_voucher)
        {
            $sql = parent::$connection->prepare('INSERT INTO `oder_item`( `invoice_code`, `id_product`, `quantity`, `price`,`id_voucher`) VALUES (?,?,?,?,?)');
            $sql->bind_param('iiiii',$invoice_code,$id_product,$quantity,$price,$id_voucher);
            return $sql->execute();
        }
    }
