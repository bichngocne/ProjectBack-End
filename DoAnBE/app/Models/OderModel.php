<?php
class OderModel extends Model
{
    public function getAllOder(){

        $sql = parent::$connection->prepare("SELECT oder.id_oder,oder.fullname , oder.phone , oder.email , books.book_name, books.book_photo, books.author_name, oder_item.quantity, oder_item.price FROM oder_item INNER JOIN oder ON oder_item.invoice_code = oder.id_oder INNER JOIN books ON books.id_book = oder_item.id_product");
        return parent::select($sql);
    }

    // sap xep tang dan bang id 
    public function getSortAscendingID()
    {
        $sql=parent::$connection->prepare(' SELECT oder.id_oder,oder.fullname , oder.phone , oder.email , books.book_name, books.book_photo, books.author_name, oder_item.quantity, oder_item.price FROM oder_item INNER JOIN oder ON oder_item.invoice_code = oder.id_oder INNER JOIN books ON books.id_book = oder_item.id_product ORDER BY `oder`.`id_oder` ASC');
        return parent::select($sql);
    }
    // sap xep giam dan bang id 
    public function getSortDESCID()
    {
        $sql=parent::$connection->prepare(' SELECT oder.id_oder,oder.fullname , oder.phone , oder.email , books.book_name, books.book_photo, books.author_name, oder_item.quantity, oder_item.price FROM oder_item INNER JOIN oder ON oder_item.invoice_code = oder.id_oder INNER JOIN books ON books.id_book = oder_item.id_product ORDER BY `oder`.`id_oder` DESC');
        return parent::select($sql);
    }
    // sap xep tamg dan bang teo ten
        public function getSortASCName()
    {
        $sql=parent::$connection->prepare(' SELECT oder.id_oder,oder.fullname , oder.phone , oder.email , books.book_name, books.book_photo, books.author_name, oder_item.quantity, oder_item.price FROM oder_item INNER JOIN oder ON oder_item.invoice_code = oder.id_oder INNER JOIN books ON books.id_book = oder_item.id_product ORDER BY `books`.`book_name` ASC');
        return parent::select($sql);
    }
    // sap xep giam dan bang ten
    public function getSortDESCName()
    {
        $sql=parent::$connection->prepare(' SELECT oder.id_oder,oder.fullname , oder.phone , oder.email , books.book_name, books.book_photo, books.author_name, oder_item.quantity, oder_item.price FROM oder_item INNER JOIN oder ON oder_item.invoice_code = oder.id_oder INNER JOIN books ON books.id_book = oder_item.id_product ORDER BY `books`.`book_name` DESC');
        return parent::select($sql);
    }
    // sap xep tăng dần theo số lượng
    public function getSortASCQuantity()
    {
        $sql=parent::$connection->prepare(' SELECT oder.id_oder,oder.fullname , oder.phone , oder.email , books.book_name, books.book_photo, books.author_name, oder_item.quantity, oder_item.price FROM oder_item INNER JOIN oder ON oder_item.invoice_code = oder.id_oder INNER JOIN books ON books.id_book = oder_item.id_product ORDER BY `oder_item`.`quantity` ASC');
        return parent::select($sql);
    }
    // sap xep giam dan bang ten
    public function getSortDESCQuantity()
    {
        $sql=parent::$connection->prepare(' SELECT oder.id_oder,oder.fullname , oder.phone , oder.email , books.book_name, books.book_photo, books.author_name, oder_item.quantity, oder_item.price FROM oder_item INNER JOIN oder ON oder_item.invoice_code = oder.id_oder INNER JOIN books ON books.id_book = oder_item.id_product ORDER BY `oder_item`.`quantity` DESC');
        return parent::select($sql);
    }
    }