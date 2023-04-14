<?php
    class TypeBookModel extends Model
    {
        public function getNameTypeBook()
        {
            $sql = parent::$connection->prepare('SELECT * FROM types');
            return parent::select($sql);
        }
        public function getTypeBooks($id)
        {
            $sql = parent::$connection->prepare('SELECT * FROM books INNER JOIN book_types ON books.id_book = book_types.id_book WHERE book_types.id_type = ?');
            $sql->bind_param('i',$id);
            return parent::select($sql);
        }
        public function addTypeBook($id_book, $id_type)
        {
            $sql = parent::$connection->prepare("INSERT INTO `book_types`(`id_book`,`id_type` ) VALUES (?,?)");
            $sql->bind_param('ii', $id_book, $id_type);
           
             return  $sql->execute();
        }
        public function deletetypeBook($id_book)
        {
              $sql= parent::$connection->prepare("DELETE FROM `book_types` WHERE `id_book`= ?");
              $sql->bind_param('i',$id_book);
              return $sql->execute();
        }
    }
    
?>